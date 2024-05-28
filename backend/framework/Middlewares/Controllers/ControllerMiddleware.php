<?php

namespace Framework\Middlewares\Controllers;

use Closure;
use Framework\Attributes\Filters\RequestFilterAttribute;
use Framework\Dependency\IServiceCollection;
use Framework\Middlewares\Routing\Router;

class ControllerMiddleware
{
    private Router $router;
    private IServiceCollection $services;

    public function __construct(Router $router, IServiceCollection $services){
        $this->services = $services;
        $this->router = $router;
    }

    public function __invoke($next): void{
        $parsed = parse_url($_SERVER['REQUEST_URI']);

        $routeAction = $this->router->getRouteAction($parsed["path"]);

        // validate filters
        $this->validateFilters($routeAction->action);

        // use model binder to apply parameters
        call_user_func_array($routeAction->action, $routeAction->parameters);

        $next();
    }

    private function validateFilters(Closure $action): void{
        $reflectionFunction = new \ReflectionFunction($action);
        $attributes = $reflectionFunction->getAttributes();

        foreach($attributes as $attribute){
            $instance = $attribute->newInstance();

            if($instance instanceof RequestFilterAttribute){
                if(!$this->services->invokeFunction($instance->filter(...))){
                    die();
                }
            }
        }
    }
}