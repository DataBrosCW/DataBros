<?php

class DB
{

    protected $pdo = false;  //DB connection resources
    protected $sql;

    /**
     * DB constructor.
     *
     * Instantiate a PDO connection to the database using configuration
     */
    public function __construct(){
        $dsn = config('database.driver').":host=".config('database.host').";dbname="
               .config('database.db_name').";charset=".config('database.charset');
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, config('database.user'), config('database.password'), $opt);
    }

    public function query( $sql )
    {
        $result = $this->pdo->query($sql);
        if (! $result) {
            die($this->errno().':'.$this->error().'<br />Error SQL statement is '.$this->sql.'<br />');
        }

        return $result;
    }


}