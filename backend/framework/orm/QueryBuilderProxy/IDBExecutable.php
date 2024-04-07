<?php

namespace Framework\orm\QueryBuilderProxy;

interface IDBExecutable
{
    public function execute($params): mixed;
}