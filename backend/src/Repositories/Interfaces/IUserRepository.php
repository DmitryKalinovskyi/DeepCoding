<?php

namespace DeepCode\Repositories\Interfaces;

use DeepCode\Models\PlatformUser;
use DeepCode\Models\Submission;

interface IUserRepository extends IRepository
{
    public function isRegistered(string $login, string $hashedPassword): bool;

    public function findByLogin(string $login): ?PlatformUser;

    public function getSubmissions(string $key): array;
}