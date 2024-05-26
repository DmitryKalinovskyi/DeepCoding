<?php

namespace Framework\Application;

use Closure;
use Framework\Dependency\IServiceCollection;

interface IAppBuilder
{
    public function use(Closure|string $middleware): IAppBuilder;

    public function build(): App;

    public function services(): IServiceCollection;
}