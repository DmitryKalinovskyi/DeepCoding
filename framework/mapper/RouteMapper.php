<?php

namespace Framework\mapper;

use Framework\dependency\IServiceCollection;
use Framework\routing\Router;

class RouteMapper
{
    private Router $_router;
    private IServiceCollection $_controllerCollection;

    public function __construct(Router $router, IServiceCollection $controllerCollection){
        $this->_router = $router;
        $this->_controllerCollection = $controllerCollection;
    }

    public function mapController(string $route, string $controllerClass){

    }

    /**
     * Recursive controller mapping in folder.
     *
     * @param $route - start of each route.
     * @param $controllerDirectory - directory that will be used to generate routes.
     * @param int $depth - recursion depth.
     * @return void
     */
    public function mapControllers(string $route, string $controllerDirectory, int $depth = -1){

    }
}