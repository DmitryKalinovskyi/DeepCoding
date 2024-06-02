<?php

namespace DeepCode\Modules\Following\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\Following;
use Framework\Attributes\Dependency\Resolvable;

class FollowingRepository implements IFollowingRepository
{
    #[Resolvable]
    private DeepCodeContext $db;

    public function follow(int $followerId, int $followingId): void
    {
        $following = new Following();
        $following->FollowingId = $followingId;
        $following->FollowerId = $followerId;

        $this->db->followings->insert($following);
    }

    public function unfollow(int $followerId, int $followingId): void
    {
        $this->db->followings->delete()
        ->where("FollowerId = :followerId AND FollowingId = :followingId")
        ->execute([":followerId" => $followerId, ":followingId" => $followingId]);
    }

    public function isFollow(int $followerId, int $followingId): bool
    {
        return $this->db->followings->select()
                ->where("FollowerId = :followerId AND FollowingId = :followingId")
                ->useParams([":followerId" => $followerId, ":followingId" => $followingId])
                ->count() > 0;
    }

    public function getFollowersCount(int $userId): int
    {
        return $this->db->followings->select()
                ->where("FollowingId = :followingId")
                ->useParams([":followingId" => $userId])
                ->count();
    }
}