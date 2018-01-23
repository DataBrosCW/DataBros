<?php

/**
 * Default model class
 * All models extend this class
 */
abstract class Model
{

    public $db;

    public function __construct()
    {
        $this->db = new DB();
    }
    
}