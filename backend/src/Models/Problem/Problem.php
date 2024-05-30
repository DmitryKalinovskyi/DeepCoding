<?php


namespace DeepCode\Models\Problem;

use Framework\Attributes\DataAnnotation\DBColumn;
use Framework\Attributes\DataAnnotation\Key;

class Problem
{
    #[Key]
    public int $Id;

    #[DBColumn]
    public string $Name;

    #[DBColumn]
    public string $Description;
}