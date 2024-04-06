<?php


namespace DeepCode\server;

use Framework\dependency\IServiceCollection;
use Framework\dependency\ServiceCollection;
use Framework\routing\Router;

class Server{
    public Router $router;
    public IServiceCollection $services;

    public function __construct(){
        $this->router = new Router();
        $this->services = new ServiceCollection();
    }
}