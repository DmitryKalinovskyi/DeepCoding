<?php

namespace DeepCode\api;

use DeepCode\db\DeepCodeContext;
use Framework\attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\mvc\APIController;

class ProblemsController extends APIController {
    private DeepCodeContext $_db;
    public function __construct(DeepCodeContext $context){
        $this->_db = $context;
    }

    #[Route("/")]
    public function Index(): void{

        $page_size = 25;
        $data = [];
        $data['page'] = $_GET['page'] ?? 0;
        if(!is_numeric($data['page']))
            $data['page'] = 0;

        $data['pageCount'] = ceil($this->_db->problems->count() / $page_size);

        if($data['pageCount'] == 1) $data['pageCount'] = 0;

        $search = trim($_GET['search'] ?? "");

        $query = $this->_db->problems->select()
            ->limit($page_size)
            ->offset($page_size * $data['page']);

        if(!empty($search))
            $query = $query->where("name like \"$search%\"");

        $data['problems'] = $query->execute();

        echo json_encode($data);
    }

    #[Route("problem")]
    public function GetProblem(): void
    {
        $id = $_GET['id'];

        $problem = $this->_db->problems->select()
            ->where("Id = :id")
            ->first(["id" => $id]);

        echo json_encode($problem);
    }
}