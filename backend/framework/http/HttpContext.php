<?php

namespace Framework\http;

class HttpContext
{
    private array $features = [];

    public function __get(string $name){
        return $this->features[$name];
    }

    public function __set(string $name, mixed $value){
        $this->features[$name] = $value;
    }
}