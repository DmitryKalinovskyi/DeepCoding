<?php

namespace DeepCode\Modules\Problems\CodeTesting;

class TestResult
{
    public array $testCaseResults;

    public bool $isPassed;

    public float $runningTime;

    public float $memoryUsed;
}