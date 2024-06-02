<?php

namespace DeepCode\Modules\CodeRunner\CodeRunner;

class CodeRunner
{
    public function run(string $code): string{

        // Ensure the code is escaped properly to prevent injection attacks
        $escapedCode = escapeshellarg($code);

        // Construct the Docker command
        $command = "docker run --rm python-runner \"$escapedCode\"";

        // Execute the command and capture the output
        $output = shell_exec($command);

        return $output ?? "";
    }
}