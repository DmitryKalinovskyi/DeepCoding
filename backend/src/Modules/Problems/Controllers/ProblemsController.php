<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Problems\Repositories\IProblemsRepository;
use DeepCode\Modules\Problems\Repositories\ISubmissionsRepository;
use DeepCode\Modules\Problems\Repositories\ProblemsSearchParams;
use DeepCode\Modules\Problems\Validation\SubmissionValidation;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpPost;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

class ProblemsController extends APIController {

    #[Resolvable]
    private IProblemsRepository $repository;
    #[Resolvable]
    private HttpContext $context;
    #[Resolvable]
    private ISubmissionsRepository $submissionsRepository;

    #[Route("/")]
    public function Search(): JsonResponse{

        $params = new ProblemsSearchParams();

        $params->page = intval($_GET['page'] ?? "0");
        $search = trim($_GET['search'] ?? "");
        if($search !== "")
            $params->search = $search;

        $data['pageCount'] = ceil($this->repository->getProblemsCount($params) / $params->pageSize);
        $data['problems'] = $this->repository->getProblems($params);

        return $this->json((object)$data, 200);
    }

    #[Route("{problemId}")]
    public function GetProblem(string $problemId): JsonResponse
    {
        $problem = $this->repository->find($problemId);

        return $this->json($problem, 200);
    }

    #[Route("{problemId}/submissions")]
    #[Authenticated]
    public function GetProblemSubmissions(string $problemId): JsonResponse{

        $submissions = $this->repository->getProblemSubmissionsForUser($problemId,
            $this->context->user->Id);

        return $this->json($submissions, 200);
    }

    #[Route('{problemId}/submissions')]
    #[HttpPost]
    #[Authenticated]
    public function SubmitCodeForProblem(string $problemId): JsonResponse{
        $submission = AutoMapper::map($this->context->body, new SubmissionValidation());

        $submission->ProblemId = $problemId;
        $submission->UserId = $this->context->user->Id;

        $this->submissionsRepository->insert($submission);

        return $this->json("Submited.", 200);
    }
}