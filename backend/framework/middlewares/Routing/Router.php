<?php

namespace Framework\middlewares\Routing;

use Exception;
use Framework\exceptions\RouteNotResolvedException;
use Framework\middlewares\Middleware;

class Router extends Middleware
{
    private RouteNode $_rootNode;

    public function __construct(){
        $this->_rootNode = new RouteNode();
    }

    public function __invoke(): void
    {
        echo " route";
    }

    public function addRoute(string $url, callable $action){
        // home/index?p1=p1&p2=
        
        [$path, $params] = explode('?', $url);

        // split tokens. make route
        $tokens = explode('/', $url);


    }
}