<?php

namespace DeepCode\Models;

use Framework\Attributes\DataAnnotation\DBColumn;
use Framework\attributes\DataAnnotation\Key;

class Report
{
    #[Key]
    public int $Id;

    #[DBColumn]
    public int $UserId;

    #[DBColumn]
    public string $Title;

    #[DBColumn]
    public string $Content;
}