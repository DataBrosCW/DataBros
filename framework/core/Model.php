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
     * Value casting of each attributes (not all fields must be cast)
     */
    public $casts = [];

    protected $db;

    public function __construct($values = [])
    {
        $this->db = new DB();

        // Instanciate object property and cast attributes
        foreach ($this->public_fields as $field) {
            if (isset($values[$field])){
               $proerty = $values[$field];
                settype($proerty, $this->private_fields[$field]);
                $this->{$field} = $proerty;
            }
        }
    }
    
}