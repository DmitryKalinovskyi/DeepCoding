<?php

namespace DeepCode\Modules\Problems\Repositories\Implementation;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Modules\Problems\Repositories\Interfaces\IProblemsRepository;


class ProblemsRepository implements IProblemsRepository
{
    private DeepCodeContext $db;

    public function __construct(DeepCodeContext $db){
        $this->db = $db;
    }

    public function getProblems(ProblemsSearchParams $params): array
    {
        $query = $this->db->problems->select()
            ->limit($params->pageSize)
            ->offset($params->pageSize * $params->page);

        if($params->search !== null)
            $query = $query->where("name like \"$params->search%\"");

        return $query->execute();
    }

    public function getProblemsCount(ProblemsSearchParams $params): int
    {
        $query = $this->db->query()->select(["COUNT(*) as count"])->from("problems");

        if($params->search !== null)
            $query = $query->where("name like \"$params->search%\"");

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
//        $this->db->problems->update()->where("id = :id")->
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