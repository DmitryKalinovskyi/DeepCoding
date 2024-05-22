<?php

namespace DeepCode\middlewares;

use Framework\http\HttpContext;
use Framework\middlewares\Authentication\IAuthenticationMiddleware;

class JWTAuthenticationMiddleware implements IAuthenticationMiddleware
{
    public function __invoke(HttpContext $context, $next){
        $context->user = "Dmytro Kalinovskyi";

        $next();
    }
}