<?php

namespace Framework\Mapper;

use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpGet;
use Framework\Attributes\Requests\HttpMethod;
use Framework\Attributes\Requests\HttpPatch;
use Framework\Attributes\Requests\HttpPost;
use Framework\Attributes\Requests\HttpPut;
use Framework\Attributes\Routing\Route;
use Framework\Dependency\IServiceCollection;
use Framework\Middlewares\Routing\Router;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class RouteMapper
{
    private Router $router;
    private IServiceCollection $controllersServices;

    public function __construct(Router $router, IServiceCollection $controllersServices){
        $this->router = $router;
        $this->controllersServices = $controllersServices;
    }

    private function mapControllerMethod(string $route, string $controllerClass, ReflectionMethod $method): void{
        $methodAttributes = $method->getAttributes();

        $httpAttributes = [];

        // take http Attributes
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

                // select methods based on http Attributes
                $routerMethods = [];

                foreach($httpAttributes as $httpAttribute){
                    if($httpAttribute instanceof HttpGet)
                        $routerMethods[] = $this->router->get;
                    if($httpAttribute instanceof HttpPost)
                        $routerMethods[] = $this->router->post;
                    if($httpAttribute instanceof HttpPatch)
                        $routerMethods[] = $this->router->patch;
                    if($httpAttribute instanceof HttpDelete)
                        $routerMethods[] = $this->router->delete;
                    if($httpAttribute instanceof HttpPut)
                        $routerMethods[] = $this->router->put;
                }

                if(empty($routerMethods))
                    $routerMethods[] = $this->router->get;

                foreach($routerMethods as $routerMethod){
                    $controller = $this->controllersServices->resolve($controllerClass);
                    $methodName = $method->getName();

                    $routerMethod->addRoute($fullMethodRoute,  $controller->$methodName(...));
                }
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    public function mapController(string $route, string $controllerClass): void{
        // using reflection, check does controller have route Attributes.
        $reflectionClass = new ReflectionClass($controllerClass);
        $methods = $reflectionClass->getMethods();

        // check if controller have Route attribute, use it in routing
        $controllerAttributes = $reflectionClass->getAttributes();
        $routeAttribute = null;
        $controllerRelativeRoute = null;
        foreach($controllerAttributes as $controllerAttribute){
            $instance = $controllerAttribute->newInstance();
            if($instance instanceof Route){
                // use that attribute in routing
                $controllerRelativeRoute = $instance->route;
            }

            if($controllerRelativeRoute != null) break;
        }

        if($controllerRelativeRoute == null){
            // use name as route
            $controllerName = strtolower($reflectionClass->getShortName());
            $controllerName = str_replace("controller", "", $controllerName);
            $controllerRelativeRoute = $controllerName;
        }

        $controllerAbsoluteRoute = $route;
        if(!empty($controllerAbsoluteRoute))
            $controllerAbsoluteRoute .= "/" . $controllerRelativeRoute;


        foreach($methods as $method){
            // ignore magic methods
            if(!str_starts_with($method->getName(), "__"))
                $this->mapControllerMethod($controllerAbsoluteRoute, $controllerClass, $method);
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

        // scan dir returns redundant .. and .
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

    private function getClassNameFromFilePath(string $filePath): string
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