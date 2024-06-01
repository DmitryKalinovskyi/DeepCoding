<?php

namespace DeepCode\Modules\Problems\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Problems\Repositories\ISubmissionsRepository;
use DeepCode\Modules\Users\Repositories\IUserRepository;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;

#[Route("users")]
class UserSubmissionsController
{
    private ISubmissionsRepository $submissionsRepository;
    private IUserRepository $userRepository;

    private HttpContext $context;
    public function __construct(ISubmissionsRepository $submissionsRepository, IUserRepository $userRepository, HttpContext $context){

        $this->submissionsRepository = $submissionsRepository;
        $this->userRepository = $userRepository;
        $this->context = $context;
    }

    #[Route('my/submissions')]
    #[Authenticated]
    public function GetMySubmissions(): void{
        $submissions = $this->submissionsRepository->getUserSubmissions($this->context->user->Id);

        echo json_encode($submissions);
    }

    #[Route('{userId}/submissions')]
    public function GetSubmissions(int $userId): void{
        $user = $this->userRepository->find($userId);
        if(empty($user)){
            echo json_encode("profile not founded");
            http_response_code(404);
            return;
        }

        $submissions = $this->submissionsRepository->getUserSubmissions($userId);

        echo json_encode($submissions);
    }
}