<?php

namespace DeepCode\Modules\Problems\Repositories;

use Framework\Validation\Annotation\NonNegative;

class ProblemsSearchParams
{
    public ?string $name = null;
    #[NonNegative]
    public int $page = 0;

    #[NonNegative]
    public int $pageSize = 25;
    public ?array $tags = null;

    // NeverTried|Tried|Solved
    public ?string $status = null;

    // Easy|Medium|Hard
    public ?string $difficulty = null;

    public ?string $userId = null;

    public ?string $orderBy = null;
}