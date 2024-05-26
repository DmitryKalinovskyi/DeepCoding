<?php

namespace Framework\Middlewares\Routing;

use InvalidArgumentException;

class ControllerRouterMethod
{
    private array $routes;

    public function __construct(){
        $this->routes = [];
    }

    public function addRoute($url, callable $callback): void{
        if(isset($this->routes[$url])){
            throw new InvalidArgumentException("Url address $url already taken.");
        }

        $this->routes[$url] = $callback;
    }

    public function handleRoute($url): void{
        $parts = explode('?', $url);
        $path = $parts[0];
        $args = $parts[1] ?? '';

        if(isset($this->routes[$path]) === false){
            throw new InvalidArgumentException("Unresolved url address ($url).");
        }

        $this->routes[$path]();
    }
}