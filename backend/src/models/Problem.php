<?php


namespace DeepCode\models;

use Framework\attributes\DBColumn;
use Framework\attributes\Key;

class Problem
{
    #[Key]
    public int $Id;

    #[DBColumn]
    public string $Name;

    #[DBColumn]
    public string $Description;
}