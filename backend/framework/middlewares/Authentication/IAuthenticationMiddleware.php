<?php

namespace Framework\middlewares\Authentication;

use Framework\middlewares\IMiddleware;

interface IAuthenticationMiddleware extends IMiddleware
{

    /**
     * Makes user authentication, as result should set User to the $HttpContext->user
     * @return void
     */
    public function __invoke(): void;
}