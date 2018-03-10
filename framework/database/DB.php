<?php

class DB
{
    const CONN_TYPE_PDO = 'pdo';
    const CONN_TYPE_MYSQLI = 'mysqli';

    private $connection_type;

    protected $pdo;  //DB connection resources
    protected $mysqli;

    protected $sql;

    protected $preparedStatement;

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
        $this->preparedStatement = $this->connector()->prepare($sql);
        return $this->preparedStatement;
    }

    public function execute( $attributes = [] )
    {
        // Special case for msqli
        if ($this->connection_type === self::CONN_TYPE_MYSQLI){


            if (count($attributes) > 0){
                try {
                    $result = $this->preparedStatement->bind_param($this->getVarTypesMysqli($attributes), ...$attributes);
                    if (!$result) {
                        throw new Exception("Binding parameters failed: (" . $this->preparedStatement->errno . ") " . $this->preparedStatement->error,2);
                    }
                } catch (ErrorException $e){
                    throw new Exception("Binding parameters failed: (" . $this->getVarTypesMysqli($attributes) . ") :" . print_r($attributes),2);
                }
            }
            if (!$this->preparedStatement->execute()){
                throw new Exception("Execute failed: (" . $this->preparedStatement->errno . ") " . $this->preparedStatement->error,2);
            }

            $res = $this->preparedStatement->get_result();

            if(!is_object($res)) return [];

            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $results[] = $row;
                }
                return $results;
            } else {
                return [];
            }
        }

        // Default behaviour
        try {
            $this->preparedStatement->execute( $attributes );
        }
        catch ( PDOException $e ) {
            throw $e;
        }
        return $this->preparedStatement->fetchAll(PDO::FETCH_ASSOC);
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

    private function getVarTypesMysqli($attributes){
        $string = '';
        foreach ($attributes as $attribute) {
            if (is_float($attribute)){
                $string.='d';
            }elseif (is_int($attribute)){
                $string.='i';
            }else{
                $string.='s';
            }
        }
        return $string;
    }

}