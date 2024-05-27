<?php

namespace Framework\ORM\QueryBuilders;

interface IInsertQueryBuilder
{
    /**
     * @param string $tableName target table
     * @return IInsertQueryBuilder
     */
    public function into(string $tableName): IInsertQueryBuilder;

    /**
     * @param array $columnNames
     * @return IInsertQueryBuilder
     */
    public function columns(array $columnNames): IInsertQueryBuilder;

    /**
     * @param int $times how many values will be inserted, by default is one
     * @return IInsertQueryBuilder
     */
    public function times(int $times): IInsertQueryBuilder;

    public function select(string $selectQuery): IInsertQueryBuilder;

    /**
     * @return string built query
     */
    public function build(): string;

    /**
     * @return IInsertQueryBuilder deep clone of the query
     */
    public function clone(): IInsertQueryBuilder;
}