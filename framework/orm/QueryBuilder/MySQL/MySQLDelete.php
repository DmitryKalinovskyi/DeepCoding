<?php

namespace Framework\orm\QueryBuilder\MySQL;

use Cassandra\Exception\InvalidQueryException;
use Framework\orm\QueryBuilder\IDeleteQueryBuilder;
use http\Exception\InvalidArgumentException;

class MySQLDelete implements IDeleteQueryBuilder
{
    private string $tableName = "";
    private string $whereCondition = "";

    public function from(string $tableName): IDeleteQueryBuilder
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function where(string $condition): IDeleteQueryBuilder
    {
        $this->whereCondition = $condition;
        return $this;
    }

    public function build(): string
    {
        if($this->tableName === "")
            throw new InvalidArgumentException("You need to specify FROM tableName");

        $query = "DELETE FROM " . $this->tableName;

        if(empty($this->whereCondition) === false){
            $query .= " WHERE " . $this->whereCondition;
        }

        return $query;
    }

    public function clone(): IDeleteQueryBuilder
    {
        $copy = new MySQLDelete();
        $copy->whereCondition = $this->whereCondition;
        $copy->tableName = $this->tableName;
        return $copy;
    }
}