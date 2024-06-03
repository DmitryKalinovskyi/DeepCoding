<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner\Runners\Python;

use DeepCode\Modules\CodeRunner\CodeRunner\ICodeRunner;
use DeepCode\Modules\CodeRunner\CodeRunner\RunResult;
use DeepCode\Modules\CodeRunner\CodeRunner\RunRules;

class PythonCodeRunner implements ICodeRunner
{
    public function run(RunRules $runRules): RunResult{
        $codeFile = tempnam(sys_get_temp_dir(), 'code_');
        $inputFile = tempnam(sys_get_temp_dir(), 'input_');

        file_put_contents($codeFile, $runRules->Code);
        file_put_contents($inputFile, $runRules->Input);

        // Construct the Docker command
        $command = sprintf(
            "docker run --rm -v %s:/app/code.py -v %s:/app/input.txt python-runner",
            $codeFile,
            $inputFile
        );

        // Execute the command and capture the output
        $output = shell_exec($command);

        // Cleanup temporary files
        unlink($codeFile);
        unlink($inputFile);

        return $this->parseOutput($output ?? "");


//        $code = tmpfile();
//        fwrite($code, $runRules->Code);
//
//        $input = tmpfile();
//        fwrite($input, $runRules->Input);
//
//        // Construct the Docker command
//        $command = "docker run --rm -v %s:/app/code.py -v %s:/app/input.txt python-runner";
////        $command2 = "docker rm "
//        // Execute the command and capture the output
//        $output = shell_exec($command);
////        shell_exec("docker rm $guid");
//        // parse the output
//
//        $result = new RunResult();
//        $result->MemoryUsed = -1;
//        $result->RunningTime = -1;
//        $result->Output = $output ?? "";
//
//        return $result;
    }

    private function parseOutput(string $output): RunResult{
        // Parse the output
        $result = new RunResult();

        if ($output) {
            $lines = explode("\n", $output);
            $outputStarted = false;
            $outputContent = [];
            foreach ($lines as $line) {
                if (trim($line) === "Output") {
                    $outputStarted = true;
                    continue;
                }

                if (str_starts_with($line, "Runtime:")) {
                    $result->RunningTime = floatval(trim(str_replace("Runtime:", "", $line)));
                    continue;
                }

                if (str_starts_with($line, "Memory:")) {
                    $result->MemoryUsed = floatval(trim(str_replace("Memory:", "", $line)));
                    continue;
                }

                if ($outputStarted) {
                    $outputContent[] = $line;
                }
            }
            $result->Output = implode("\n", $outputContent);
        }

        return $result;
    }
}