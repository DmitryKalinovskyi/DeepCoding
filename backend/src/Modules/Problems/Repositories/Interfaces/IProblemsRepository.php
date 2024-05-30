<?php

namespace DeepCode\Modules\Problems\Repositories\Interfaces;

use DeepCode\Modules\Problems\Repositories\Implementation\ProblemsSearchParams;
use DeepCode\Repositories\IRepository;

interface IProblemsRepository extends IRepository
{
    public function getProblems(ProblemsSearchParams $params): array;

    public function getProblemsCount(ProblemsSearchParams $params): int;

    public function getProblemSubmissions($key): array;

    public function getProblemSubmissionsForUser($key, $userId): array;
}