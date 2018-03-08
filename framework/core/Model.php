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
     * Hold the current sql query, useful for chained methods
     */
    protected $sql_query;

    /**
     * Hold the values for prepared sql query
     */
    protected $sql_values = [];

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
                if (isset($this->casts[ $field ]) && $this->casts[ $field ] != '' && $this->casts[ $field ] != null) {
                    settype( $property, $this->casts[ $field ] );
                }
                $this->{$field} = $property;
            }
        }
    }

    /**
     * Modify default getter to get private properties
     */
    public function __get( $prop )
    {
        if ( in_array( $prop, $this->private_fields ) ) {
            if (isset($this->private_properties[ $prop ])) return $this->private_properties[ $prop ];
            return null;
        }
        if ( in_array( $prop, $this->public_fields ) ) {
            if (isset($this->{$prop})) return $this->{$prop};
            return null;
        }
        if ( $prop == $this->getKeyName() ) {
            return $this->{$this->getKeyName()};
        }
    }

    /**
     * Modify default setter to set private properties
     */
    public function __set( $prop, $value )
    {
        if ( in_array( $prop, $this->private_fields ) ) {
            $this->private_properties[ $prop ] = $value;

            return;
        } elseif ( in_array( $prop, $this->public_fields ) ) {
            $this->{$prop} = $value;
        } elseif ( $prop == $this->getKeyName() ) {
            $this->{$this->getKeyName()} = $value;
        }
    }

    /**
     * Return a new user (used for chained methods)
     */
    static public function instantiate()
    {
        $class = get_called_class();

        return new $class();
    }

    /**
     *  Return the key of the object, id by default
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * ============================= SQL Methods ===========================
     */

    /**
     * Save an object
     */
    public function save()
    {
        // If object has id, then it was already saved in db
        if ( isset( $this->{$this->getKeyName()} ) && $this->{$this->getKeyName()}>0) {
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
        $listOfPublicProperties = implode( ", ", $this->public_fields );
        $listOfPrivateProperties = implode( ", ", $this->private_fields );

        $valuesCount = count( $this->public_fields ) + count( $this->private_fields );

        $this->sql_query = 'INSERT INTO ' . $this->table
                           . ' (' . $listOfPublicProperties . ($listOfPrivateProperties==''?')': ','.  $listOfPrivateProperties . ')').' VALUES' . '(';
        for ( $i = 0; $i < $valuesCount; $i ++ ) {
            if ( $i == $valuesCount - 1 ) {
                $this->sql_query .= '?';
            } else {
                $this->sql_query .= '?,';
            }
        }
        // Finally, we close the query
        $this->sql_query .= ');';

        // 2- We get the values
        $values = [];
        foreach ( $this->public_fields as $field ) {
            if (is_bool($this->{$field})){
                $this->{$field}?array_push($values,1):array_push($values,0);
            } else {
                array_push( $values, $this->{$field} );
            }
        }
        foreach ( $this->private_fields as $field ) {
            if (is_bool($this->{$field})){
                $this->{$field}?array_push($values,1):array_push($values,0);
            } else {
                array_push( $values, $this->{$field} );
            }
        }

        // 3 - We run the query
        try {
            $stmt = $this->db->prepare( $this->sql_query );
            $stmt->execute( $values );
        } catch ( PDOException $e ) {
            throw $e;
        }

        // 4 - We retrieve the id
        $this->{$this->getKeyName()} = $this->db->lastInsertedId();

        return true;
    }

    /**
     * Update object in database
     */
    public function update()
    {
        // 1 - We prepare the query
        $listOfPublicProperties = implode( ", ", $this->public_fields );
        $listOfPrivateProperties = implode( ", ", $this->private_fields );

        $valuesCount = count( $this->public_fields ) + count( $this->private_fields );

        $this->sql_query = 'UPDATE ' . $this->table . ' SET ';

        $values = [];
        foreach ( $this->public_fields as $field ) {
            if (is_bool($this->{$field})){
                $this->{$field}?array_push($values,1):array_push($values,0);
            } else {
                array_push( $values, $this->{$field} );
            }
            $this->sql_query .= $field.' = ?';
            if ($field !== end($this->public_fields)) $this->sql_query .=', ';

        }
        foreach ( $this->private_fields as $field ) {
            if (is_bool($this->{$field})){
                $this->{$field}?array_push($values,1):array_push($values,0);
            } else {
                array_push( $values, $this->{$field} );
            }
            $this->sql_query .= $field.' = ?';
            if ( $field !== end($this->public_fields)) $this->sql_query .=', ';
        }

        // Specify where
        $this->where($this->getKeyName(),$this->id);

        // 3 - We run the query
        try {
            $stmt = $this->db->prepare( $this->sql_query );
            $stmt->execute( $values );
        } catch ( PDOException $e ) {
            throw $e;
        }

        // 4 - We retrieve the id
        $this->{$this->getKeyName()} = $this->db->lastInsertedId();

        return true;
    }


    /**
     * Find by primary_key
     */
    public function find( $id )
    {
        return $this->where($this->getKeyName(),$id)->get();
    }

    public function findOrFail( $id )
    {
        $entity = $this->where($this->getKeyName(),$id)->get();
        if (!$entity){
            $msg = new \Plasticbrain\FlashMessages\FlashMessages();
            $msg->error( 'Oups! We could not find what you\'re looking for...' );

            $this->redirect();
        } else {
            return $entity;
        }
    }

    /**
     * From a database result return an object
     */
    public static function fetch($data){
        $class = get_called_class();
        $object = new $class();
        foreach ($data as $property => $value){
            $object->{$property} = $value;
        }
        return $object;
    }

    /**
     * Apply a sql where clause
     */
    public function where( $column, $value, $operand = '=' )
    {
        if ( $this->sql_query == '' || $this->sql_query == null ) {
            $this->sql_query = 'SELECT * FROM ' . $this->table
                               . ' WHERE ' . $column . ' ' . $operand . ' ? ';
        } elseif( strpos($this->sql_query, 'WHERE') !== false ) {
            $this->sql_query.= 'AND '. $column . ' ' . $operand . ' ? ';
        } else {
            $this->sql_query.= 'WHERE ' . $column . ' ' . $operand . ' ? ';
        }

        array_push($this->sql_values,$value);

        return $this;
    }

    /**
     * Delete an element from the table
     */
    public function delete()
    {
        $this->sql_query = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->getKeyName() . ' =  ?';
        array_push($this->sql_values,$this->{$this->getKeyName()});

        return $this->get();
    }

    /**
     * Apply a sql where clause
     */
    public function all()
    {
        $this->sql_query = 'SELECT * FROM ' . $this->table;

        return $this;
    }

    /**
     * Apply a sql where clause
     */
    public function limit($count)
    {
        $this->sql_query .= ' LIMIT ' . $count;

        return $this;
    }

    /**
     * Closes and execute sql statement
     */
    public function get()
    {
        // 1 - We close the query
        $this->sql_query .= ';';

        // 2 - We run the query
        $stmt = null;
        try {
            $stmt = $this->db->prepare( $this->sql_query );
            $stmt->execute($this->sql_values);
        } catch ( PDOException $e ) {
            throw $e;
        }

        // We convert the result (rows) to object(s)
        $objects = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            array_push($objects, static::fetch($row));
        }

        // We return the obecjt(s) found
        if (count($objects) == 1) {
            return $objects[0];
        } elseif (count($objects) == 0) {
            return null;
        } else {
            return $objects;
        }

    }


}