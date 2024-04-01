<?php

namespace Framework\orm\QueryBuilderProxy;

use Framework\orm\DBContext;
use Framework\orm\QueryBuilder\IDeleteQueryBuilder;

class ProxyDelete implements IDeleteQueryBuilder, IDBExecutable
{
    private IDeleteQueryBuilder $_deleteService;
    private DBContext $_dbContext;

    public function __construct(IDeleteQueryBuilder $deleteService,
                                DBContext $dbContext){
        $this->_deleteService = $deleteService;
        $this->_dbContext = $dbContext;
    }

    public function from(string $tableName): ProxyDelete
    {
        $this->_deleteService->from($tableName);
        return $this;
    }

    public function where(string $condition): ProxyDelete
    {
        $this->_deleteService->where($condition);
        return $this;
    }

    public function build(): string
    {
        return $this->_deleteService->build();
    }

    public function clone(): ProxyDelete
    {
        return new ProxyDelete($this->_deleteService->clone(), $this->_dbContext);
    }

    public function execute($params = []): array|false
    {
        return $this->_dbContext->execute($this->build(), $params);
    }
}