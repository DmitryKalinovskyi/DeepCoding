<?php

namespace DeepCode\Modules\News\Repositories;

use DeepCode\Repositories\IRepository;

interface INewsRepository extends IRepository
{
    public function search(NewsSearchParams $params): array;

    public function searchCount(NewsSearchParams $params): int;
}