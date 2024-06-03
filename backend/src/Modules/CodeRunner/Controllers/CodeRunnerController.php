<?php

namespace DeepCode\Modules\CodeRunner\Controllers;

use DeepCode\Modules\CodeRunner\CodeRunner\ICodeRunner;
use DeepCode\Modules\CodeRunner\CodeRunner\Runners\ICodeRunnerResolver;
use DeepCode\Modules\CodeRunner\CodeRunner\RunRules;
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
    private ICodeRunnerResolver $codeRunnerResolver;

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

        /* @var RunRules $runRules */

        $runRules = AutoMapper::map($runValidation, new RunRules());

        try{
            $codeRunner = $this->codeRunnerResolver->getCodeRunner($runValidation->Compiler);
            $runResult = $codeRunner->run($runRules);
        }
        catch(\Exception $exception){
            return $this->json((object)[
                "errors" => [$exception->getMessage()]
            ], 422);
        }

        if(!empty($runResult->errors)){
            // our user is teapot
            return $this->json((object)[
                "errors" => $runResult->errors
            ], 422);
        }
        return $this->json($runResult, 200);
    }
}