<?php

namespace Framework\ORM\QueryBuilders\MySQL;

use Framework\ORM\QueryBuilders\IInsertQueryBuilder;
use Framework\ORM\QueryBuilders\ISelectQueryBuilder;
use PDO;

class MySQLInsert implements IInsertQueryBuilder
{
    private string $_into;
    private bool $_insertFromSelect = false;
    private string $_selectQuery = "";
    private array $_columns = [];
    private int $_times = 1;

    public function into(string $tableName): IInsertQueryBuilder
    {
        $this->_into = $tableName;
        return $this;
    }

    public function build(): string
    {
        $query = "INSERT INTO " . $this->_into ;

        if(empty($this->_into))
            throw new \Exception("Into table name not specified.");

        if(empty($this->_columns))
            throw new \Exception("Columns is not specified.");

        if($this->_insertFromSelect){
            $query .= $this->_selectQuery;
        }
        else{
            // add (COL_1, COL_2, COL_3, ..., COL_N) to the query
            $query .= "(" . join(', ', $this->_columns) . ")";

            // create (?, ?, ?, ..., ?)
            $questionMarks = array_fill(0, count($this->_columns), "?");
            $valueLine = "(" . join(',', $questionMarks) . ")";

            // add (?, ?, ?, ..., ?) times $times
            $query .= str_repeat($valueLine, $this->_times);
        }


        return $query;
    }

    public function clone(): IInsertQueryBuilder
    {
        $copy = new MySQLInsert();
        $copy->_columns = $this->_columns;
        $copy->_into = $this->_into;

        return $copy;
    }

    public function columns(array $columnNames): IInsertQueryBuilder
    {
        $this->_columns = $columnNames;
        return $this;
    }

    public function times(int $times): IInsertQueryBuilder
    {
        if($times < 1) throw new \InvalidArgumentException("You should to insert at least one value");

        $this->_times = $times;
        return $this;
    }

    public function select(string $selectQuery): IInsertQueryBuilder
    {
        $this->_insertFromSelect = true;
        $this->_selectQuery = $selectQuery;

        return $this;
    }
}