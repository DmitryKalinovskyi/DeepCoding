<?php

namespace Framework\orm\QueryBuilderProxy;

use Framework\orm\DBContext;
use Framework\orm\QueryBuilder\IInsertQueryBuilder;

class ProxyInsert implements IInsertQueryBuilder, IDBExecutable
{
    private IInsertQueryBuilder $_insertService;
    private DBContext $_dbContext;

    public function __construct(IInsertQueryBuilder $insertService,
                                DBContext $dbContext){
        $this->_insertService = $insertService;
        $this->_dbContext = $dbContext;
    }

    public function execute($params = []): array| false
    {
        return $this->_dbContext->execute($this->build(), $params);
    }

    public function into(string $tableName): ProxyInsert
    {
        $this->_insertService->into($tableName);
        return $this;
    }

    public function columns(array $columns): ProxyInsert
    {
        $this->_insertService->columns($columns);
        return $this;
    }

    public function addValue(object $value): ProxyInsert
    {
        $this->_insertService->addValue($value);
        return $this;
    }

    public function addValues(array $values): ProxyInsert
    {
        $this->_insertService->addValues($values);
        return $this;
    }

    public function build(): string
    {
        return $this->_insertService->build();
    }

    public function clone(): ProxyInsert
    {
        return new ProxyInsert($this->_insertService->clone(), $this->_dbContext);
    }
}