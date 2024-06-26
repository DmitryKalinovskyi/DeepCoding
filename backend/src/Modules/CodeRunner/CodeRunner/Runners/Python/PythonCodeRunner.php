<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner\Runners\Python;

use DeepCode\Modules\CodeRunner\CodeRunner\ICodeRunner;
use DeepCode\Modules\CodeRunner\CodeRunner\RunResult;
use DeepCode\Modules\CodeRunner\CodeRunner\RunRules;

class PythonCodeRunner implements ICodeRunner
{
    public function run(RunRules $runRules): RunResult{
        $files = [];
        $v = [];
        foreach($runRules->files as $prefix=>$content){
            $tmpFile = tempnam(sys_get_temp_dir(), $prefix);
            file_put_contents($tmpFile, $content);
            $files[] = $tmpFile;
            $v[] = "-v %s:/app/$prefix";
        }

        $v = join(' ', $v);

        // Construct the Docker command
        $command = sprintf(
            "docker run --rm --memory %dm --memory-swap %dm --stop-timeout %d $v python-runner",
            $runRules->memoryLimit,
            $runRules->memoryLimit,
            $runRules->runtimeLimit,
            ...$files
        );

        // Execute the command and capture the output
        $output = shell_exec($command);

        // Cleanup temporary files
        foreach($files as $tmpFile)
        unlink($tmpFile);

        return $this->parseOutput($output ?? "");
    }

    private function parseOutput(string $output): RunResult{
        // Parse the output
        $result = new RunResult();

        $lines = explode("\n", $output);
        $outputStarted = false;
        $outputContent = [];

        if($lines[0] !== "Started") throw new \Exception("Probably docker not started.");
        if($lines[1] === "Exception"){
            $result->errors = [join("\n", array_slice($lines, 2))];
            return $result;
        }
        foreach ($lines as $line) {
            if (trim($line) === "Output") {
                $outputStarted = true;
                continue;
            }

            if (str_starts_with($line, "Runtime:")) {
                $result->runningTime = floatval(trim(str_replace("Runtime:", "", $line)));
                continue;
            }

            if (str_starts_with($line, "Memory:")) {
                $result->memoryUsed = floatval(trim(str_replace("Memory:", "", $line)));
                continue;
            }

            if ($outputStarted) {
                $outputContent[] = $line;
            }
        }
        $result->output = implode("\n", $outputContent);

        return $result;
    }
}