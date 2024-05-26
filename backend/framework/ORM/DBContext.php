<?php

namespace Framework\ORM;

use Exception;
use Framework\ORM\QueryBuilder\IQueryBuilder;
use Framework\ORM\QueryBuilder\MySQL\MySQLInsert;
use Framework\ORM\QueryBuilder\MySQL\MySQLUpdate;
use Framework\ORM\QueryBuilder\MySQL\MySQLSelect;
use Framework\ORM\QueryBuilder\MySQL\MySQLDelete;
use Framework\ORM\QueryBuilderProxy\ProxyQueryBuilder;
use PDO;

class DBContext
{
    private PDO $_pdo;
    public function __construct($connectionString, $username = "root", $password = ""){
        $this->_pdo = new PDO($connectionString, $username, $password);
    }

    /**
     * @throws Exception
     */
    public function execute(string $query, $params): array|false{
        try{

            $sth = $this->_pdo->prepare($query);
            $sth->execute($params);

            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Builded query: ".$query;

            throw $e;
        }
    }

    public function getDatabaseType(){
        return "MySQL";
    }

    /**
     * @throws Exception
     */
    public function executeAndMap(string $query, $params, $class): array{
        try{

            $sth = $this->_pdo->prepare($query);
            $sth->execute($params);

            $results = [];
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                $instance = new $class();

                foreach($row as $field => $value)
                    $instance->$field = $value;

                $results[] = $instance;
            }

            return $results;
        }
        catch(Exception $e){
            echo "Builded query: ".$query;

            throw $e;
        }

    }

    public function query(): ProxyQueryBuilder{
        // look at the configuration, then choose appropriate service for the database type

        // TODO: several database bindings instead of mysql by default.

        return new ProxyQueryBuilder(
            new MySQLInsert(),
            new MySQLSelect(),
            new MySQLUpdate(),
            new MySQLDelete(),
            $this);
    }

    // methods to allow user prevent query execution.

    public function beginTransaction():bool{
        return $this->_pdo->beginTransaction();
    }

    public function inTransaction(): bool{
        return $this->inTransaction();
    }

    public function rollback(): bool{
        return $this->_pdo->rollBack();
    }
}