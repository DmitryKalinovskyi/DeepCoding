<?php

namespace DeepCode\Modules\Problems\Repositories;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Modules\Problems\DTO\ProblemDTO;


class ProblemsRepository implements IProblemsRepository
{
    private DeepCodeContext $db;

    public function __construct(DeepCodeContext $db){
        $this->db = $db;
    }

    public function search(ProblemsSearchParams $params): array
    {
        // first we need to build query that select
        $query = $this->db->problems->select()
            ->asClass(ProblemDTO::class)
            ->limit($params->pageSize)
            ->offset($params->pageSize * $params->page);

        if($params->name !== null)
            $query = $query->where("Name like \"$params->name%\"");

        return $query->execute();
    }

    public function searchCount(ProblemsSearchParams $params): int
    {
        $query = $this->db->query()->select(["COUNT(*) as count"])->from("problems");

        if($params->name !== null)
            $query = $query->where("name like \"$params->name%\"");

        return $query->first()["count"];
    }

    public function insert($model): void
    {
        $this->db->problems->insert($model);
    }

    public function find($key): mixed
    {
        return $this->db->problems->select()
            ->where("Id = :id")
            ->first([":id" => $key]);
    }

    public function update($key, $model): void
    {
        $query = $this->db->problems->dynamicUpdate($model)
            ->where("Id = :id");

        $query->execute([":id" => $key]);
    }

    public function delete($key): void
    {
        $this->db->problems->delete()->where("Id = :id")->execute([":id" => $key]);
    }


    public function getProblemSubmissions($key): array
    {
        $query = $this->db->submissions
            ->alias("S")
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler'])
            ->innerJoin(DeepCodeContext::PROBLEMS_TABLE . " as P", "S.ProblemId = P.Id")
            ->where("P.Id = :problemId");

        return $query->execute(['problemId' => $key]);
    }

    public function getProblemSubmissionsForUser($key, $userId): array
    {
        $query = $this->db->submissions
            ->alias("S")
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler'])
            ->innerJoin(DeepCodeContext::PROBLEMS_TABLE . " as P", "S.ProblemId = P.Id")
            ->where("S.UserId = :userId and P.Id = :problemId");

        return $query->execute(['problemId' => $key, 'userId' => $userId]);
    }
}