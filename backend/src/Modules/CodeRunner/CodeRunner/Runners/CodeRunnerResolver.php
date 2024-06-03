<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner\Runners;

use DeepCode\Modules\CodeRunner\CodeRunner\ICodeRunner;
use DeepCode\Modules\CodeRunner\CodeRunner\Runners\Python\PythonCodeRunner;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Dependency\IServiceCollection;

class CodeRunnerResolver implements ICodeRunnerResolver
{
    #[Resolvable]
    private IServiceCollection $serviceCollection;

    public function getCodeRunner(string $runnerName): ICodeRunner
    {
        $runners = [
            "Python3" => PythonCodeRunner::class
        ];

        if(!key_exists($runnerName, $runners)){
            throw new \InvalidArgumentException("$runnerName is not supported code runner.");
        }

        return $this->serviceCollection->resolve($runners[$runnerName]);
    }

    public function getSupportedRunners(): array{
        return ["Python3"];
    }
}