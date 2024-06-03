<?php

namespace DeepCode\Modules\Problems\CodeTesting;

class TestInfo
{
    public array $testCases;

    public string $code;
    public string $codeLanguage;

    public string $testingScript;

    public string $testingScriptLanguage;

    public ?float $runtimeLimit = null;

    public ?float $memoryLimit = null;
}