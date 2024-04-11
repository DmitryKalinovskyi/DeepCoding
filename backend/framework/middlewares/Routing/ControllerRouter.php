<?php

namespace Framework\middlewares\Routing;

use Exception;
use Framework\exceptions\RouteNotResolvedException;
use Framework\middlewares\Middleware;

class ControllerRouter extends Middleware
{
    private RouteNode $_rootNode;

    public function __construct(){
        $this->_rootNode = new RouteNode();
    }

    public function __invoke()
    {
        echo " route";
    }

    public function addRoute(string $url, callable $action){
        // split tokens. make route

    }
}