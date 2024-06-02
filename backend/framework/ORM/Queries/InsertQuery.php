<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\IInsertQueryBuilder;

class InsertQuery implements IInsertQueryBuilder, IDBExecutable
{
    private IInsertQueryBuilder $_insertQueryBuilder;
    private DBContext $_dbContext;
    private array $params = [];

    public function __construct(IInsertQueryBuilder $insertQueryBuilder,
                                DBContext           $dbContext){
        $this->_insertQueryBuilder = $insertQueryBuilder;
        $this->_dbContext = $dbContext;
    }

    public function execute($params = []): array| false
    {
        $params = array_merge($this->params, $params);

        return $this->_dbContext->execute($this->build(), $params);
    }

    public function into(string $tableName): InsertQuery
    {
        $this->_insertQueryBuilder->into($tableName);
        return $this;
    }

    public function columns(array $columnNames): InsertQuery
    {
        $this->_insertQueryBuilder->columns($columnNames);
        return $this;
    }

    public function build(): string
    {
        return $this->_insertQueryBuilder->build();
    }

    public function clone(): InsertQuery
    {
        $clone = new InsertQuery($this->_insertQueryBuilder->clone(), $this->_dbContext);
        $clone->params = $this->params;
        return $clone;
    }

    public function times(int $times): InsertQuery
    {
        $this->_insertQueryBuilder->times($times);
        return $this;
    }

    public function select(string $selectQuery): InsertQuery
    {
        $this->_insertQueryBuilder->select($selectQuery);
        return $this;
    }

    public function useParams(array $params): InsertQuery
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }
}