<?php

namespace Framework\orm;

use Exception;
use Framework\utils\NamingUtils;
use PDO;


/**
 * Manages entities inside the table
 *
 */
class DBSet extends DBSetQuery
{
    private string $_modelClass;
    private string $_tableName;

    private DBContext $_context;

    public function __construct(string $modelClass, DBContext $context)
    {
        $this->_modelClass = $modelClass;
        $this->_tableName = NamingUtils::getTableByClassname($modelClass);
        $this->_context = $context;
    }


    public function select(): array
    {

        $query = $this->buildSelectQuery();

        try{

            // cast query result to collection
            $pdoStatement = $this->_context->execute($query);

            $res = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            // convert all to the table
            $mapped = [];

            foreach($res as $entity){
                $clsEntity = new $this->_modelClass();
                foreach($entity as $prop => $val){
                    $clsEntity->{$prop} = $val;
                }
                $mapped[] = $clsEntity;
            }

            return $mapped;
        }
        catch(Exception $e){
            echo $e->getMessage();
        }

        return [];
    }

    public function buildSelectQuery(): string
    {
        $query = "SELECT * FROM $this->_tableName";

        $query .= $this->buildQueryBody();

        return $query;
    }

    public function count(): int
    {
        $query = "SELECT COUNT(*) as count FROM $this->_tableName ";

        $query .= $this->buildQueryBody();

        $pdoStatement = $this->_context->execute($query);
        $res = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        return $res['count'];
    }

    public function clone(): IQueryable
    {
        $clone = new DBSet($this->_modelClass, $this->_context);

        $clone->_wheres = $this->_wheres;
        $clone->_offset = $this->_offset;
        $clone->_limit = $this->_limit;

        return $clone;
    }
}