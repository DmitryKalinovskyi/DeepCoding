<?php

namespace Framework\middlewares\Authentication;

use Framework\middlewares\Middleware;

class JWTAuthenticationMiddleware extends Middleware
{
    public function __invoke()
    {
        echo "jwt auth";

        $this->_next->__invoke();
    }
}