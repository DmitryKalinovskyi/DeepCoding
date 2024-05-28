<?php

namespace Framework\Middlewares\Controllers;

use Framework\Dependency\IServiceCollection;
use Framework\Middlewares\Routing\Router;

class ControllerMiddleware
{
    public function __invoke(Router $router, IServiceCollection $services, $next): void{
        $parsed = parse_url($_SERVER['REQUEST_URI']);

        $action = $router->getAction($parsed["path"]);
        // validate filters
        // use model binder to apply parameters
        $action();

        $next();
    }
}