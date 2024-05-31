<?php

namespace Framework\Middlewares\Routing;

use InvalidArgumentException;

class RouterMethod
{
    private array $routesToAction = [];
    public function addRoute(string $route, callable $action): void {
        $regexRoute = preg_replace('/\{(\w+)\?}/', '(?P<$1>[^/]+)?', $route);
        $regexRoute = preg_replace('/\{(\w+)}/', '(?P<$1>[^/]+)', $regexRoute);
        $regexRoute = str_replace('/', '\/', $regexRoute);
        $regexRoute = '/^' . $regexRoute . '$/';

        if (isset($this->routesToAction[$regexRoute])) {
            throw new InvalidArgumentException("Url address $route already taken.");
        }

        $this->routesToAction[$regexRoute] = $action;
    }

    public function getRouteAction(string $route): RouteAction {
        foreach ($this->routesToAction as $pattern => $action) {
            if (preg_match($pattern, $route, $matches)) {
                // Filter out numerical keys from matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                return new RouteAction($action, $params);
            }
        }
        throw new InvalidArgumentException("No route matched for $route.");
    }

    public function haveRoutes(): bool{
        return count($this->routesToAction) > 0;
    }

    public function dump_routes(string $method): void{
        echo "<div>";
        echo "$method routes: ";

        foreach($this->routesToAction as $route=>$action){
            echo "<div>". $route."</div>";
        }

        echo "</div>";
    }
}