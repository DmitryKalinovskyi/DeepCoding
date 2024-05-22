<?php


namespace DeepCode\models;

use framework\attributes\DataAnnotation\DBColumn;
use framework\attributes\DataAnnotation\Key;

class Problem
{
    #[Key]
    public int $Id;

    #[DBColumn]
    public string $Name;

    #[DBColumn]
    public string $Description;
}