<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

interface ICodeRunner
{
    public function run(RunRules $runRules): RunResult;
}