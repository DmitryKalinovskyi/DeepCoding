<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\IUpdateQueryBuilder;

class UpdateQuery implements IUpdateQueryBuilder, IDBExecutable
{
    private IUpdateQueryBuilder $_updateQueryBuilder;
    private DBContext $_dbContext;
    private array $params = [];

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
        return $this->_updateQueryBuilder->build();
    }

    public function clone(): UpdateQuery
    {
        $clone =  new UpdateQuery($this->_updateQueryBuilder->clone(), $this->_dbContext);
        $clone->params = $this->params;
        return $clone;
    }

    public function execute(array $params = []): array|false
    {
        return $this->_dbContext->execute($this->build(), array_merge($this->params, $params));
    }

    public function useParams(array $params): UpdateQuery
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }
}