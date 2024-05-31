<?php

namespace Framework\ORM\QueryBuilders\MySQL;

use Framework\ORM\QueryBuilders\IUpdateQueryBuilder;
use InvalidArgumentException;

class MySQLUpdate implements IUpdateQueryBuilder
{

    private array $tableNames = [];
    private array $set = [];
    private string $whereCondition = "";

    public function update(array $tableNames): IUpdateQueryBuilder
    {
        $this->tableNames = $tableNames;
        return $this;
    }

    public function set(string $fieldName, string $variable): IUpdateQueryBuilder
    {
        $this->set[$fieldName] = $variable;
        return $this;
    }

    public function where(string $condition): IUpdateQueryBuilder
    {
        $this->whereCondition = $condition;
        return $this;
    }

    public function build(): string
    {
        if(empty($this->tableNames))
            throw new \Exception("Table names not specified.");

        if(empty($this->set))
            throw new \Exception("Fields to set not specified.");

        $query = "UPDATE " . join(', ', $this->tableNames);

        $query .= " SET ";

        $sets = [];
        foreach($this->set as $field => $value){
            $sets[] = "$field = $value";
        }

        $query .= join(',', $sets);

        if(empty($this->whereCondition) === false){
            $query .= " WHERE " . $this->whereCondition;
        }

        return $query;
    }

    public function clone(): IUpdateQueryBuilder
    {
        $copy = new MySQLUpdate();
        $copy->whereCondition = $this->whereCondition;
        $copy->tableNames = $this->tableNames;
        $copy->set = $this->set;

        return $copy;
    }
}