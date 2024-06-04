<?php

namespace Framework\ORM\QueryBuilders\MySQL;

use Framework\ORM\QueryBuilders\ISelectQueryBuilder;
use InvalidArgumentException;

class MySQLSelect implements ISelectQueryBuilder
{
    private array $columns = [];
    private array $sources = [];
    private string $whereCondition = "";
    private array $joins = [];
    private array $groupBy = [];
    private string $havingCondition = "";
    private array $orderBy = [];
    private int $limit = -1;
    private int $offset = -1;

    public function build(): string
    {
        if(empty($this->columns))
            throw new InvalidArgumentException("Columns to select not specified.");

        if(empty($this->sources))
            throw new InvalidArgumentException("Source data not specified.");

        $query = "SELECT " . join(',', $this->columns);

        $query .= " FROM " . join(',', $this->sources);

        // joins
        foreach($this->joins as list($joinType, $tableName, $on)){
            $query .= " $joinType JOIN $tableName ON $on";
        }

        if(empty($this->whereCondition) === false){
            $query .= " WHERE " . $this->whereCondition;
        }

        if(!empty($this->groupBy)){
            $query .= " GROUP BY " . join(',', $this->groupBy);
        }

        if(!empty($this->havingCondition)){
            $query .= " HAVING " . $this->havingCondition;
        }

        if(!empty($this->orderBy)){
            $orderByParts = [];
            foreach($this->orderBy as list($columnName, $isAscending)){
                $orderByParts[] = $columnName . ($isAscending ? " ASC" : " DESC");
            }
            $query .= " ORDER BY " . join(',', $orderByParts);
        }

        if($this->limit > 0)
            $query .= " LIMIT " . $this->limit;

        if($this->offset > 0)
            $query .= " OFFSET " . $this->offset;

        return $query;
    }

    public function clone(): ISelectQueryBuilder
    {
        $copy = new MySQLSelect();
        $copy->whereCondition = $this->whereCondition;
        $copy->columns = $this->columns;
        $copy->sources = $this->sources;
        $copy->joins = $this->joins;
        $copy->groupBy = $this->groupBy;
        $copy->havingCondition = $this->havingCondition;
        $copy->orderBy = $this->orderBy;
        $copy->limit = $this->limit;
        $copy->offset = $this->offset;
        return $copy;
    }

    public function select(array $columnNames): ISelectQueryBuilder
    {
        $this->columns = $columnNames;
        return $this;
    }

    public function from(string $source): ISelectQueryBuilder
    {
        $this->sources = [$source];
        return $this;
    }

    public function fromSources(array $sources): ISelectQueryBuilder
    {
        $this->sources = $sources;
        return $this;
    }

    public function where($condition): ISelectQueryBuilder
    {
        $this->whereCondition = $condition;
        return $this;
    }

    public function limit(int $limit): ISelectQueryBuilder
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): ISelectQueryBuilder
    {
        $this->offset = $offset;
        return $this;
    }

    public function orderBy(string $columnName, bool $isAscending = true): ISelectQueryBuilder
    {
        $this->orderBy[] = [$columnName, $isAscending];
        return $this;
    }

    public function orderByColumns(array $columnNames, bool $isAscending = true): ISelectQueryBuilder
    {
        foreach($columnNames as $columnName){
            $this->orderBy($columnName, $isAscending);
        }
        return $this;
    }

    public function clearOrderBy(): ISelectQueryBuilder
    {
        $this->orderBy = [];
        return $this;
    }

    private function queryJoin(string $joinType, string $tableName, string $on): void{
        $this->joins[] = [$joinType, $tableName, $on];
    }

    public function innerJoin(string $tableName, string $on): ISelectQueryBuilder
    {
        $this->queryJoin("INNER", $tableName, $on);
        return $this;
    }

    public function leftJoin(string $tableName, string $on): ISelectQueryBuilder
    {
        $this->queryJoin("LEFT", $tableName, $on);
        return $this;
    }

    public function rightJoin(string $tableName, string $on): ISelectQueryBuilder
    {
        $this->queryJoin("RIGHT", $tableName, $on);
        return $this;
    }

    public function fullJoin(string $tableName, string $on): ISelectQueryBuilder
    {
        // in MySQL full join is actually cross join.
        $this->queryJoin("CROSS", $tableName, $on);
        return $this;
    }

    public function groupBy(array $columnNames): ISelectQueryBuilder
    {
        $this->groupBy = $columnNames;
        return $this;
    }

    public function having(string $condition): ISelectQueryBuilder
    {
        $this->havingCondition = $condition;
        return $this;
    }

}