<?php

namespace Framework\orm\QueryBuilder;

/*
 * Class allow to construct default Create, Read, Update, Delete queries.
 */
interface IQueryBuilder {

    // for each of the 4 common operation we create own builder
    public function insert(): IInsertQueryBuilder;
    public function select(array $columns): ISelectQueryBuilder;
    public function update(array $tables): IUpdateQueryBuilder;
    public function delete(): IDeleteQueryBuilder;
}