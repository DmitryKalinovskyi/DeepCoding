<?php

namespace DeepCode\Modules\CodeRunner\Controllers;

use DeepCode\Modules\CodeRunner\CodeRunner\CodeRunner;
use DeepCode\Modules\CodeRunner\Validation\RunValidation;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;
use Framework\Validation\Validator;

class CodeRunnerController extends APIController
{
    #[Resolvable]
    private HttpContext $context;

    #[Resolvable]
    private CodeRunner $codeRunner;

    #[Route("run")]
    #[HttpPost]
    public function Run(): JsonResponse{
        // read code from body
        /* @var RunValidation $runValidation */
        $runValidation = AutoMapper::map($this->context->body, new RunValidation());

        if(!Validator::isModelValid($runValidation)){
            return $this->json((object)[
                "errors" => Validator::getErrors($runValidation)
            ], 422);
        }

        return $this->json((object)[
            "result" =>  $this->codeRunner->run($runValidation->Code)
        ], 200);
    }
}