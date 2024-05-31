<?php

namespace DeepCode\Modules\News\Repositories;

class NewsSearchParams
{
    public ?string $title = null;

    public int $page = 0;

    public int $pageSize = 25;
}