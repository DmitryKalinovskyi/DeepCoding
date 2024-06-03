<?php


namespace DeepCode\Models;

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

    #[DBColumn]
    public string $TestingScript;

    #[DBColumn]
    public string $TestingScriptLanguage;

    #[DBColumn]
    public string $Tests; // as JSON
}