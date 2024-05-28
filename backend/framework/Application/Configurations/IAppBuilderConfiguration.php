<?php

namespace Framework\Application\Configurations;

use Framework\Application\IAppBuilder;

interface IAppBuilderConfiguration
{
    public function configure(IAppBuilder $appBuilder): void;
}