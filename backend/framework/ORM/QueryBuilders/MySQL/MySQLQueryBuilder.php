<?php

namespace Framework\ORM\QueryBuilders\MySQL;

use Framework\ORM\QueryBuilders\IDeleteQueryBuilder;
use Framework\ORM\QueryBuilders\IInsertQueryBuilder;
use Framework\ORM\QueryBuilders\IQueryBuilder;
use Framework\ORM\QueryBuilders\ISelectQueryBuilder;
use Framework\ORM\QueryBuilders\IUpdateQueryBuilder;

class MySQLQueryBuilder implements IQueryBuilder
{

    // by default use standard MySQLQueryParts

    public function select(array $columns): ISelectQueryBuilder
    {
        $builder = new MySQLSelect();

        return $builder->select($columns);
    }

    public function update(array $tables): IUpdateQueryBuilder
    {
        $builder = new MySQLUpdate();

        return $builder->update($tables);
    }

    public function delete(): IDeleteQueryBuilder
    {
        return new MySqlDelete();
    }

    public function insert(): IInsertQueryBuilder
    {
        return new MySQLInsert();
    }
}