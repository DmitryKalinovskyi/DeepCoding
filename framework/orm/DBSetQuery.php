<?php

namespace Framework\orm;

use InvalidArgumentException;

abstract class DBSetQuery implements IQueryable
{
    protected array $_wheres = [];
    protected int $_limit = -1;

    protected int $_offset = -1;

    public function whereModify(string $condition): IQueryable{
        $this->_wheres[] = $condition;
        return $this;
    }

    public function limitModify(int $limit): IQueryable{
        if($limit <= 0) throw new InvalidArgumentException("Limit is always positive number.");

        $this->_limit = $limit;

        return $this;
    }

    public function offsetModify(int $offset): IQueryable{
        if($offset < 0) throw new InvalidArgumentException("Offset is always non-negative number.");

        if($offset == 0)
            $this->_offset = -1;
        else
            $this->_offset = $offset;

        return $this;
    }

    public function orderByModify(string $orderBy): IQueryable
    {
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
        foreach($this->_wheres as $whereCond){
            $query .= " WHERE $whereCond";
        }

        // add limit and offset if needed

        if($this->_limit > 0){
            $query .= " LIMIT $this->_limit";
        }

        if($this->_offset > 0){
            $query .= " OFFSET $this->_offset";
        }


        return $query;
    }

    public function orderBy(string $orderBy): IQueryable
    {
        return $this->clone()->orderByModify($orderBy);
    }

    public function where(string $condition): IQueryable{
        return $this->clone()->whereModify($condition);
    }

    public function limit(int $limit): IQueryable
    {
        return $this->clone()->limitModify($limit);
    }

    public function offset(int $offset): IQueryable
    {
        return $this->clone()->offsetModify($offset);
    }
}