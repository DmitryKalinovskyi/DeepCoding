<?php

namespace Framework\middlewares;

abstract class Middleware
{
    public abstract function __invoke();
}