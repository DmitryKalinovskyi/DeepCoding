<?php

namespace DeepCode\controllers;

use Framework\mvc\ControllerBase;
use DeepCode\Models as Models;

class ProblemsController extends ControllerBase{
    public function __construct(){

    }

    public function Index(){

        // load from database problems page, for testing purpose i just get random values

        $data = [];
        $data['problems'] = [];

        for($i = 0; $i < 10; $i++){
            $model = new Models\Problem();
            $model->Id = $i;
            $model->Name = "Problem $i";
            $model->Description = "This is problem number $i";

            $data['problems'][] = $model;
        }

        $this->Render('problems.php', $data);
    }

    public function GetProblem(int $id){
        $data = [];

        // load from database
        $data['problem'] = new Models\Problem();
        $data['problem']->Id = $id;
        $data['problem']->Name = "Test problem";
        $data['problem']->Description = "Test problem description";


        $this->Render('problem.php', $data);
    }
}