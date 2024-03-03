<?php

namespace Framework\orm;

use InvalidArgumentException;

abstract class DBSetQuery implements IQueryable
{
    protected array $wheres = [];
    protected int $limit = -1;

    protected int $offset = -1;

    public function where(string $condition): IQueryable{
        $this->wheres[] = $condition;

        return $this;
    }

    public function limit(int $limit): IQueryable{
        if($limit <= 0) throw new InvalidArgumentException("Limit is always positive number.");

        $this->limit = $limit;

        return $this;
    }

    public function offset(int $offset): IQueryable{
        if($offset < 0) throw new InvalidArgumentException("Offset is always non-negative number.");

        if($offset == 0)
            $this->offset = -1;
        else
            $this->offset = $offset;

        return $this;
    }

    // builds the query and then returns execution result from database
    public abstract function select(): array;

    public function first(): mixed{
        $this->limit(1);

        $result = $this->select();

        return count($result) > 0 ? $result[0] : null;
    }

    public function buildQueryBody(): string
    {
        $query = "";
        foreach($this->wheres as $whereCond){
            $query .= " WHERE $whereCond";
        }

        // add limit and offset if needed

        if($this->limit > 0){
            $query .= " LIMIT $this->limit";
        }

        if($this->offset > 0){
            $query .= " OFFSET $this->offset";
        }


        return $query;
    }

    public function orderBy(string $orderBy): IQueryable
    {
        // TODO: Implement orderBy() method.
    }
}