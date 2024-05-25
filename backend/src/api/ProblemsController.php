<?php

namespace DeepCode\api;

use DeepCode\db\DeepCodeContext;
use DeepCode\Repositories\IProblemsRepository;
use DeepCode\Repositories\ProblemsSearchParams;
use Framework\attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\mvc\APIController;

class ProblemsController extends APIController {
    private IProblemsRepository $repository;

    public function __construct(IProblemsRepository $repository){
        $this->repository = $repository;
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

    #[Route("problem")]
    public function GetProblem(): void
    {
        $id = $_GET['id'];

        $problem = $this->repository->find($id);

        echo json_encode($problem);
    }
}