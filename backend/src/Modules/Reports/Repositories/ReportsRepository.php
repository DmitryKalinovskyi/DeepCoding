<?php

namespace DeepCode\Modules\Reports\Repositories;

use DeepCode\DB\DeepCodeContext;
use Framework\Attributes\Dependency\Resolvable;

class ReportsRepository implements IReportsRepository
{
    #[Resolvable]
    private DeepCodeContext $db;

    public function search(ReportsSearchParams $params): array
    {
        $query = $this->db->reports->select()
        ->limit($params->pageSize)
        ->offset($params->page * $params->pageSize);

        if($params->title != null)
        {
            $wildcard = "%:wildcard%";
            $query->where("Title LIKE $wildcard")
                ->useParams([":wildcard" => $params->title]);
        }

        return $query->execute();
    }

    public function searchCount(ReportsSearchParams $params): int
    {
        $query = $this->db->reports->select();

        if($params->title != null)
        {
            $wildcard = "%:wildcard%";
            $query->where("Title LIKE $wildcard")
                ->useParams([":wildcard" => $params->title]);
        }

        return $query->count();
    }

    public function insert($model): void
    {
        $this->db->reports->insert($model);
    }

    public function find($key): mixed
    {
        return $this->db->reports->select()
            ->where("Id = :id")
            ->first([":id" => $key]);
    }

    public function update($key, object $model): void
    {
        $this->db->reports->dynamicUpdate($model)
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }

    public function delete($key): void
    {
        $this->db->reports->delete()
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }


}