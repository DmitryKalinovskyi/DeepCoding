<?php

namespace Framework\Application;

use Closure;
use Framework\Dependency\IServiceCollection;

class AppBuilder implements IAppBuilder
{
    private App $app;

    private array $middlewares;

    public function __construct(){
        $this->app = new App();
    }

    public function use(Closure|string $middleware): IAppBuilder{
        if(gettype($middleware) === "string")
            return $this->useMiddleware($middleware);

        $this->middlewares[] = $middleware;

        return $this;
    }

    private function useMiddleware(string $middlewareClass): IAppBuilder{

        // this function create wrapper callable to the actual middleware, that construct it and execute
        $this->use(function($next) use($middlewareClass){
            $this->services()->invokeFunction($this->services()->resolve($middlewareClass)(...), ["next" => $next]);
        });

        return $this;
    }

    private function prepareMiddlewares(): ?Closure{
        $next = fn() => 1 + 1;

        // link them
        for($i = count($this->middlewares)-1; $i >= 0; $i--){
            $middleware = $this->middlewares[$i];

            $next = function()use($middleware, $next){
                $this->services()->invokeFunction($middleware, ["next" => $next]);
            };
        }

        return $next;
    }

    public function build(): App{
        $this->app->middlewarePipeline = $this->prepareMiddlewares();
        return $this->app;
    }

    public function services(): IServiceCollection{
        return $this->app->services;
    }
}
