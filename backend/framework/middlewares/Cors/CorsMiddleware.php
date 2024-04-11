<?php

namespace Framework\middlewares\Cors;

use Framework\middlewares\Middleware;

class CorsMiddleware extends Middleware
{
    public function __invoke(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $this->_next->__invoke();
    }
}