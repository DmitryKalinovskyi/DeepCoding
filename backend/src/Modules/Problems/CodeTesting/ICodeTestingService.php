<?php

namespace DeepCode\Modules\Problems\CodeTesting;

use DeepCode\Modules\CodeRunner\CodeRunner\RunResult;

interface ICodeTestingService
{
    public function test(TestInfo $info): TestResult;

        // the task of tester code is to read input.txt, also read output.txt, and validate answer.
        //
        //
        // part of testing consist of 3 stages, preparing test.txt, run $code with test.txt, then result
}