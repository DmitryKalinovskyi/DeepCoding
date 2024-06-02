<?php

namespace DeepCode\Modules\Following\Controllers;

use DeepCode\Modules\Authentication\Attributes\Filters\Authenticated;
use DeepCode\Modules\Following\Repositories\IFollowingRepository;
use Framework\Attributes\Dependency\Resolvable;
use Framework\Attributes\Requests\HttpPost;
use Framework\attributes\Routing\Route;
use Framework\Http\HttpContext;
use Framework\Middlewares\Response\JsonResponse;
use Framework\MVC\APIController;

#[Route('users')]
class FollowingsController extends APIController
{
    #[Resolvable]
    private IFollowingRepository $followingRepository;

    #[Resolvable]
    private HttpContext $context;

    #[Route("{userId}/followers/count")]
    public function GetFollowersCount(string $userId): JsonResponse
    {
        if(!ctype_digit($userId)){
            return $this->json("UserId is not positive integer");
        }

        $userId = (int)$userId;

        return $this->json((object)[
            "count" => $this->followingRepository->getFollowersCount($userId)
            ], 200);
    }

    #[Route('{userId}/follow')]
    #[Authenticated]
    #[HttpPost]
    public function Follow(string $userId): JsonResponse
    {
        if(!ctype_digit($userId)){
            return $this->json("UserId is not positive integer");
        }

        $userId = (int)$userId;

        $this->followingRepository->follow($this->context->user->Id, $userId);
        return $this->json("Followed.", 200);
    }

    #[Route('{userId}/unfollow')]
    #[Authenticated]
    #[HttpPost]
    public function Unfollow(string $userId): JsonResponse
    {
        if(!ctype_digit($userId)){
            return $this->json("UserId is not positive integer");
        }

        $userId = (int)$userId;
        $this->followingRepository->unfollow($this->context->user->Id, $userId);
        return $this->json("Unfollowed.", 200);
    }

    #[Route('{userId}/unfollow')]
    #[Authenticated]
    #[HttpPost]
    public function IsFollowedByMe(string $userId): JsonResponse
    {
        if(!ctype_digit($userId)){
            return $this->json("UserId is not positive integer");
        }

        $userId = (int)$userId;
        return $this->json((object)[
            "result" => $this->followingRepository->isFollow($this->context->user->Id, $userId)
        ]);
    }
}