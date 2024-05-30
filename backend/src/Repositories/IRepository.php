<?php

namespace DeepCode\Modules\Problems\Repositories\Interfaces;

interface IRepository
{
    public function insert($model): void;

    public function find($key): mixed;

    public function update($key, $model): void;

    public function delete($key): void;
}