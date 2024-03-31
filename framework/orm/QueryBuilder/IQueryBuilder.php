<?php

namespace Framework\orm\QueryBuilder;

/*
 * Class allow to construct default Read, Update, Delete queries.
 */
interface IQueryBuilder {

    // for each of the 3 common operation we create own builder
    public function select(array $columns): ISelectQueryBuilder;
    public function update(array $tables): IUpdateQueryBuilder;
    public function delete(): IDeleteQueryBuilder;
}