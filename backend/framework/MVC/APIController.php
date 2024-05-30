<?php

namespace Framework\MVC;

use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\Middlewares\Response\Response;
use Framework\Validation\Validator;

class APIController
{
    public function sendStatus($code): void{
        http_response_code($code);
    }

    public function redirect($location): Response{
        return (new Response())->header("Location: ", $location);
    }

    public function response(string $message, int $statusCode = 0): Response{
        $response = new Response();
        $response = $response->result($message);

        if($statusCode != 0) $response = $response->status($statusCode);

        return $response;
    }

    public function json(mixed $data, int $statusCode = 0): JsonResponse{
        $response = new JsonResponse();
        $response = $response->json($data);

        if($statusCode != 0) $response = $response->status($statusCode);

        return $response;
    }

    public function validate(object $source, string $validationModelClass): object|false{
        $model = new $validationModelClass();
        AutoMapper::map($source, $model);

        if(!Validator::isModelValid($model)){
            return false;
        }

        return $model;
    }
}