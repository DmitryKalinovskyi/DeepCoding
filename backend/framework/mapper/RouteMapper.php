<?php

namespace Framework\mapper;

use Framework\attributes\Routing\Route;
use Framework\dependency\IServiceCollection;
use Framework\middlewares\routing\Router;
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


    private function mapControllerMethod(string $route, string $controllerClass, ReflectionMethod $method): void{
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
    public function mapController(string $route, string $controllerClass): void{
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
     * @param $controllersDirectory - directory that will be used to generate routes.
     * @param int $depth - recursion depth.
     * @return void
     * @throws ReflectionException
     */
    public function mapControllers(string $route, string $controllersDirectory, int $depth = -1): void{

        if(is_dir($controllersDirectory) === false){
            throw new InvalidArgumentException("You need to pass directory.");
        }

        $files = array_diff(scandir($controllersDirectory), array('..', '.'));
        foreach($files as $file){
            $fullFileName = "$controllersDirectory/$file";
            if(is_dir($fullFileName)){
                if($depth === -1)
                 $this->mapControllers("$route/$file", $fullFileName);
                else if($depth > 0)
                 $this->mapControllers("$route/$file", $fullFileName, $depth-1);
            }
            else{
                // map controller, to do that get the controller class
                $class = $this->getClassNameFromFilePath($fullFileName);

                $this->mapController($route, $class);
            }
        }
    }

    private function getClassNameFromFilePath($filePath): string
    {
        $contents = file_get_contents($filePath);

        // Match namespace
        preg_match('/namespace\s+(.*?);/s', $contents, $namespaceMatches);
        $namespace = trim($namespaceMatches[1] ?? '');

        // Match class
        preg_match('/class\s+(\w+)/s', $contents, $classMatches);
        $className = trim($classMatches[1] ?? '');

        // Combine namespace and class name
        return $fullClassName = $namespace ? $namespace . '\\' . $className : $className;
    }
}