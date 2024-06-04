<?php

namespace DeepCode\Modules\Logging;

class FileLogger implements ILoggingService
{
    private string $path;
    public function __construct(string $path){
        $this->path = $path;
    }

    public function log(string $message): void
    {
        $content = file_get_contents($this->path);
        file_put_contents($this->path, $content."\n".$message);
    }
}