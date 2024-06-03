<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

class RunResult
{
    public float $RunningTime;
    public float $MemoryUsed;
    public string $Output;
    public ?array $Errors;
}