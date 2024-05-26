<?php

namespace DeepCode\Controllers;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\Submission;
use DeepCode\Repositories\IProblemsRepository;
use DeepCode\Repositories\ProblemsSearchParams;
use Framework\attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\MVC\ControllerBase;

class ProblemsController extends ControllerBase{
    private DeepCodeContext $_db;
    private IProblemsRepository $repository;
    public function __construct(DeepCodeContext $context, IProblemsRepository $repository){
        $this->_db = $context;
        $this->repository = $repository;
    }

    #[Route("/")]
    public function Index(): void{
        $params = new ProblemsSearchParams();

        $params->page = intval($_GET['page'] ?? "0");
        $search = trim($_GET['search'] ?? "");
        if($search !== "")
            $params->search = $search;

        $data['page'] = $params->page;
        $data['problems'] = $this->repository->getProblems($params);
        $data['pageCount'] = ceil($this->repository->getProblemsCount($params) / $params->pageSize);

        $this->render('problems.php', $data);
    }

    #[Route("problem")]
    public function GetProblem(): void
    {
        $id = $_GET['id'];
        $data = [];

        $data['problem'] = $this->_db->problems->select()
            ->where("Id = :id")
            ->execute(["id" => $id])[0];

        $this->render('problem.php', $data);
    }

    #[Route("submit")]
    #[HttpPost]
    public function SubmitProblem(): void{
        $code = $_POST['code'];
        $userId = $_POST['userId'] ?? 1;
        $compiler = $_POST['compiler'];
        $problemId = $_POST['problemId'];

        // create submission, post to the testing service, then update information in the database
        $submission = new Submission();
        $submission->ProblemId = $problemId;
        $submission->UserId = $userId;
        $submission->Code = $code;
        $submission->Compiler = $compiler;

        $this->_db->submissions->insert($submission);
        echo "Submitted!";

        $this->redirect("problem?id=$problemId");
    }
}