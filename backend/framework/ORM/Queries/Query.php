<?php

namespace Framework\ORM\Queries;

use Framework\ORM\DBContext;
use Framework\ORM\QueryBuilders\IDeleteQueryBuilder;
use Framework\ORM\QueryBuilders\IInsertQueryBuilder;
use Framework\ORM\QueryBuilders\IQueryBuilder;
use Framework\ORM\QueryBuilders\ISelectQueryBuilder;
use Framework\ORM\QueryBuilders\IUpdateQueryBuilder;

class Query implements IQueryBuilder
{
    private IQueryBuilder $_queryBuilder;

    private DBContext $_dbContext;

    public function __construct(IQueryBuilder $queryBuilder,
                                DBContext $dbContext
    ){
        $this->_queryBuilder = $queryBuilder;
        $this->_dbContext = $dbContext;
    }

    public function insert(): InsertQuery
    {
        return new InsertQuery($this->_queryBuilder->insert(), $this->_dbContext);
    }

    public function select(array $columns): SelectQuery
    {
        return new SelectQuery($this->_queryBuilder->select($columns), $this->_dbContext);
    }

    public function update(array $tables): UpdateQuery
    {
        return new UpdateQuery($this->_queryBuilder->update($tables), $this->_dbContext);
    }

    public function delete(): DeleteQuery
    {
        return new DeleteQuery($this->_queryBuilder->delete(), $this->_dbContext);
    }
}