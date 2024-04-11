<?php

namespace Framework\application;

use Framework\dependency\IServiceCollection;
use Framework\http\HttpContext;
use Framework\middlewares\Cors\CorsMiddleware;
use Framework\middlewares\Middleware;
use Framework\middlewares\Routing\ControllerRouter;

class AppBuilder
{
    private App $_app;

    private ControllerRouter $_router;

    private ?Middleware $_lastMiddleware;

    public function __construct()
    {
        $this->_app = new App();
        $this->_router = new ControllerRouter();
        $this->_lastMiddleware = null;
        $this->_app->services->addSingleton(HttpContext::class, new HttpContext());
    }

    public function useCors(): self{
        $this->useMiddleware(new CorsMiddleware());
        return $this;
    }

//    public function setRouter(ControllerRouter $router): self{
//        $this->_router = $router;
//        return $this;
//    }

    public function useMiddleware(Middleware $middleware): self{
        if($this->_lastMiddleware !== null){
            $this->_lastMiddleware->setNext($middleware);
        }
        else{
            $this->_app->requestPipeline = $middleware;
        }

        $this->_lastMiddleware = $middleware;
        return $this;
    }

    public function build(): App{

        // assign router at the end
        $this->useMiddleware($this->_router);

        $app = $this->_app;
        $this->_app = new App();

        return $app;
    }

    public function services(): IServiceCollection{
        return $this->_app->services;
    }
}