<?php

namespace Framework\orm;

use Exception;
use Framework\orm\Logger\IDBLogger;
use Framework\orm\QueryBuilder\IQueryBuilder;
use Framework\orm\QueryBuilder\MySQL\MySQLInsert;
use Framework\orm\QueryBuilder\MySQL\MySQLUpdate;
use Framework\orm\QueryBuilder\MySQL\MySQLSelect;
use Framework\orm\QueryBuilder\MySQL\MySQLDelete;
use Framework\orm\QueryBuilderProxy\ProxyQueryBuilder;
use PDO;

class DBContext
{
    private PDO $_pdo;
    private ?IDBLogger $_logger;

    public function __construct($connectionString, $username = "root", $password = ""){
        $this->_pdo = new PDO($connectionString, $username, $password);
    }

    public function setLogger(IDBLogger $logger): void{
        $this->_logger = $logger;
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
            if(empty($this->_logger) === false){
                $msg = $e->getMessage() . '\n';

                $msg .= $query;

                $this->_logger->log($msg);
            }

            throw $e;
        }
    }

    public function getDatabaseType(){
        return "MySQL";
    }

    public function executeAndMap(string $query, $params, $class): array{
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