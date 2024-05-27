<?php

namespace Framework\ORM\QueryBuilders;

/*
 * Class allow to construct default Create, Read, Update, Delete queries.
 */
interface IQueryBuilder {

    public function insert(): IInsertQueryBuilder;
    public function select(array $columns): ISelectQueryBuilder;
    public function update(array $tables): IUpdateQueryBuilder;
    public function delete(): IDeleteQueryBuilder;
}