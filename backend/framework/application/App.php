<?php

namespace Framework\application;

use Exception;
use Framework\dependency\IServiceCollection;
use Framework\dependency\ServiceCollection;
use Framework\middlewares\Middleware;

class App
{
    public IServiceCollection $services;

    public ?Middleware $requestPipeline;

    public function __construct(){
        $this->services = new ServiceCollection();
        $this->requestPipeline = null;
    }

    /**
     * @throws Exception
     */
    public function run(): void{

        if($this->requestPipeline !== null){
            $pipeline = $this->requestPipeline;
            $pipeline();
        }

//
//        // redirect using router.
//        $this->router->redirect($_SERVER['REQUEST_URI']);
    }
}