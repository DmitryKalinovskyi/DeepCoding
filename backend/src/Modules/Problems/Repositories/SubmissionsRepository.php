<?php

namespace DeepCode\Modules\Problems\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Modules\Problems\DTO\SubmissionDTO;

class SubmissionsRepository implements ISubmissionsRepository
{
    private DeepCodeContext $context;
    public function __construct(\DeepCode\DB\DeepCodeContext $context){

        $this->context = $context;
    }

    public function insert($model): void
    {
        $this->context->submissions->insert($model);
    }

    public function find($key): mixed
    {
        return $this->context->submissions
            ->alias("S")
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler', 'S.CreatedTime', 'S.IsPassed',
                'S.Result', 'U.Login as UserLogin', 'P.Name as ProblemName'])
            ->asObject()
            ->innerJoin(DeepCodeContext::USERS_TABLE." as U", "U.Id = S.UserId")
            ->innerJoin(DeepCodeContext::PROBLEMS_TABLE." as P", "P.Id = S.ProblemId")
            ->where("S.Id = :id")
            ->first([":id" => $key]);
    }

    public function update($key, $model): void
    {
        // TODO: Implement update() method.
    }

    public function delete($key): void
    {
        $this->context->submissions->delete()
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }

    public function getUserSubmissions($userId): array
    {
        return $this->context->submissions
            ->alias("S")
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler', 'S.CreatedTime', 'S.IsPassed',
                'S.Result', 'U.Login as UserLogin', 'P.Name as ProblemName'])
            ->asObject()
            ->innerJoin(DeepCodeContext::USERS_TABLE." as U", "U.Id = S.UserId")
            ->innerJoin(DeepCodeContext::PROBLEMS_TABLE." as P", "P.Id = S.ProblemId")
            ->where("U.Id = :id")
            ->execute([":id" => $userId]);
    }
}