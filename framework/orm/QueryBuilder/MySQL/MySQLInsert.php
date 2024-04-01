<?php

namespace Framework\orm\QueryBuilder\MySQL;

use Framework\orm\QueryBuilder\IInsertQueryBuilder;

class MySQLInsert implements IInsertQueryBuilder
{
    private array $_values = [];
    private string $_into;
    private array $_columns = [];

    public function into(string $tableName): IInsertQueryBuilder
    {
        $this->_into = $tableName;
        return $this;
    }

    public function addValue(object $value): IInsertQueryBuilder
    {
        $this->_values[] = $value;

        return $this;
    }

    public function addValues(array $values): IInsertQueryBuilder
    {
        $this->_values = array_merge($this->_values, $values);
        return $this;
    }

    public function build(): string
    {
        if(empty($this->_into))
            throw new \InvalidArgumentException("Into table name not specified.");

        $query = "INSERT INTO " . $this->_into ;
        $columns_specified = empty($this->_columns) === false;

        if($columns_specified){
            $query .= "(" . join(', ', $this->_columns) . ")";
        }

        $query .= " VALUES ";

        $queryValues = [];
        foreach($this->_values as $value){
            $props = [];
            if($columns_specified){
                foreach($value as $key => $fieldValue){
                    if(in_array($key, $this->_columns))
                    $props[] = $fieldValue;
                }
            }
            else{
                foreach($value as $fieldValue){
                    $props[] = $fieldValue;
                }
            }

            $queryValues[] = " (" . join(', ', $props) . ")";

            // take field to select;
        }

        $query .= join(', ', $queryValues);

        return $query;
    }

    public function clone(): IInsertQueryBuilder
    {
        $copy = new MySQLInsert();
        $copy->_columns = $this->_columns;
        $copy->_values = $this->_values;
        $copy->_into = $this->_into;

        return $copy;
    }

    public function columns(array $columns): IInsertQueryBuilder
    {
        $this->_columns = $columns;
        return $this;
    }
}