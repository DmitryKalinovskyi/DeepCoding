<?php

namespace DeepCode\controllers;

use DeepCode\db\DeepCodeContext;
use DeepCode\models\Submission;
use Framework\mvc\ControllerBase;

class ProblemsController extends ControllerBase{
    private DeepCodeContext $_db;
    public function __construct(DeepCodeContext $context){
        $this->_db = $context;
    }

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

        $this->render('problems.php', $data);
    }

    public function GetProblem(): void
    {
        $id = $_GET['id'];
        $data = [];

        $data['problem'] = $this->_db->problems->select()
            ->where("Id = :id")
            ->execute(["id" => $id])[0];

        $this->render('problem.php', $data);
    }

    public function SubmitProblem(): void{
        $code = $_POST['code'];
        $compiler = $_POST['compiler'];
        $problemId = $_POST['problemId'];

        // create submission, post to the testing service, then update information in the database
        $submission = new Submission();
        $submission->ProblemId = $problemId;
        $submission->Code = $code;
        $submission->Compiler = $compiler;

        $this->_db->submissions->insert($submission);
        echo "Submitted!";
    }
}