<?php

namespace Framework\ORM\QueryBuilder\MySQL;

use Framework\ORM\QueryBuilder\IInsertQueryBuilder;
use PDO;

class MySQLInsert implements IInsertQueryBuilder
{
//    private array $_values = [];
//    private object $_value;
    private string $_into;
    private array $_columns = [];

    public function into(string $tableName): IInsertQueryBuilder
    {
        $this->_into = $tableName;
        return $this;
    }

//    public function addValue(object $value): IInsertQueryBuilder
//    {
//        $this->_value = $value;
//
//        return $this;
//    }

    public function build(): string
    {
        if(empty($this->_into))
            throw new \InvalidArgumentException("Into table name not specified.");

        if(empty($this->_columns))
            throw new \InvalidArgumentException("Columns is not specified.");
        $query = "INSERT INTO " . $this->_into ;
//        $columns_specified = empty($this->_columns) === false;

//        if($columns_specified){
            $query .= "(" . join(', ', $this->_columns) . ")";
//        }

        $query .= " VALUES ";


        // make query that requires preparing.


//        $props = [];
//        $keys = [];
//        foreach($this->_value as $key => $fieldValue){
//            if(!$columns_specified || in_array($key, $this->_columns)){
//                $props[] = $fieldValue;
//                $keys[]
//            }
//        }

        $query .= "(" . join(', ', array_fill(0, count($this->_columns), "?")) . ")";


//        $queryValues = [];
//        foreach($this->_values as $value){
//            $props = [];
//
//            if($columns_specified){
//                foreach($value as $key => $fieldValue){
//                    if(in_array($key, $this->_columns))
//                    $props[] = $fieldValue;
//                }
//            }
//            else{
//                foreach($value as $fieldValue){
//                    $props[] = $fieldValue;
//                }
//            }
//
//            $queryValues[] = " (" . join(', ', $props) . ")";
//
//            // take field to select;
//        }
//
//        $query .= join(', ', $queryValues);

        return $query;
    }

    public function clone(): IInsertQueryBuilder
    {
        $copy = new MySQLInsert();
        $copy->_columns = $this->_columns;
//        $copy->_value = $this->_value;
        $copy->_into = $this->_into;

        return $copy;
    }

    public function columns(array $columns): IInsertQueryBuilder
    {
        $this->_columns = $columns;
        return $this;
    }
}