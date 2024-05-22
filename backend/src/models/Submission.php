<?php

namespace DeepCode\models;

use framework\attributes\DataAnnotation\DBColumn;
use framework\attributes\DataAnnotation\Key;

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
}