<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\DB\DeepCodeContext;
use Framework\attributes\Routing\Route;
use Framework\MVC\APIController;

class SubmissionsController extends APIController
{
    private DeepCodeContext $_db;
    public function __construct(DeepCodeContext $context){
        $this->_db = $context;
    }

    #[Route("{submissionId}")]
    public function GetSubmission(int $submissionId): void{
        $submission = $this->_db->submissions->select()
            ->where("Id = :id")
            ->first(['id' => $submissionId]);

        if(empty($submission))
        {
            $this->sendStatus(404);
            die();
        }

        echo json_encode($submission);
    }
}