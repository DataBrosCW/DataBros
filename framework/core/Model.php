<?php

/**
 * Default model class
 * All models extend this class
 */
abstract class Model
{

    /**
     * Name of database table holding entity
     */
    public $table;

    /**
     * List of public fields (that me be passed to view, or mass updated)
     */
    public $public_fields = [];

    /**
     * List of private or hidden fields (user password for instance)
     */
    public $private_fields = [];

    /**
     * Holds private properties of an object
     *
     * Private properties can't be mass assigned
     */
    private $private_properties;

    /**
     * Value casting of each attributes (not all fields must be cast)
     */
    public $casts = [];

    /**
     * Hold an instance of DB connection
     */
    protected $db;

    /**
     * Create an instance of the object
     */
    public function __construct( $values = [] )
    {
        $this->db = new DB();

        // Instanciate object property and cast attributes
        foreach ( $this->public_fields as $field ) {
            // Id can't be set manually
            if ( $field == $this->getKeyName() ) {
                continue;
            }

            if ( isset( $values[ $field ] ) ) {
                $property = $values[ $field ];
                settype( $property, $this->casts[ $field ] );
                $this->{$field} = $property;
            }
        }
    }

    /**
     * Modify default getter to get private properties
     */
    public function __get($prop) {
        if(in_array( $prop , $this->private_fields))
            return $this->private_properties[$prop];
        if(in_array( $prop, $this->public_fields))
            return $this->{$prop};
        if ($prop == $this->getKeyName()){
            return $this->{$this->getKeyName()};
        }
    }

    /**
     * Modify default setter to set private properties
     */
    public function __set($prop, $value) {
        if(in_array( $prop, $this->private_fields)) {
            $this->private_properties[$prop] = $value;
            return;
        } elseif (in_array( $prop , $this->public_fields)) {
            $this->{$prop} = $value;
        } elseif ($prop == $this->getKeyName()){
            $this->{$this->getKeyName()} = $value;
        }
    }

    /**
     *  Return the key of the object, id by default
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * Save an object
     */
    public function save()
    {
        // If object has id, then it was already saved in db
        if ( isset( $this->{$this->getKeyName()} ) ) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    /**
     * Create object in database
     */
    public function create()
    {
        // 1 - We prepare the query
        $listOfPublicProperties = implode (", ", $this->public_fields);
        $listOfPrivateProperties = implode (", ", $this->private_fields);

        $valuesCount = count($this->public_fields) + count($this->private_fields);

        $sqlQuery = 'INSERT INTO ' . $this->table
                    . ' ('.$listOfPublicProperties.','.$listOfPrivateProperties.') VALUES'.
                    '(';
        for($i=0;$i<$valuesCount;$i++){
            if ($i == $valuesCount-1){
                $sqlQuery .= '?';
            } else {
                $sqlQuery .= '?,';
            }
        }
        // Finally, we close the query
        $sqlQuery .=');';

        // 2- We get the values
        $values = [];
        foreach ($this->public_fields as $field){
            array_push($values, $this->{$field});
        }
        foreach ($this->private_fields as $field){
            array_push($values, $this->{$field});
        }

        // 3 - We run the query
        try {
            $stmt = $this->db->prepare($sqlQuery);
            $stmt->execute($values);
        } catch(PDOException $e) {
            return false;
        }

        // 4 - We retrieve the id
        $this->{$this->getKeyName()} = $this->db->lastInsertedId();

        return true;
    }

}