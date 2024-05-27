<?php

namespace Framework\ORM\QueryBuilders\MySQL;

use Exception;
use Framework\ORM\QueryBuilders\IDeleteQueryBuilder;
use InvalidArgumentException;

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

    /**
     * @throws Exception table name not specified.
     */
    public function build(): string
    {
        if($this->tableName === "")
            throw new Exception("Table name not specified. You need to invoke from method.");

        $query = "DELETE FROM " . $this->tableName;

        if(!empty($this->whereCondition)){
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