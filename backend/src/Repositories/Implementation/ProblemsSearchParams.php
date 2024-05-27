<?php

namespace DeepCode\Repositories\Implementation;

class ProblemsSearchParams
{
    public ?string $search = null;

    public int $page = 0;
    public int $pageSize = 25;

    public ?array $tags;
    public int $status;
}