<?php

namespace DeepCode\Modules\News\Repositories;

use DeepCode\DB\DeepCodeContext;

class NewsRepository implements INewsRepository
{

    private DeepCodeContext $context;

    public function __construct(\DeepCode\DB\DeepCodeContext $context){
        $this->context = $context;
    }

    public function insert($model): void
    {
        $this->context->news->insert($model);
    }

    public function find($key): mixed
    {
        return $this->context->news->select()
            ->where("Id = :id")
            ->first([":id" => $key]);
    }

    public function update($key, $model): void
    {
        // TODO: Implement update() method.
    }

    public function delete($key): void
    {
        $this->context->news->delete()
            ->where("Id = :id")
            ->execute([":id" => $key]);
    }
}