<?php

namespace Framework\attributes\Routing;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class Route
{
    public string $route;
    public function __construct(string $route = "%entityName%"){
        $this->route = $route;
    }
}