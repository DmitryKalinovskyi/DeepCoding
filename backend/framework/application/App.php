<?php

namespace Framework\application;

use Exception;
use Framework\dependency\IServiceCollection;
use Framework\dependency\ServiceCollection;
use Framework\routing\Router;

class App
{
    public IServiceCollection $services;
    private array $_middlewares;

    public function __construct(){
        $this->services = new ServiceCollection();
    }

    public function useMiddleware(callable|string $middleware): App{
        $this->_middlewares[] = $middleware;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function run(): void{

        // execute middlewares
        foreach($this->_middlewares as $middleware){
            $this->services->resolveMethod($middleware);
        }
//
//        // redirect using router.
//        $this->router->redirect($_SERVER['REQUEST_URI']);
    }
}