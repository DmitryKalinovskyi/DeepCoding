<?php

namespace Framework\middlewares\Authentication;

interface IAuthenticationMiddleware
{
    public function authorize();
}