<?php

namespace Framework\ORM\QueryBuilderProxy;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilder\IUpdateQueryBuilder;

class ProxyUpdate implements IUpdateQueryBuilder, IDBExecutable
{
    private IUpdateQueryBuilder $_updateService;
    private DBContext $_dbContext;

    public function __construct(IUpdateQueryBuilder $updateService,
                                DBContext $dbContext){
        $this->_updateService = $updateService;
        $this->_dbContext = $dbContext;
    }

    public function update(array $tableNames): ProxyUpdate
    {
        $this->_updateService->update($tableNames);
        return $this;
    }

    public function set(string $fieldName, string $value): ProxyUpdate
    {
        $this->_updateService->set($fieldName, $value);
        return $this;
    }

    public function where($condition): ProxyUpdate
    {
        $this->_updateService->where($condition);
        return $this;
    }

    public function build(): string
    {
        return $this->build();
    }

    public function clone(): ProxyUpdate
    {
        return new ProxyUpdate($this->_updateService->clone(), $this->_dbContext);
    }

    public function execute($params = []): array|false
    {
        return $this->_dbContext->execute($this->build(), $params);
    }
}