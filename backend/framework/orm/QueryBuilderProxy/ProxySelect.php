<?php

namespace Framework\orm\QueryBuilderProxy;

use Framework\orm\DBContext;
use Framework\orm\QueryBuilder\ISelectQueryBuilder;

class ProxySelect implements ISelectQueryBuilder, IDBExecutable
{
    private ISelectQueryBuilder $_selectService;
    private DBContext $_dbContext;
    public function __construct(ISelectQueryBuilder $selectService, DBContext $dbContext){
        $this->_selectService = $selectService;
        $this->_dbContext = $dbContext;
    }

    public function select(array $columns): ProxySelect
    {
        $this->_selectService->select($columns);
        return $this;
    }

    public function from(string $source): ProxySelect
    {
        $this->_selectService->from($source);
        return $this;
    }

    public function fromSources(array $sources): ProxySelect
    {
        $this->_selectService->fromSources($sources);
        return $this;
    }

    public function where($condition): ProxySelect
    {
        $this->_selectService->where($condition);
        return $this;
    }

    public function limit(int $limit): ProxySelect
    {
        $this->_selectService->limit($limit);
        return $this;
    }

    public function offset(int $offset): ProxySelect
    {
        $this->_selectService->offset($offset);
        return $this;
    }

    public function orderBy(): ProxySelect
    {
        $this->_selectService->orderBy();
        return $this;
    }

    public function thenOrderBy(): ProxySelect
    {
        $this->_selectService->thenOrderBy();
        return $this;
    }

    public function groupBy(): ProxySelect
    {
        $this->_selectService->groupBy();
        return $this;
    }

    public function build(): string
    {
        return $this->_selectService->build();
    }

    public function clone(): ProxySelect
    {
        return new ProxySelect($this->_selectService->clone(), $this->_dbContext);
    }

    private string $_asClass = "";

    public function asClass($class): ProxySelect{
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
        return $this->_selectService->getSources();
    }

    public function getWhere(): string
    {
        return $this->_selectService->getWhere();
    }

    public function getLimit(): int
    {
        return $this->_selectService->getLimit();
    }

    public function getOffset(): int
    {
        return $this->_selectService->getOffset();
    }
}