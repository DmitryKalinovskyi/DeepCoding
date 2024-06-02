<?php

namespace DeepCode\Modules\News\Repositories;

use DeepCode\DB\DeepCodeContext;

class NewsRepository implements INewsRepository
{

    private DeepCodeContext $db;

    public function __construct(\DeepCode\DB\DeepCodeContext $context){
        $this->db = $context;
    }

    public function insert($model): void
    {
        $this->db->news->insert($model);
    }

    public function find($key): mixed
    {
        return $this->db->news->select()
            ->where("Id = :id")
            ->first([":id" => $key]);
    }

    public function update($key, object $model): void
    {
        $query = $this->db->news->dynamicUpdate($model)
            ->where("Id = :id");

        $query->execute([":id" => $key]);
    }

    public function delete($key): void
    {
        $this->db->news->delete()
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }

    public function search(NewsSearchParams $params): array
    {
        $query = $this->db->news->select()
            ->orderBy("CreatedTime", false)
            ->offset($params->page * $params->pageSize)
            ->limit($params->pageSize);

        if($params->title != null){
            $titleWildcard = "%$params->title%";
            $query->where("Title LIKE :title")
                ->useParams([":title" => $titleWildcard]);
        }

        return $query->execute();
    }

    public function searchCount(NewsSearchParams $params): int
    {
        $query = $this->db->news->select();

        if($params->title != null){
            $titleWildcard = "%$params->title%";
            $query->where("Title LIKE :title")
                ->useParams([":title" => $titleWildcard]);
        }

        return $query->count();
    }
}