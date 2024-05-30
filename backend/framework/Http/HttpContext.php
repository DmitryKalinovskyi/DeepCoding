<?php

namespace Framework\Http;

class HttpContext
{
    private array $features = [];

    public function __get(string $name){
        return $this->features[$name];
    }

    public function __set(string $name, mixed $value){
        $this->features[$name] = $value;
    }

    public function __isset($key){
        return key_exists($key, $this->features);
    }
}