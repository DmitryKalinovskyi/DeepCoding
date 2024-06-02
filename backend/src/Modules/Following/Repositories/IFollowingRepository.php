<?php

namespace DeepCode\Modules\Following\Repositories;

interface IFollowingRepository
{
    public function follow(int $followerId, int $followingId): void;

    public function unfollow(int $followerId, int $followingId): void;

    public function isFollow(int $followerId, int $followingId): bool;

//    public function getFollowers(int $userId): array;

    public function getFollowersCount(int $userId): int;
}