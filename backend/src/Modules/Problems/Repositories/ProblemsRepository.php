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

        $selectPassedSubmissionsQuery = $this->db->submissions
            ->alias("S_inside1")
            ->select()
            ->where("S_inside1.ProblemId = P.Id AND S_inside1.UserId = :userId AND S_inside1.IsPassed = true")
            ->build();

        $selectAllSubmissions = $this->db->submissions
            ->alias("S_inside2")
            ->select()
            ->where("S_inside2.ProblemId = P.Id AND S_inside2.UserId = :userId")
            ->build();

        $query = $this->db->problems
            ->alias("P")
            ->select(["P.Id", "P.Name",
                "CASE
        WHEN 
         EXISTS($selectPassedSubmissionsQuery)
         THEN 'Solved'
        WHEN 
         EXISTS($selectAllSubmissions)
        THEN 'Tried'
        ELSE 'Never tried'
    END AS Status",
                "CASE 
                WHEN COUNT(s.Id) = 0 THEN 'Not defined'
                WHEN SUM(S.IsPassed)/COUNT(s.Id) < 0.2 THEN 'Hard'
                WHEN SUM(S.IsPassed)/COUNT(s.Id) < 0.5 THEN 'Medium'
                ELSE 'Easy'
                END AS Difficulty",
                "COUNT(s.Id) as TotalAttempts",
                "SUM(S.IsPassed) as TotalPassedAttempts"
            ])
            ->asObject()
            ->limit($params->pageSize)
            ->offset($params->pageSize * $params->page)
            ->leftJoin(DeepCodeContext::SUBMISSIONS_TABLE." as S", "S.ProblemId = P.Id")
            ->where("S.UserId = :userId")
            ->groupBy(["P.Id"])
            ->useParams([":userId" => $params->userId ?? -1])
        ;

        if($params->name !== null)
            $query->where("Name like \"$params->name%\"");

        if(!empty($params->status))
            $query->having("Status = :status")
                ->useParams([":status" => $params->status]);

        if(!empty($params->difficulty)){
            if(!empty($params->status))
                $query->having("Status = :status AND Difficulty = :difficulty");
            else
                $query->having("Difficulty = :difficulty");

                $query->useParams([":difficulty" => $params->difficulty]);
        }


//        echo $query->build();
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
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler', 'S.IsPassed', 'S.Result', 'S.CreatedTime',
                 'U.Login as UserLogin', 'P.Name as ProblemName'])
            ->asObject()
            ->rightJoin(DeepCodeContext::PROBLEMS_TABLE . " as P", "S.ProblemId = P.Id")
            ->innerJoin(DeepCodeContext::USERS_TABLE . " as U", "S.UserId = U.Id")
            ->where("P.Id = :problemId")
            ->orderBy("S.CreatedTime", false);

        return $query->execute(['problemId' => $key]);
    }

    public function getProblemSubmissionsForUser($key, $userId): array
    {
        $query = $this->db->submissions
            ->alias("S")
            ->select(['S.Id', 'S.Code', 'S.ProblemId', 'S.UserId', 'S.Compiler', 'S.IsPassed', 'S.Result', 'S.CreatedTime',
                'U.Login as UserLogin', 'P.Name as ProblemName'])
            ->asObject()
            ->rightJoin(DeepCodeContext::PROBLEMS_TABLE . " as P", "S.ProblemId = P.Id")
            ->innerJoin(DeepCodeContext::USERS_TABLE . " as U", "S.UserId = U.Id")
            ->where("S.UserId = :userId and P.Id = :problemId")
            ->orderBy("S.CreatedTime", false);

        return $query->execute(['problemId' => $key, 'userId' => $userId]);
    }
}