<?php

namespace framework\attributes\Filters;

use Framework\http\HttpContext;

#[\Attribute]
class AuthenticatedAttribute extends RequestFilterAttribute
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