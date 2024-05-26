<?php

namespace DeepCode\Repositories;

interface IProblemsRepository extends IRepository
{
    public function getProblems(ProblemsSearchParams $params): array;

    public function getProblemsCount(ProblemsSearchParams $params): int;
}