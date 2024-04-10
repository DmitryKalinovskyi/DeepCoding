<?php

namespace Framework\application;

use Exception;
use Framework\dependency\IServiceCollection;
use Framework\dependency\ServiceCollection;
use Framework\routing\Router;

class App
{
    public Router $router;
    public IServiceCollection $services;
    public IServiceCollection $middlewares;

    public function __construct(){
        $this->router = new Router();
        $this->services = new ServiceCollection();
        $this->middlewares = new ServiceCollection();
    }

    /**
     * @throws Exception
     */
    public function handleRequest(): void{
        // redirect using router.
        $this->router->redirect($_SERVER['REQUEST_URI']);
    }
}