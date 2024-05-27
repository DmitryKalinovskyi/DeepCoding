<?php

namespace Framework\ORM\QueryBuilders;

interface ISelectQueryBuilder
{
    public function select(array $columnNames): ISelectQueryBuilder;

    // inside source, you can put another query, or just type table name
    public function from(string $source): ISelectQueryBuilder;
    public function fromSources(array $sources): ISelectQueryBuilder;

    public function where(string $condition): ISelectQueryBuilder;
    public function limit(int $limit): ISelectQueryBuilder;
    public function offset(int $offset): ISelectQueryBuilder;
    public function orderBy(string $columnName, bool $isAscending = true): ISelectQueryBuilder;
    public function orderByColumns(array $columnNames, bool $isAscending = true): ISelectQueryBuilder;
    public function clearOrderBy(): ISelectQueryBuilder;

    // Joins

    // intersection
    public function innerJoin(string $tableName, string $on): ISelectQueryBuilder;
    public function leftJoin(string $tableName, string $on): ISelectQueryBuilder;
    public function rightJoin(string $tableName, string $on): ISelectQueryBuilder;
    public function fullJoin(string $tableName, string $on): ISelectQueryBuilder;

    // TODO: Add union
//    public function union(string $builtSelect): ISelectQueryBuilder;

    public function groupBy(array $columnNames): ISelectQueryBuilder;

    public function having(string $condition): ISelectQueryBuilder;

    public function build(): string;

    public function clone(): ISelectQueryBuilder;
}