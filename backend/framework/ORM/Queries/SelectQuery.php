<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\ISelectQueryBuilder;

class SelectQuery implements ISelectQueryBuilder, IDBExecutable
{
    private ISelectQueryBuilder $_selectQueryBuilder;
    private DBContext $_dbContext;
    public function __construct(ISelectQueryBuilder $selectQueryBuilder, DBContext $dbContext){
        $this->_selectQueryBuilder = $selectQueryBuilder;
        $this->_dbContext = $dbContext;
    }

    public function select(array $columnNames): self
    {
        $this->_selectQueryBuilder->select($columnNames);
        return $this;
    }

    public function from(string $source): self
    {
        $this->_selectQueryBuilder->from($source);
        return $this;
    }

    public function fromSources(array $sources): self
    {
        $this->_selectQueryBuilder->fromSources($sources);
        return $this;
    }

    public function where($condition): self
    {
        $this->_selectQueryBuilder->where($condition);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->_selectQueryBuilder->limit($limit);
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->_selectQueryBuilder->offset($offset);
        return $this;
    }

    public function build(): string
    {
        return $this->_selectQueryBuilder->build();
    }

    public function clone(): self
    {
        $clone = new SelectQuery($this->_selectQueryBuilder->clone(), $this->_dbContext);
        $clone->_asClass = $this->_asClass;
        return $clone;
    }

    private string $_asClass = "";

    public function asClass($class): self{
        $this->_asClass = $class;
        return $this;
    }

    // used by default
    public function asObject(): self{
        $this->_asClass = "";
        return $this;
    }

    public function execute($params = []): array|false
    {
        if(empty($this->_asClass) === false)
            return $this->_dbContext->executeAndMap($this->build(), $params, $this->_asClass);

        return $this->_dbContext->execute($this->build(), $params);
    }

    public function first($params = []): mixed{

        $clone = $this->clone();
        $clone->limit(1);

        $result = $clone->execute($params);

        if(empty($result[0])) return null;

        return $result[0];
    }

    public function orderBy(string $columnName, bool $isAscending = true): self
    {
        $this->_selectQueryBuilder->orderBy($columnName, $isAscending);
        return $this;
    }

    public function orderByColumns(array $columnNames, bool $isAscending = true): self
    {
        $this->_selectQueryBuilder->orderByColumns($columnNames, $isAscending);
        return $this;
    }

    public function clearOrderBy(): self
    {
        $this->_selectQueryBuilder->clearOrderBy();
        return $this;
    }

    public function innerJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->innerJoin($tableName, $on);
        return $this;
    }

    public function leftJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->leftJoin($tableName, $on);
        return $this;
    }

    public function rightJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->rightJoin($tableName, $on);
        return $this;
    }

    public function fullJoin(string $tableName, string $on): self
    {
        $this->_selectQueryBuilder->fullJoin($tableName, $on);
        return $this;
    }

    public function groupBy(array $columnNames): self
    {
        $this->_selectQueryBuilder->groupBy($columnNames);
        return $this;
    }

    public function having(string $condition): self
    {
        $this->_selectQueryBuilder->having($condition);
        return $this;
    }
}