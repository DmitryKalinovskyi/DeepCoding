<?php

namespace Framework\ORM\QueryBuilder;

interface IUpdateQueryBuilder
{
    public function update(array $tableNames): IUpdateQueryBuilder;

    public function set(string $fieldName, string $value): IUpdateQueryBuilder;

    public function where($condition): IUpdateQueryBuilder;

    public function build(): string;
    public function clone(): IUpdateQueryBuilder;
}