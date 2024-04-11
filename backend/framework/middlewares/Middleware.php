<?php

namespace Framework\middlewares;

abstract class Middleware
{
    protected ?Middleware $_next;
    public function setNext(Middleware $next): void{
        $this->_next = $next;
    }
    public abstract function __invoke();

    public function dumpMiddlewarePipeline(){
       $middleware = $this;
        while($middleware !== null){
            var_dump($middleware);
            $middleware = $middleware->_next;
        }
    }
}