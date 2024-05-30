<?php

namespace DeepCode\Modules\Problems\Repositories\Implementation;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Modules\Problems\Repositories\Interfaces\ISubmissionsRepository;

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
        return $this->context->submissions->select()
            ->where("Id = :id")
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
}