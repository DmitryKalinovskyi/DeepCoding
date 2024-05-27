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

    public function select(array $columnNames): SelectQuery
    {
        $this->_selectQueryBuilder->select($columnNames);
        return $this;
    }

    public function from(string $source): SelectQuery
    {
        $this->_selectQueryBuilder->from($source);
        return $this;
    }

    public function fromSources(array $sources): SelectQuery
    {
        $this->_selectQueryBuilder->fromSources($sources);
        return $this;
    }

    public function where($condition): SelectQuery
    {
        $this->_selectQueryBuilder->where($condition);
        return $this;
    }

    public function limit(int $limit): SelectQuery
    {
        $this->_selectQueryBuilder->limit($limit);
        return $this;
    }

    public function offset(int $offset): SelectQuery
    {
        $this->_selectQueryBuilder->offset($offset);
        return $this;
    }

    public function thenOrderBy(): SelectQuery
    {
        $this->_selectQueryBuilder->thenOrderBy();
        return $this;
    }

    public function build(): string
    {
        return $this->_selectQueryBuilder->build();
    }

    public function clone(): SelectQuery
    {
        return new SelectQuery($this->_selectQueryBuilder->clone(), $this->_dbContext);
    }

    private string $_asClass = "";

    public function asClass($class): SelectQuery{
        $this->_asClass = $class;
        return $this;
    }

    // used by default
    public function asObject(){
        $this->_asClass = "";
        return $this;
    }

    public function execute($params = []): array|false
    {
        if(empty($this->_asClass) === false)
            return $this->_dbContext->executeAndMap($this->build(), $params, $this->_asClass);

        return $this->_dbContext->execute($this->build(), $params);
    }

    public function first($params = []){

        $oldLimit = $this->getLimit();

        $this->limit(1);

        $result = $this->execute($params);

        if(empty($result[0])) return null;

        $this->limit($oldLimit);

        return $result[0];
    }

    public function getSources(): array
    {
        return $this->_selectQueryBuilder->getSources();
    }

    public function getWhere(): string
    {
        return $this->_selectQueryBuilder->getWhere();
    }

    public function getLimit(): int
    {
        return $this->_selectQueryBuilder->getLimit();
    }

    public function getOffset(): int
    {
        return $this->_selectQueryBuilder->getOffset();
    }
}