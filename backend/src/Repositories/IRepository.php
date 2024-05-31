<?php

namespace DeepCode\Repositories;

interface IRepository
{
    public function insert($model): void;

    public function find($key): mixed;

    public function update($key, object $model): void;

    public function delete($key): void;
}