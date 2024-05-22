<?php

namespace Framework\mapper;

use Framework\attributes\Requests\HttpDelete;
use Framework\attributes\Requests\HttpGet;
use Framework\attributes\Requests\HttpMethod;
use Framework\attributes\Requests\HttpPatch;
use Framework\attributes\Requests\HttpPost;
use Framework\attributes\Requests\HttpPut;
use Framework\attributes\Routing\Route;
use Framework\dependency\IServiceCollection;
use Framework\middlewares\Routing\ControllerRouter;
use Framework\middlewares\routing\ControllerRouter_;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class RouteMapper
{
    private ControllerRouter $_router;
    private IServiceCollection $_controllerCollection;

    public function __construct(ControllerRouter $router, IServiceCollection $controllerCollection){
        $this->_router = $router;
        $this->_controllerCollection = $controllerCollection;
    }


    private function mapControllerMethod(string $route, string $controllerClass, ReflectionMethod $method): void{
        if($method->getName() == '__construct') return;

        $methodAttributes = $method->getAttributes();

        $httpAttributes = [];
        // take http attributes
        foreach($methodAttributes as $attribute){
            if($attribute->newInstance() instanceof HttpMethod)
                $httpAttributes[] = $attribute->newInstance();
        }

        foreach($methodAttributes as $attribute){
            $attributeInstance = $attribute->newInstance();

            if($attributeInstance instanceof Route){
                /** @var Route $attributeInstance  */

                $methodRoute = $attributeInstance->route;
                $methodRoute = str_replace("%entityName%", strtolower($method->getName()), $methodRoute);

                $fullMethodRoute = $route;

                if($methodRoute !== "/" or empty($methodRoute))
                    $fullMethodRoute .= "/" . $methodRoute;

                // select methods based on http attributes
                $routerMethods = [];

                foreach($httpAttributes as $httpAttribute){
                    if($httpAttribute instanceof HttpGet)
                        $routerMethods[] = $this->_router->get;
                    if($httpAttribute instanceof HttpPost)
                        $routerMethods[] = $this->_router->post;
                    if($httpAttribute instanceof HttpPatch)
                        $routerMethods[] = $this->_router->patch;
                    if($httpAttribute instanceof HttpDelete)
                        $routerMethods[] = $this->_router->delete;
                    if($httpAttribute instanceof HttpPut)
                        $routerMethods[] = $this->_router->put;
                }

                if(empty($routerMethods))
                    $routerMethods[] = $this->_router->get;

                foreach($routerMethods as $routerMethod){
                    $routerMethod->addRoute($fullMethodRoute, function() use ($controllerClass, $method) {
                        $controller = $this->_controllerCollection->resolve($controllerClass);

                        $methodName = $method->getName();
                        $controller->$methodName();
//
//                        $actualMethod = $controller->$methodName;
//                        $this->_controllerCollection->invokeFunction($actualMethod);
                    });
                }
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