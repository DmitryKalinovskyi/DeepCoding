<?php

namespace Framework\application;

use Framework\dependency\IServiceCollection;
use Framework\http\HttpContext;
use Framework\middlewares\Cors\CorsMiddleware;
use Framework\routing\Router;

class AppBuilder
{
    private App $_app;

    private Router $_router;

    public function __construct()
    {
        $this->_app = new App();
        $this->_router = new Router();
        $this->_app->services->addSingleton(HttpContext::class, new HttpContext());
    }

    public function useCors(): self{
        $this->useMiddleware(CorsMiddleware::class);
        return $this;
    }

    public function setRouter(Router $router): self{
        $this->_router = $router;
        return $this;
    }

    public function useMiddleware(callable|string $middleware): self{
        $this->_app->useMiddleware($middleware);
        return $this;
    }

    public function build(): App{

        // assign router at the end
        $this->_app->useMiddleware($this->_router);

        return $this->_app;
    }

    public function services(): IServiceCollection{
        return $this->_app->services;
    }
}