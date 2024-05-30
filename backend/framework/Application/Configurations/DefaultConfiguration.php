<?php

namespace Framework\Application\Configurations;

use Framework\Application\IAppBuilder;
use Framework\Http\HttpContext;
use Framework\Mapper\RouteMapper;
use Framework\Middlewares\Development\ErrorCatcher;
use Framework\Middlewares\Request\RequestMiddleware;
use Framework\Middlewares\Response\ResponseMiddleware;
use Framework\Middlewares\Routing\Router;

class DefaultConfiguration implements IAppBuilderConfiguration
{
    private bool $isDevelopment;
    public function __construct(bool $isDevelopment = false){
        $this->isDevelopment = $isDevelopment;
    }

    public function configure(IAppBuilder $appBuilder): void
    {
        $appBuilder->services()
            ->addScoped(HttpContext::class)
            ->addScoped(Router::class)
            ->addTransient(RouteMapper::class);

        if($this->isDevelopment)
            $appBuilder->use(ErrorCatcher::class);

        // use request and response middlewares
        $appBuilder->use(RequestMiddleware::class);
        $appBuilder->use(ResponseMiddleware::class);
    }
}