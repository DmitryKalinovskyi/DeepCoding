<?php

namespace Framework\middlewares;

use Closure;

// now becomes unused, due to Closure system
abstract class Middleware_deprecated
{
    private ?Closure $_next;
    public function setNext(Closure $next): void{
        $this->_next = $next;
    }

    public function invokeNext(): void{
        $f = $this->_next;
        $f();
    }

    public abstract function __invoke();

//    public function dumpMiddlewarePipeline(){
//       $middleware = $this;
//        while($middleware !== null){
//            var_dump($middleware);
//            $middleware = $middleware->_next;
//        }
//    }
}