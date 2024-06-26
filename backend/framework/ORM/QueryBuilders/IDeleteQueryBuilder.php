<?php

namespace Framework\ORM\QueryBuilders;

interface IDeleteQueryBuilder
{
    public function from(string $tableName): IDeleteQueryBuilder;

    public function where(string $condition): IDeleteQueryBuilder;
    public function build(): string;

    public function clone(): IDeleteQueryBuilder;

}