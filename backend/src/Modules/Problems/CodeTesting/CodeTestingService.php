<?php

namespace DeepCode\Modules\Problems\CodeTesting;

use DeepCode\Modules\CodeRunner\CodeRunner\Runners\ICodeRunnerResolver;
use DeepCode\Modules\CodeRunner\CodeRunner\RunResult;
use DeepCode\Modules\CodeRunner\CodeRunner\RunRules;
use Framework\Attributes\Dependency\Resolvable;

class CodeTestingService implements ICodeTestingService
{

    #[Resolvable]
    private ICodeRunnerResolver $resolver;

    public function test(TestInfo $info): TestResult
    {
        // get code runner for code
        $codeRunner = $this->resolver->getCodeRunner($info->codeLanguage);
        $testingRunner = $this->resolver->getCodeRunner($info->testingScriptLanguage);

        $testResult = new TestResult();
        $testResult->testCaseResults = [];
        $testResult->isPassed = true;

        foreach($info->testCases as $testCase){
            $runRules = new RunRules($info->code,
                $testCase->input,
                10,
                255);

            $runResult = $codeRunner->run($runRules);
            // if there are any errors, we skip testing stage.

            if($runResult->errors != null){
                $testResult->testCaseResults[] = (object)[
                    "isPassed" => false,
                    "errors" => "Runtime error."
                ];
                continue;
            }


            $testingRules = new RunRules($info->testingScript,
                $runResult->output, 10, 255);

            // in the $testingResult->output should be true or false, that denotes is test passed or not.
            $testingResult = $testingRunner->run($testingRules);
            $isPassed = strtolower($testingResult->output) == "true";

            $testResult->testCaseResults[] = (object)[
                "runningTime" => $runResult->runningTime,
                "memoryUsed" => $runResult->memoryUsed,
                "isPassed" => $isPassed
            ];
        }

        return $testResult;
    }
}