<?php

namespace Framework\application;

use Closure;
use Exception;
use Framework\dependency\IServiceCollection;
use Framework\dependency\ServiceCollection;
use Framework\middlewares\Middleware;

class App
{
    public IServiceCollection $services;

    private array $middlewares;

    public function __construct(){
        $this->services = new ServiceCollection();
        $this->middlewares = [];
    }

//    public function useMiddleware(callable $middleware){
//
//    }

//    public function useMiddleware(Middleware $middleware){
//        $requestPipeline[] = $middleware;
//    }

    public function useMiddleware(callable $middleware): self{
        $this->middlewares[] = $middleware;
        return $this;
    }

    private function prepareMiddlewares(): ?Closure{
        $next = null;

        for($i = count($this->middlewares)-1; $i >= 0; $i--){
            $middleware = $this->middlewares[$i];

            $next = function()use($middleware, $next){
                $this->services->invokeFunction($middleware, ["next" => $next]);
            };
        }

        return $next;
    }

    public function run(): void{

        // just run all middlewares.
        $middlewarePipeline = $this->prepareMiddlewares();

        if($middlewarePipeline !== null)
        $middlewarePipeline();

//
//        // redirect using router.
//        $this->router->redirect($_SERVER['REQUEST_URI']);
    }
}