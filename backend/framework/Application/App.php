<?php

namespace Framework\Application;

use Closure;
use Framework\Dependency\IServiceCollection;
use Framework\Dependency\ServiceCollection;

class App
{
    public IServiceCollection $services;
    public Closure $middlewarePipeline;

    public function __construct(){
        $this->services = new ServiceCollection();
    }

    public function handleRequest(): void{

        // just run pipeline.
        ($this->middlewarePipeline)();
    }
}