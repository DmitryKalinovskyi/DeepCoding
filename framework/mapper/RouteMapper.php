<?php

namespace Framework\mapper;

use Framework\attributes\Routing\Route;
use Framework\dependency\IServiceCollection;
use Framework\routing\Router;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class RouteMapper
{
    private Router $_router;
    private IServiceCollection $_controllerCollection;

    public function __construct(Router $router, IServiceCollection $controllerCollection){
        $this->_router = $router;
        $this->_controllerCollection = $controllerCollection;
    }


    private function mapControllerMethod(string $route, string $controllerClass, ReflectionMethod $method){
        if($method->getName() == '__construct') return;

        $methodAttributes = $method->getAttributes();

        foreach($methodAttributes as $attribute){
            $attributeInstance = $attribute->newInstance();

            if($attributeInstance instanceof Route){
                /** @var Route $attributeInstance  */

                $methodRoute = $attributeInstance->route;
                $methodRoute = str_replace("%entityName%", strtolower($method->getName()), $methodRoute);

                $fullMethodRoute = $route;

                if($methodRoute !== "/" or empty($methodRoute))
                    $fullMethodRoute .= "/" . $methodRoute;

                $this->_router->get->addRoute($fullMethodRoute, function() use ($controllerClass, $method) {
                    $controller = $this->_controllerCollection->resolve($controllerClass);

                    $methodName = $method->getName();
                    $controller->$methodName();
                });
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    public function mapController(string $route, string $controllerClass){
        // using reflection, check does controller have route attributes.
        $reflectionClass = new ReflectionClass($controllerClass);
        $methods = $reflectionClass->getMethods();

        $controllerName = strtolower($reflectionClass->getShortName());
        $controllerName = str_replace("controller", "", $controllerName);
        $controllerRoute = $route . "/" . $controllerName;

        foreach($methods as $method){
            $this->mapControllerMethod($controllerRoute, $controllerClass, $method);
        }
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

        if(is_dir($controllerDirectory) === false){
            throw new InvalidArgumentException("You need to pass directory.");
        }

        $files = scandir($controllerDirectory);


    }
}