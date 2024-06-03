<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner\DockerCompilers\Python;

use DeepCode\Modules\CodeRunner\CodeRunner\ICodeRunner;
use DeepCode\Modules\CodeRunner\CodeRunner\RunResult;
use DeepCode\Modules\CodeRunner\CodeRunner\RunRules;

class PythonCodeRunner implements ICodeRunner
{
    public function run(RunRules $runRules): RunResult{
        // Ensure the code is escaped properly to prevent injection attacks
        $escapedCode = escapeshellarg($runRules->Code);

        // Construct the Docker command
        $command = "docker run --rm python-runner \"$escapedCode\"";

        // Execute the command and capture the output
        $output = shell_exec($command);

        // parse the output

        $result = new RunResult();
        $result->MemoryUsed = -1;
        $result->RunningTime = -1;
        $result->Output = $output ?? "";

        return $result;
    }
}