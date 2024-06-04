<?php

namespace DeepCode\Modules\GroupedAPIRequests\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Modules\GroupedAPIRequests\DTO\UserDTO;
use Framework\Attributes\Dependency\Resolvable;

class UsersGroupedRepository implements IUsersGroupedRepository
{
    #[Resolvable]
    private DeepCodeContext $db;

    public function getUser(int $userId, int $myId): ?UserDTO
    {
        /* @var UserDTO $user */
        $user = $this->db->query()->select(['Id', "Login", "Name", "AvatarUrl", "RegisterDate", "Description"])
            ->asClass(UserDTO::class)
            ->from("users")
            ->where("Id = :userId")
            ->useParams([":userId" => $userId])
            ->first();

        if($user == null) return null;

        $user->Followings = $this->db->followings->select()
            ->where("FollowerId = :userId")
            ->useParams([":userId" => $userId])
            ->count();

        $user->Followers = $this->db->followings->select()
            ->where("FollowingId = :userId")
            ->useParams([":userId" => $userId])
            ->count();

        $user->IsFollowed = $this->db->followings->select()
            ->where("FollowerId = :myId AND FollowingId = :userId")
            ->useParams([":userId" => $userId, ":myId" => $myId])
            ->count() > 0;

        $user->SubmissionsCount = $this->db->submissions->select()
            ->where("UserId = :userId")
            ->useParams([":userId" => $userId])
            ->count();

        $user->SolvedProblemsCount = $this->db->submissions->select()
            ->where("IsPassed = true AND UserId = :userId")
            ->useParams([":userId" => $userId])
            ->groupBy(["ProblemId"])
            ->count();

        $user->SubmissionActivity = $this->db->submissions->select(['CreatedTime'])
            ->asObject()
            ->where("UserId = :userId")
            ->useParams([":userId" => $userId])
            ->execute();

        return $user;
    }
}