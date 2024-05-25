<?php

namespace Framework\attributes\Filters;

use Attribute;
use Framework\http\HttpContext;

#[Attribute]
class Authenticated extends RequestFilterAttribute
{
    /**
     * @param HttpContext $context - context for the request
     * @return bool - true if $context->user authenticated by middleware
     */
    public function ok(HttpContext $context): bool
    {
        return isset($context->user);
    }
}