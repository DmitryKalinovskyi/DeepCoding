<?php

namespace Framework\Attributes\Filters;

use Attribute;
use Framework\Http\HttpContext;

#[Attribute]
abstract class RequestFilterAttribute
{
    // checks, whether the condition for the given filter holds
    public abstract function filter(HttpContext $context): bool;
}