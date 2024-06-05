<?php

namespace Framework\ORM;

use Framework\ORM\Queries\Query;

interface IDBContext
{

    /** Executes built query with given parameters to the database
     * @param string $query
     * @param array|null $params
     * @param bool $returnObjects
     * @param string|null $class
     * @return array|false
     */
    public function execute(string  $query,
                            ?array  $params = null,
                            bool    $returnObjects = false,
                            ?string $class = null): array|false;

    public function setQueryBuilder(string $queryBuilderClass): void;

    public function query(): Query;
}