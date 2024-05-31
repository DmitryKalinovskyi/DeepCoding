<?php

namespace Framework\ORM\Queries;

interface IDBExecutable
{
    public function execute(array $params): mixed;

    public function useParams(array $params): mixed;
}