<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\Submission;
use DeepCode\Modules\Problems\DTO\SubmissionDTO;
use DeepCode\Modules\Problems\Repositories\ISubmissionsRepository;
use Framework\Attributes\Dependency\Resolvable;
use Framework\attributes\Routing\Route;
use Framework\Mapper\AutoMapper;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

class SubmissionsController extends APIController
{
    #[Resolvable]
    private ISubmissionsRepository $submissionsRepository;

    #[Route("{submissionId}")]
    public function GetSubmission(string $submissionId): JsonResponse{
        $submission = $this->submissionsRepository->find($submissionId);

        if($submission == null){
            return $this->json("Not founded.", 404);
        }

        /* @var Submission $dto */
        $dto = AutoMapper::map($submission, new SubmissionDTO());
        $dto->Result = json_decode($submission->Result);

        return $this->json($dto);
    }
}