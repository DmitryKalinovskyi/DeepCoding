<?php

namespace Framework\Middlewares\Response;

class JsonResponse extends Response
{
    public function json($data): self{
        $this->result = json_encode($data);
        return $this;
    }
}