<?php

namespace Framework\mvc;

class APIController
{
    public function sendStatus($code){
        http_response_code($code);
    }
}