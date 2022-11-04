<?php 

namespace Service;

class Database {
    private $connection;
    private $hasTransaction;
    
    public function __construct(\PDO $connection = null){
        if($this->hasTransaction = !empty($connection)) 
            $this->connection = $connection;
        else $this->connect();
    }

    public function beginTransaction(){
        if(!($this->hasTransaction = $this->connection->beginTransaction()))
            throw new \Exception("Não foi possível iniciar a transação");
    
        return $this;
    }

    public function commit(){
        if(!$this->connection->commit())
            throw new \Exception("Não foi possível concluir transação!");

        $this->disconnect();
        return $this;
    }

    public function rollBack(){
        if(!$this->connection->rollBack())
            throw new \Exception("Não foi possível cancelar transação!");

        $this->disconnect();
        return $this;
    }

    public function execute($query, $parameters = []){
        $typeQuery = $this->getTypeQuery($query);

        if(!$this->connection) $this->connect();

        try {

            $statement = $this->connection->prepare($query);
            $dataToReturn = $statement->execute($parameters);

        } catch(\Exception $error){
            return ($error->getMessage());
        }

        switch($typeQuery){
            case 'select': $dataToReturn = $statement->fetchAll(\PDO::FETCH_ASSOC); break;
            case 'insert': $dataToReturn = $this->connection->lastInsertId();
        }

        if(!$this->hasTransaction)
            $this->disconnect();

        return $dataToReturn;
    }

    private function disconnect(){
        unset($this->connection);
    }

    private function connect(){
        $user = "root";    
        $dbName  = "buzzvel";
        $password = "123456";
        $host = "database";
        $port = "3306";
       
        $connection = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8";  
        
        $this->connection = new \PDO($connection, $user, $password);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    private function getTypeQuery($query){
        $splitted = explode(" ", trim($query));

        if(count($splitted ?? []))
            return strtolower(preg_replace("/\W/", "", trim($splitted[0])));
        
        return false;
    }
   
    public function getConnection(){
        return $this->connection;
    }
}