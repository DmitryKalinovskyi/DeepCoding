<?php

namespace Framework\ORM;

use Exception;
use Framework\ORM\QueryBuilders\IQueryBuilder;
use Framework\ORM\QueryBuilders\MySQL\MySQLInsert;
use Framework\ORM\QueryBuilders\MySQL\MySQLQueryBuilder;
use Framework\ORM\QueryBuilders\MySQL\MySQLUpdate;
use Framework\ORM\QueryBuilders\MySQL\MySQLSelect;
use Framework\ORM\QueryBuilders\MySQL\MySQLDelete;
use Framework\ORM\Queries\Query;
use PDO;

class DBContext
{
    private PDO $_pdo;
    public function __construct($connectionString, $username = "root", $password = ""){
        $this->_pdo = new PDO($connectionString, $username, $password);
        $this->setQueryBuilder(QueryBuilders\MySQL\MySQLQueryBuilder::class);
    }

    /**
     * Executes a query and returns the results.
     *
     * @param string $query
     * @param array|null $params
     * @param bool $returnObjects Whether to return objects (default: false)
     * @param string|null $class Class name for object conversion (if $returnObjects is true)
     * @return array|false
     * @throws Exception
     */
    public function execute(string $query, ?array $params = null, bool $returnObjects = false, ?string $class = null): array|false
    {
        try {
            $sth = $this->_pdo->prepare($query);
            $sth->execute($params);

            if ($returnObjects) {
                $results = [];
                while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                    if ($class) {
                        $instance = new $class();
                        foreach ($row as $property => $value) {
                            $instance->$property = $value;
                        }
                        $results[] = $instance;
                    } else {
                        $results[] = (object)$row;
                    }
                }
                return $results;
            } else {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            echo "Built query: " . $query;
            throw $e;
        }
    }

    private string $_queryBuilderClass;

    public function setQueryBuilder(string $queryBuilderClass): void{
        if(is_subclass_of($queryBuilderClass, IQueryBuilder::class)){
            $this->_queryBuilderClass = $queryBuilderClass;
        }
        else{
            throw new Exception("$queryBuilderClass is not subclass of " . IQueryBuilder::class);
        }
    }

    public function query(): Query{
        // look at the configuration, then choose appropriate query builder for the database type
        return new Query(new $this->_queryBuilderClass(),
            $this);
    }

    // methods to allow user prevent query execution.

    public function beginTransaction():bool{
        return $this->_pdo->beginTransaction();
    }

    public function inTransaction(): bool{
        return $this->inTransaction();
    }

    public function commit(): bool{
        return $this->_pdo->commit();
    }

    public function rollback(): bool{
        return $this->_pdo->rollBack();
    }
}