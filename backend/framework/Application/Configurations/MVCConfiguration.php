<?php

namespace Framework\Application\Configurations;

use Framework\Application\IAppBuilder;
use Framework\Http\HttpContext;
use Framework\Mapper\RouteMapper;
use Framework\Middlewares\Routing\Router;

class MVCConfiguration implements IAppBuilderConfiguration
{
    public function configure(IAppBuilder $appBuilder): void
    {
        $appBuilder->services()
            ->addScoped(HttpContext::class)
            ->addScoped(Router::class)
            ->addTransient(RouteMapper::class);
    }
}