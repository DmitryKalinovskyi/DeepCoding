<?php

namespace DeepCode\Models;

use Framework\Attributes\DataAnnotation\DBColumn;
use Framework\attributes\DataAnnotation\Key;

class ProblemTag
{
    #[Key]
    public int $Id;

    #[DBColumn]
    public string $Name;
}