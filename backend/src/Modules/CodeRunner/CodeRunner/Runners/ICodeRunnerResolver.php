<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner\Runners;

use DeepCode\Modules\CodeRunner\CodeRunner\ICodeRunner;

interface ICodeRunnerResolver
{
    public function getCodeRunner(string $runnerName): ICodeRunner;

    public function getSupportedRunners(): array;
}