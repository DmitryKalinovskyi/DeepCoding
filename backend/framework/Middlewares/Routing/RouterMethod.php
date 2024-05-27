<?php

namespace Framework\Middlewares\Routing;

use InvalidArgumentException;

class RouterMethod
{
    private array $routesToAction = [];
    public function addRoute(string $route, callable $action): void {
        $parameters = $this->getRouteParameters($route);
        $regexRoute = preg_replace('/\{(\w+)\?\}/', '(?P<$1>[^/]+)?', $route);
        $regexRoute = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $regexRoute);
        $regexRoute = str_replace('/', '\/', $regexRoute);
        $regexRoute = '/^' . $regexRoute . '$/';

        if (isset($this->routesToAction[$regexRoute])) {
            throw new InvalidArgumentException("Url address $route already taken.");
        }

        $this->routesToAction[$regexRoute] = [
            'action' => $action,
            'parameters' => $parameters
        ];
    }


//    public function addRoute(string $route, callable $action): void{
//        // TODO: make parameter matching route
//
//        if(isset($this->routesToAction[$route])){
//            throw new InvalidArgumentException("Url address $route already taken.");
//        }
//
//        $this->routesToAction[$route] = $action;
//    }

//    public function getAction(string $route): callable{
//        return $this->routesToAction[$route];
//    }

    public function getAction(string $route): callable {
        foreach ($this->routesToAction as $pattern => $routeData) {
            if (preg_match($pattern, $route, $matches)) {
                // Filter out numerical keys from matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $action = $routeData['action'];
                return function() use ($action, $params) {
                    return call_user_func_array($action, $params);
                };
            }
        }
        throw new InvalidArgumentException("No route matched for $route.");
    }

    public function getRouteParameters(string $route): array {
        preg_match_all('/\{(\w+)\??}/', $route, $matches);
        return $matches[1]; // Return the list of parameter names
    }

}