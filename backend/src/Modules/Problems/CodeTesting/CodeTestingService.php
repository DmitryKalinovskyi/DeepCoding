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
        $testResult->runningTime = 0;
        $testResult->memoryUsed = 0;

        foreach($info->testCases as $testCase){
            $runRules = new RunRules(
                [
                    "code.py" => $info->code,
                    "input.txt" => $testCase->input
                ],
                10,
                255);

            $runResult = $codeRunner->run($runRules);
            // if there are any errors, we skip testing stage.

            if(isset($runResult->errors)){
                $testResult->testCaseResults[] = (object)[
                    "isPassed" => false,
                    "errors" => "Runtime error."
                ];
                $testResult->isPassed = false;
                continue;
            }


            $testingRules = new RunRules(
                ["input.txt" => $testCase->input,
                    "output.txt" => $runResult->output,
                        "code.py" => $info->testingScript], 10, 255);

            // in the $testingResult->output should be true or false, that denotes is test passed or not.
            $testingResult = $testingRunner->run($testingRules);
            if(isset($testingResult->errors))
                throw new \Exception("Error when tried to validate test.");

            $isPassed = strtolower(trim($testingResult->output)) == "true";

            $testResult->testCaseResults[] = (object)[
                "runningTime" => $runResult->runningTime,
                "memoryUsed" => $runResult->memoryUsed,
                "isPassed" => $isPassed,
                "name" => $testCase->name
            ];

            $testResult->runningTime += $runResult->runningTime;
            $testResult->memoryUsed += $runResult->memoryUsed;

            if($isPassed === false)
            $testResult->isPassed = false;
        }

        return $testResult;
    }
}