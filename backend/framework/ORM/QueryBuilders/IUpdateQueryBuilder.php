<?php

namespace Framework\ORM\QueryBuilders;

interface IUpdateQueryBuilder
{
    public function update(array $tableNames): IUpdateQueryBuilder;

    public function set(string $fieldName, string $variable): IUpdateQueryBuilder;

    public function where(string $condition): IUpdateQueryBuilder;
    public function build(): string;

    public function clone(): IUpdateQueryBuilder;
}