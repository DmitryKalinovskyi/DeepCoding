<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\Models\Problem;
use DeepCode\Models\Submission;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Authentication\Attributes\Filters\InRole;
use DeepCode\Modules\Logging\ILoggingService;
use DeepCode\Modules\Problems\CodeTesting\ICodeTestingService;
use DeepCode\Modules\Problems\CodeTesting\TestInfo;
use DeepCode\Modules\Problems\DTO\SubmissionDTO;
use DeepCode\Modules\Problems\Repositories\IProblemsRepository;
use DeepCode\Modules\Problems\Repositories\ISubmissionsRepository;
use DeepCode\Modules\Problems\Repositories\ProblemsSearchParams;
use DeepCode\Modules\Problems\Validation\ProblemValidation;
use DeepCode\Modules\Problems\Validation\SubmissionValidation;
use Exception;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpDelete;
use Framework\Attributes\Requests\HttpPatch;
use Framework\Attributes\Requests\HttpPost;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\Middlewares\Response\Response;
use Framework\MVC\APIController;
use Framework\Validation\TemplateValidator;
use Framework\Validation\Validator;

class ProblemsController extends APIController {

    #[Resolvable]
    private IProblemsRepository $repository;
    #[Resolvable]
    private HttpContext $context;
    #[Resolvable]
    private ISubmissionsRepository $submissionsRepository;
    #[Resolvable]
    private ICodeTestingService $codeTestingService;

    #[Resolvable]
    private ?ILoggingService $loggingService = null;

    #[Route("/")]
    public function Search(): JsonResponse{

        /* @var ProblemsSearchParams $params */
        $params = AutoMapper::mapFromArray($_GET, new ProblemsSearchParams());
        if(!Validator::isModelValid($params)){
            return $this->json((object)["errors" => Validator::getErrors($params)], 422);
        }

        if(isset($this->context->user))
        $params->userId = $this->context->user->Id;

        $data['pageCount'] = ceil($this->repository->searchCount($params) / $params->pageSize);
        $data['problems'] = $this->repository->search($params);

        return $this->json((object)$data, 200);
    }

    #[Route("{problemId}")]
    public function GetProblem(string $problemId): Response
    {
        $problem = $this->repository->find($problemId);

        if($problem == null) return $this->json((object)[], 404);

        return $this->json($problem, 200);
    }

    #[Route('')]
    #[HttpPost]
    #[Authenticated]
    #[InRole("Admin")]
    public function CreateProblem(): JsonResponse{
        $problem = AutoMapper::map($this->context->body, new ProblemValidation());
        if(!Validator::isModelValid($problem)){
            return $this->json((object)["errors" => Validator::getErrors($problem)], 422);
        }

        $this->repository->insert($problem);

        return $this->json("Created.", 200);
    }

    #[Route('{problemId}')]
    #[HttpPatch]
    #[Authenticated]
    #[InRole("Admin")]
    public function UpdateProblem(string $problemId): JsonResponse{
        // took from body
        $intersect = AutoMapper::intersect($this->context->body, new ProblemValidation());
        $errors = [];
        if(!TemplateValidator::isModelValid($intersect, ProblemValidation::class, false, $errors)){
            return $this->json((object)["errors" => $errors], 422);
        }

        $this->repository->update($problemId, $intersect);

        return $this->json("Updated.", 200);
    }

    #[Route('{problemId}')]
    #[HttpDelete]
    #[Authenticated]
    #[InRole("Admin")]
    public function DeleteProblem(string $problemId): JsonResponse{
        $this->repository->delete($problemId);

        return $this->json("Deleted.", 200);
    }


    #[Route("{problemId}/submissions")]
    #[Authenticated]
    public function GetProblemSubmissions(string $problemId): JsonResponse{

        $submissions = $this->repository->getProblemSubmissionsForUser($problemId,
            $this->context->user->Id);

        $submissions = array_map(function($s) {
            $dto = AutoMapper::map($s, new SubmissionDTO());
            $dto->Result = (object)json_decode($s->Result);
            return $dto;
                }, $submissions);


        return $this->json($submissions, 200);
    }

    #[Route('{problemId}/submissions')]
    #[HttpPost]
    #[Authenticated]
    public function SubmitCodeForProblem(string $problemId): JsonResponse{
        // this is by idea the most complicated endpoint of all api

        /* @var SubmissionValidation $submissionValidation */
        $submissionValidation = AutoMapper::map($this->context->body, new SubmissionValidation());

        if(!Validator::isModelValid($submissionValidation)){
            return $this->json((object)["errors" => Validator::getErrors($submissionValidation)], 422);
        }

        // map all to default submission
        /* @var Submission $submission */
        $submission = AutoMapper::map($submissionValidation, new Submission());

        // read test cases from problem
        /* @var Problem | null $problem */
        $problem = $this->repository->find($problemId);
        if($problem === null){
            return $this->json("Problem not founded.", 404);
        }

        $submission->ProblemId = $problemId;
        $submission->UserId = $this->context->user->Id;
        $submission->CreatedTime = time();

        // setup test
        $testInfo = new TestInfo();
        $testInfo->testingScript = $problem->TestingScript;
        $testInfo->testingScriptLanguage = $problem->TestingScriptLanguage;
        $testInfo->code = $submission->Code;
        $testInfo->codeLanguage = $submission->Compiler;
        $testInfo->testCases = json_decode($problem->Tests);

        try{
            $testResult = $this->codeTestingService->test($testInfo);
        }catch (Exception $err){
            $message = $err->getMessage();
            // in case of error we need to somehow report it.
            if($this->loggingService){
                $log = "$problemId, $problem->Name, internal server error. $message";
                $this->loggingService->log($log);
            }

            return $this->json("Internal server error", 500);
        }

        $submission->IsPassed = $testResult->isPassed;
        $submission->Result = json_encode((object)[
            "tests" => $testResult->testCaseResults,
            "runningTime" => $testResult->runningTime,
            "memoryUsed" => $testResult->memoryUsed,
        ]);
        $this->submissionsRepository->insert($submission);

        return $this->json("Submited.", 200);
    }
}