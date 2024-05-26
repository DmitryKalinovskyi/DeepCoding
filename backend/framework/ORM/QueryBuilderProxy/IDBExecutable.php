<?php

namespace Framework\ORM\QueryBuilderProxy;

interface IDBExecutable
{
    public function execute($params): mixed;
}