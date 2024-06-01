<?php

namespace DeepCode\Modules\Problems\Repositories;

use DeepCode\Repositories\IRepository;

interface IProblemsRepository extends IRepository
{
    public function getProblems(ProblemsSearchParams $params): array;

    public function getProblemsCount(ProblemsSearchParams $params): int;

    public function getProblemSubmissions($key): array;

    public function getProblemSubmissionsForUser($key, $userId): array;
}