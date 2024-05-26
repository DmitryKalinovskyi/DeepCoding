<?php

namespace Framework\ORM\QueryBuilder\MySQL;

use Framework\ORM\QueryBuilder\IDeleteQueryBuilder;
use Framework\ORM\QueryBuilder\IInsertQueryBuilder;
use Framework\ORM\QueryBuilder\IQueryBuilder;
use Framework\ORM\QueryBuilder\ISelectQueryBuilder;
use Framework\ORM\QueryBuilder\IUpdateQueryBuilder;

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