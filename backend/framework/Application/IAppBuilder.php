<?php

namespace Framework\Application;

use Closure;
use Framework\Application\Configurations\IAppBuilderConfiguration;
use Framework\Dependency\IServiceCollection;

interface IAppBuilder
{
    public function use(Closure|string $middleware): IAppBuilder;

    public function build(): App;

    public function services(): IServiceCollection;

    public function useConfiguration(string $appBuilderConfiguration): IAppBuilder;

    public function useConfigurationInstance(IAppBuilderConfiguration $appBuilderConfiguration): IAppBuilder;
}