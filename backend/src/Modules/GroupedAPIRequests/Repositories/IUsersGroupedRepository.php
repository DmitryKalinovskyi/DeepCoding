<?php

namespace DeepCode\Modules\GroupedAPIRequests\Repositories;

use DeepCode\Modules\GroupedAPIRequests\DTO\UserDTO;

interface IUsersGroupedRepository
{
    public function getUser(int $userId, int $myId): ?UserDTO;
}