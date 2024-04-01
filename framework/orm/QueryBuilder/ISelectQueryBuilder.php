<?php

namespace Framework\orm\QueryBuilder;

interface ISelectQueryBuilder
{
    public function select(array $columns): ISelectQueryBuilder;

    // inside source, you can put another query, or just type table name
    public function from(string $source): ISelectQueryBuilder;
    public function fromSources(array $sources): ISelectQueryBuilder;
    public function getSources(): array;

    public function where($condition): ISelectQueryBuilder;
    public function getWhere(): string;

    public function limit(int $limit): ISelectQueryBuilder;
    public function getLimit(): int;
    public function offset(int $offset): ISelectQueryBuilder;
    public function getOffset(): int;


    // you can order only in select queries.
    public function orderBy(): ISelectQueryBuilder;
    public function thenOrderBy(): ISelectQueryBuilder;

    public function groupBy(): ISelectQueryBuilder;

    public function build(): string;

    public function clone(): ISelectQueryBuilder;

}