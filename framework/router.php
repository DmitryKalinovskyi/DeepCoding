<?php

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
        if(isset($this->routes[$url]) === false){
            throw new InvalidArgumentException("Unresolved url address.");
        }

        $this->routes[$url]();
    }
}