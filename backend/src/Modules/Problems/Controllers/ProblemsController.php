<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\Models\Submission;
use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Problems\Repositories\Implementation\ProblemsSearchParams;
use DeepCode\Modules\Problems\Repositories\Interfaces\IProblemsRepository;
use DeepCode\Modules\Problems\Repositories\Interfaces\ISubmissionsRepository;
use Framework\Attributes\Requests\HttpPost;
use Framework\Attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\MVC\APIController;

class ProblemsController extends APIController {
    private IProblemsRepository $repository;

    private HttpContext $context;

    private ISubmissionsRepository $submissionsRepository;

    public function __construct(IProblemsRepository $repository, HttpContext $context, ISubmissionsRepository $submissionsRepository){
        $this->repository = $repository;
        $this->context = $context;
        $this->submissionsRepository = $submissionsRepository;
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

    #[Route('{problemId}/submissions')]
    #[HttpPost]
    #[Authenticated]
    public function SubmitCodeForProblem(int $problemId): void{
        $code = $_POST['Code'];
        $compiler = $_POST['Compiler'];

        $submission = new Submission();
        $submission->Code = $code;
        $submission->Compiler = $compiler;
        $submission->ProblemId = $problemId;
        $submission->UserId = $this->context->user->Id;

        $this->submissionsRepository->insert($submission);
    }
}