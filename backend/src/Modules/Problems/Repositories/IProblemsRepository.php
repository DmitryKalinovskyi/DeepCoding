<?php

namespace DeepCode\Modules\Problems\Repositories;

use DeepCode\Repositories\IRepository;

interface IProblemsRepository extends IRepository
{
    public function search(ProblemsSearchParams $params): array;

    public function searchCount(ProblemsSearchParams $params): int;

    public function getProblemSubmissions($key): array;

    public function getProblemSubmissionsForUser($key, $userId): array;
}