<?php

namespace Framework\middlewares;

interface IMiddleware
{
    public function __invoke(): void;
}