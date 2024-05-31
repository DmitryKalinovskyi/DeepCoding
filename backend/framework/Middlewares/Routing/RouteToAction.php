<?php

namespace Framework\Middlewares\Routing;

use Closure;

class RouteToAction
{
    public string $route;

    public string $routeRegex;

    public Closure $action;

    public function __construct(string $route, string $routeRegex, Closure $action){
        $this->route = $route;
        $this->routeRegex = $routeRegex;
        $this->action = $action;
    }

}