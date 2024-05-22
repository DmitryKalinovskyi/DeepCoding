<?php

namespace Framework\middlewares\Authentication;

use Framework\middlewares\Middleware_deprecated;

class JWTAuthenticationMiddleware implements IAuthenticationMiddleware
{
    public function __invoke(): void
    {
        echo "jwt auth";
    }
}