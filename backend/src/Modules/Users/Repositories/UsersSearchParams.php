<?php

namespace DeepCode\Modules\Users\Repositories;

use Framework\Validation\Annotation\NonNegative;

class UsersSearchParams
{
    public ?string $login = null;

    #[NonNegative]
    public int $page = 0;

    #[NonNegative]
    public int $pageSize = 25;
}