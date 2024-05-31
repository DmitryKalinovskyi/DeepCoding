<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\IDeleteQueryBuilder;

class DeleteQuery implements IDeleteQueryBuilder, IDBExecutable
{
    private IDeleteQueryBuilder $_deleteQueryBuilder;
    private DBContext $_dbContext;

    private array $params = [];

    public function __construct(IDeleteQueryBuilder $deleteQueryBuilder,
                                DBContext $dbContext){
        $this->_deleteQueryBuilder = $deleteQueryBuilder;
        $this->_dbContext = $dbContext;
    }

    public function from(string $tableName): DeleteQuery
    {
        $this->_deleteQueryBuilder->from($tableName);
        return $this;
    }

    public function where(string $condition): DeleteQuery
    {
        $this->_deleteQueryBuilder->where($condition);
        return $this;
    }

    public function build(): string
    {
        return $this->_deleteQueryBuilder->build();
    }

    public function clone(): DeleteQuery
    {
        return new DeleteQuery($this->_deleteQueryBuilder->clone(), $this->_dbContext);
    }

    public function execute($params = []): array|false
    {
        $params = array_merge($this->params, $params);

        return $this->_dbContext->execute($this->build(), $params);
    }

    public function useParams(array $params): DeleteQuery
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }
}