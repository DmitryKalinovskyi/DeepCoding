<?php

namespace Framework\orm;

interface IQueryable
{

    // Aggregation

    public function count(): int;

    /**
     * @param string $orderBy - write field, and ASC|DESC
     * @return IQueryable
     */
    public function orderBy(string $orderBy): IQueryable;

    public function where(string $condition): IQueryable;

    public function limit(int $limit): IQueryable;

    public function offset(int $offset): IQueryable;

    public function select(): array;

    public function first(): mixed;

    public function buildQueryBody(): string;
}