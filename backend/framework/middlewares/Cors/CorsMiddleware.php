<?php

namespace Framework\middlewares\Cors;

use Framework\middlewares\Middleware;

class CorsMiddleware extends Middleware
{
    public function __invoke()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
    }
}