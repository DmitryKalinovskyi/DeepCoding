<?php

namespace Framework\Middlewares\Routing;

interface IRouter
{
    public function get(string $path, callable $action);
    public function post(string $path, callable $action);
    public function put(string $path, callable $action);
    public function patch(string $path, callable $action);
    public function delete(string $path, callable $action);
    public function options(string $path, callable $action);
    public function any(string $path, callable $action);
    public function match(array $routerMethods, string $path, callable $action);
}