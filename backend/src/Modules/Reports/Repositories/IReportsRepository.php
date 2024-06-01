<?php

namespace DeepCode\Modules\Reports\Repositories;

use DeepCode\Repositories\IRepository;

interface IReportsRepository extends IRepository
{
    public function search(ReportsSearchParams $params): array;
    public function searchCount(ReportsSearchParams $params): int;
}