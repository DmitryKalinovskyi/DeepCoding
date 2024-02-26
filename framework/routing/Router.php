<?php

namespace Framework\routing;

use InvalidArgumentException;

class Router{

    private array $routes;

    public function __construct(){
        $this->routes = [];
    }

    public function AddRoute($url, callable $callback): void{
        if(isset($this->routes[$url])){
            throw new InvalidArgumentException("Current url address already taken.");
        }

        $this->routes[$url] = $callback;
    }

    public function HandleRoute($url): void{
        $parts = explode('?', $url);
        $path = $parts[0];
        $args = $parts[1] ?? '';

        if(isset($this->routes[$path]) === false){
            throw new InvalidArgumentException("Unresolved url address.");
        }

        $this->routes[$path]();
    }
}