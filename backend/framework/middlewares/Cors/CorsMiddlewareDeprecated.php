<?php

namespace Framework\middlewares\Cors;

use Framework\middlewares\IMiddleware;
use Framework\middlewares\Middleware_deprecated;

class CorsMiddleware implements IMiddleware
{
    public function __invoke(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
    }
}