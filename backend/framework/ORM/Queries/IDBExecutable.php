<?php

namespace Framework\ORM\Queries;

interface IDBExecutable
{
    public function execute($params): mixed;
}