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
        $data['page'] = 0;
        $data['pageCount'] = 4;

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
        $data['problem']->Description = "Little I and Little J are playing a game again.

Little J brings a tree with n vertices. Each edge of the tree has two states: open and closed. Initially, all edges of the tree are open.

There is a chip initially placed at vertex 1. Little I can move the chip, and the goal is to move the chip to a vertex with degree exactly equal to 1. Little J can close edges of the tree with the goal of preventing Little I from moving the chip to a vertex with degree exactly 1. The degree of a vertex is the number of edges connected to it, regardless of whether they are open or closed.

The game consists of several rounds, each round having the following steps:

Little I Task Determination: If the chip is at a vertex with degree exactly 1, Little I wins. Otherwise, proceed to step 2.

Little J Action: Little J closes one currently open edge permanently. If there are no open edges at the moment, skip the action and proceed to step 3.

Little I Action: Little I chooses an open edge connected to the vertex currently containing the chip, and moves the chip to the other end of this edge. If there is no such edge, Little J wins. Otherwise, a new round begins, going back to step 1.

Little J wants to know who will win if Little I and Little J know the structure of this tree and are extremely smart.";


        $this->Render('problem.php', $data);
    }
}