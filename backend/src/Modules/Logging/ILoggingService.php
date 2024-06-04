<?php

namespace DeepCode\Modules\Logging;

interface ILoggingService
{
    public function log(string $message): void;
}