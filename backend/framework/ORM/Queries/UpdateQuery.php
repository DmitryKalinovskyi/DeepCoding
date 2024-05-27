<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\IUpdateQueryBuilder;

class UpdateQuery implements IUpdateQueryBuilder, IDBExecutable
{
    private IUpdateQueryBuilder $_updateQueryBuilder;
    private DBContext $_dbContext;

    public function __construct(IUpdateQueryBuilder $updateQueryBuilder,
                                DBContext           $dbContext){
        $this->_updateQueryBuilder = $updateQueryBuilder;
        $this->_dbContext = $dbContext;
    }

    public function update(array $tableNames): UpdateQuery
    {
        $this->_updateQueryBuilder->update($tableNames);
        return $this;
    }

    public function set(string $fieldName, string $variable): UpdateQuery
    {
        $this->_updateQueryBuilder->set($fieldName, $variable);
        return $this;
    }

    public function where($condition): UpdateQuery
    {
        $this->_updateQueryBuilder->where($condition);
        return $this;
    }

    public function build(): string
    {
        return $this->build();
    }

    public function clone(): UpdateQuery
    {
        return new UpdateQuery($this->_updateQueryBuilder->clone(), $this->_dbContext);
    }

    public function execute($params = []): array|false
    {
        return $this->_dbContext->execute($this->build(), $params);
    }
}