<?php

namespace DeepCode\Api;

use DeepCode\DB\DeepCodeContext;
use Framework\attributes\Routing\Route;
use Framework\MVC\APIController;

class SubmissionsController extends APIController
{
    private DeepCodeContext $_db;
    public function __construct(DeepCodeContext $context){
        $this->_db = $context;
    }

    #[Route("problem")]
    public function GetProblemSubmissions(): void{
        if(empty($_GET['problemId'])){
            $this->sendStatus(404);
            die();
        }

        if(empty($_GET['userId'])){
            $this->sendStatus(404);
            die();
        }

        $problemId = $_GET['problemId'];
        $userId = $_GET['userId'];

        // get submissions for the current user



        $query = $this->_db->submissions
            // -> select()
            // -> leftJoin('problems as p')
            // -> where('p.Id = Id')
            ->select(['s.Id', 's.ProblemId', 's.UserId', 's.Code', 's.Compiler'])
            ->fromSources(['submissions as s', 'problems as p'])
            ->where('p.Id = :problemId AND p.Id = s.ProblemId AND s.UserId = :userId');


        $submissions = $query->execute(['problemId' => $problemId, 'userId' => $userId]);

        echo json_encode($submissions);
    }

    #[Route("/")]
    public function GetSubmission(): void{
        if(empty($_GET['id'])){
            $this->sendStatus(404);
            die();
        }

        $id = $_GET['id'];

        $submission = $this->_db->submissions->select()
            ->where("Id = :id")
            ->first(['id' => $id]);

        if(empty($submission))
        {
            $this->sendStatus(404);
            die();
        }

        echo json_encode($submission);
    }
}