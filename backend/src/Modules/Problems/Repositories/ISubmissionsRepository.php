<?php

namespace DeepCode\Modules\Problems\Repositories;

use DeepCode\Repositories\IRepository;

interface ISubmissionsRepository extends IRepository
{
    public function getUserSubmissions($userId): array;
}