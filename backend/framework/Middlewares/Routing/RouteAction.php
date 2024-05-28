<?php

namespace Framework\Middlewares\Routing;

use Closure;

class RouteAction
{
    public Closure $action;

    public array $parameters;

    public function __construct(Closure $action, array $parameters)
    {
        $this->action = $action;
        $this->parameters = $parameters;
    }
}