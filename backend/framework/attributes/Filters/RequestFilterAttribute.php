<?php

namespace Framework\attributes\Filters;

use Attribute;
use Framework\http\HttpContext;

#[Attribute]
abstract class RequestFilterAttribute
{
    // checks, whether the condition for the given filter holds
    public abstract function ok(HttpContext $context): bool;
}