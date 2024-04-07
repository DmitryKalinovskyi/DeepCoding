<?php

namespace Framework\orm\Logger;

interface IDBLogger
{
    public function log(string $logInfo): void;
}