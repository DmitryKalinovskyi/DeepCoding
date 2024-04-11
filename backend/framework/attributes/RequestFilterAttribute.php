<?php

namespace Framework\attributes;

use Attribute;

#[Attribute]
abstract class RequestFilterAttribute
{
    public abstract function ok(): bool;
}