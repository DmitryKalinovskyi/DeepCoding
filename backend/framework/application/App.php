<?php

namespace Framework\application;

use Closure;
use Exception;
use Framework\dependency\IServiceCollection;
use Framework\dependency\ServiceCollection;
use Framework\middlewares\Middleware_deprecated;

class App
{
    public IServiceCollection $services;

    public Closure $middlewarePipeline;

    public function __construct(){
        $this->services = new ServiceCollection();
    }

    public function run(): void{

        // just run pipeline.
        ($this->middlewarePipeline)();
    }
}