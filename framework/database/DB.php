<?php

class DB
{
    const CONN_TYPE_PDO = 'pdo';
    const CONN_TYPE_MYSQLI = 'mysqli';

    private $connection_type;

    protected $pdo;  //DB connection resources
    protected $mysqli;

    protected $sql;

    /**
     * DB constructor.
     *
     * Instantiate a PDO connection to the database using configuration
     */
    public function __construct(){
        $this->connection_type = config('database.connection_type');

        switch ($this->connection_type) {
            case self::CONN_TYPE_PDO:

                $dsn = config('database.driver').":host=".config('database.host').";dbname="
                       .config('database.db_name').";charset=".config('database.charset');
                $opt = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $this->pdo = new PDO($dsn, config('database.user'), config('database.password'), $opt);

                break;

            case self::CONN_TYPE_MYSQLI:

                $this->mysqli = new mysqli(config('database.host'), config('database.user'), config('database.password'),config('database.db_name'));
                break;

            default:
                echo "Error: connection type '".$this->connection_type."' not suppordted" . PHP_EOL;
                exit;
                break;
        }
    }

    public function prepare( $sql )
    {
        return $this->connector()->prepare($sql);
    }

    public function query( $sql )
    {
        $result = $this->connector()->query($sql);

        if (! $result) {
            die($this->errno().':'.$this->error().'<br />Error SQL statement is '.$this->sql.'<br />');
        }
        return $result;
    }

    public function lastInsertedId(){
        if ($this->connector() === $this->mysqli){
            return $this->connector()->insert_id;
        }
        return $this->connector()->lastInsertId();
    }

    /**
     * Return the database connector used
     */
    private function connector(){
        switch ($this->connection_type) {
            case self::CONN_TYPE_PDO:
                return $this->pdo;
                break;

            case self::CONN_TYPE_MYSQLI:
                return $this->mysqli;
                break;

            default:
                echo "Error: connection type '".$this->connection_type."' not suppordted" . PHP_EOL;
                exit;
                break;
        }
    }


}