<?php

namespace Framework\orm\QueryBuilder\MySQL;

use Framework\orm\QueryBuilder\IDeleteQueryBuilder;
use Framework\orm\QueryBuilder\IQueryBuilder;
use Framework\orm\QueryBuilder\ISelectQueryBuilder;
use Framework\orm\QueryBuilder\IUpdateQueryBuilder;

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
}