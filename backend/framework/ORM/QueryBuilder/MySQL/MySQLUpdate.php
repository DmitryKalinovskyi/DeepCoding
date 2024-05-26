<?php

namespace Framework\ORM\QueryBuilder\MySQL;

use Framework\ORM\QueryBuilder\IUpdateQueryBuilder;
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

    public function set(string $fieldName, string $value): IUpdateQueryBuilder
    {
        $this->set[$fieldName] = $value;
        return $this;
    }

    public function where($condition): IUpdateQueryBuilder
    {
        $this->whereCondition = $condition;
        return $this;
    }

    public function build(): string
    {
        if(empty($this->tableNames))
            throw new InvalidArgumentException("Table names not specified.");

        if(empty($this->set))
            throw new InvalidArgumentException("Fields to set not specified.");

        $query = "UPDATE " . join(', ', $this->tableNames);

        $query .= " SET ";

        foreach($this->set as $field => $value){
            $query .= "$field = $value";
        }

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