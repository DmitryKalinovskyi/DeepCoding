<?php

namespace Framework\Middlewares\Response;
class Response
{
    public int $statusCode = 0;
    public mixed $result = "";
    public array $headers = [];

    public function status(int $code): Response{
        $this->statusCode = $code;
        return $this;
    }

    public function header(string $key, string $value): Response{
        $this->headers[] = $key.$value;
        return $this;
    }

    public function result($value): Response{
        $this->result = $value;
        return $this;
    }
}