<?php

namespace DeepCode\Modules\Problems\Repositories\Interfaces;

use DeepCode\Models\Submission;
use DeepCode\Repositories\IRepository;

interface ISubmissionsRepository extends IRepository
{
    public function getUserSubmissions($userId): array;
}