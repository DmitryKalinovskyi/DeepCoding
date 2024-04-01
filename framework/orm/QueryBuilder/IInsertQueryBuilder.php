<?php

namespace Framework\orm\QueryBuilder;

interface IInsertQueryBuilder
{
    public function into(string $tableName): IInsertQueryBuilder;

    public function columns(array $columns): IInsertQueryBuilder;
//    public function addValue(object $value): IInsertQueryBuilder;
//    public function addValues(array $values): IInsertQueryBuilder;

    public function build(): string;
    public function clone(): IInsertQueryBuilder;
}