<?php

namespace DeepCode\Modules\Reports\Repositories;

use Framework\Validation\Annotation\NonNegative;

class ReportsSearchParams
{
    public ?string $title = null;

    #[NonNegative]
    public int $page = 0;

    #[NonNegative]
    public int $pageSize = 25;
}