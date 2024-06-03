<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

class RunResult
{
    public float $runningTime;
    public float $memoryUsed;
    public string $output;
    public ?array $errors;
}