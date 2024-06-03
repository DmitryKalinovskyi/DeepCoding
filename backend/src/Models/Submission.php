<?php

namespace DeepCode\Models;

use Framework\Attributes\DataAnnotation\DBColumn;
use Framework\Attributes\DataAnnotation\Key;

class Submission
{
    #[Key]
    public int $Id;
    #[DBColumn]
    public int $ProblemId;

    #[DBColumn]
    public int $UserId;
    #[DBColumn]
    public string $Code;
    #[DBColumn]
    public string $Compiler;
    #[DBColumn]
    public bool $IsPassed;
    #[DBColumn]
    public string $Result;
    #[DBColumn]
    public int $CreatedTime;
}