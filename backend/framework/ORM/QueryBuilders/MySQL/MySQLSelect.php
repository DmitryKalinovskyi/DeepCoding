<?php

namespace Framework\ORM\QueryBuilders\MySQL;

use Framework\ORM\QueryBuilders\ISelectQueryBuilder;
use InvalidArgumentException;

class MySQLSelect implements ISelectQueryBuilder
{

    private array $columns = [];
    private array $sources = [];
    private string $whereCondition = "";

    private int $limit = -1;
    private int $offset = -1;

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

    public function orderBy(): ISelectQueryBuilder
    {
        // TODO: Implement orderBy() method.
        return $this;
    }

    public function thenOrderBy(): ISelectQueryBuilder
    {
        // TODO: Implement thenOrderBy() method.
        return $this;

    }

    public function groupBy(): ISelectQueryBuilder
    {
        // TODO: Implement groupBy() method.
        return $this;

    }

    public function build(): string
    {
        if(empty($this->columns))
            throw new InvalidArgumentException("Columns to select not specified.");

        if(empty($this->sources))
            throw new InvalidArgumentException("Source data not specified.");

        $query = "SELECT " . join(', ', $this->columns);

        $query .= " FROM " . join(', ', $this->sources);

        if(empty($this->whereCondition) === false){
            $query .= " WHERE " . $this->whereCondition;
        }

        if($this->limit > 0)
            $query .= " LIMIT " . $this->limit;

        if($this->offset > 0)
            $query .= " OFFSET " . $this->offset;

        return $query;
    }

    public function clone(): ISelectQueryBuilder
    {
        // TODO: Implement clone() method.

        $copy = new MySQLSelect();
        $copy->whereCondition = $this->whereCondition;
        $copy->limit = $this->limit;
        $copy->offset = $this->offset;
        $copy->columns = $this->columns;
        $copy->sources = $this->sources;
        return $copy;
    }

    public function getSources(): array
    {
        return $this->sources;
    }

    public function getWhere(): string
    {
        return $this->whereCondition;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}