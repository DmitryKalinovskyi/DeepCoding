<?php

namespace Framework\MVC;

class APIController
{
    public function sendStatus($code){
        http_response_code($code);
    }
}