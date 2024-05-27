<?php

namespace DeepCode\Api;

use DeepCode\Repositories\Implementation\ProblemsSearchParams;
use DeepCode\Repositories\Interfaces\IProblemsRepository;
use Framework\Attributes\Filters\Authenticated;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\MVC\APIController;

class ProblemsController extends APIController {
    private IProblemsRepository $repository;

    private HttpContext $context;

    public function __construct(IProblemsRepository $repository, HttpContext $context){
        $this->repository = $repository;
        $this->context = $context;
    }

    #[Route("/")]
    public function Index(): void{

        $params = new ProblemsSearchParams();

        $params->page = intval($_GET['page'] ?? "0");
        $search = trim($_GET['search'] ?? "");
        if($search !== "")
            $params->search = $search;

        $data['problems'] = $this->repository->getProblems($params);
        $data['pageCount'] = ceil($this->repository->getProblemsCount($params) / $params->pageSize);

        echo json_encode($data);
    }

    #[Route("{problemId}")]
    public function GetProblem(int $problemId): void
    {
        $problem = $this->repository->find($problemId);

        echo json_encode($problem);
    }

    #[Route("{problemId}/submissions")]
    #[Authenticated]
    public function GetProblemSubmissions(int $problemId): void{

        $submissions = $this->repository->getProblemSubmissionsForUser($problemId,
            $this->context->user->Id);

        echo json_encode($submissions);
    }
}