<?php

namespace DeepCode\controllers;

use DeepCode\db\DeepCodeContext;
use Framework\mvc\ControllerBase;

class ProblemsController extends ControllerBase{
    private DeepCodeContext $_context;
    public function __construct(DeepCodeContext $context){
        $this->_context = $context;
    }

    public function Index(): void{

        $page_size = 25;
        $data = [];
        $data['page'] = $_GET['page'] ?? 0;
        if(!is_numeric($data['page']))
            $data['page'] = 0;

        $data['pageCount'] = ceil($this->_context->problems
        ->count() / $page_size);

        if($data['pageCount'] == 1) $data['pageCount'] = 0;

        $search = trim($_GET['search'] ?? "");

        $query = $this->_context->problems
            ->limit($page_size)
            ->offset($page_size * $data['page']);

        if(!empty($search))
            $query = $query->where("name like \"$search%\"");

        $data['problems'] = $query->select();

        $this->render('problems.php', $data);
    }

    public function GetProblem(): void
    {
        $id = $_GET['id'];
        $data = [];

        $data['problem'] = $this->_context->problems
            ->where("Id = $id")
            ->first();

        $this->render('problem.php', $data);
    }

    public function SubmitProblem(): void{
        $code = $_POST['code'];
        $compiler = $_POST['code'];

        // create submission, post to the testing service, then update information in the database



        echo $code;
        echo $compiler;
    }
}