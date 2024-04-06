<?php

namespace DeepCode\models;

use Framework\attributes\DBColumn;
use Framework\attributes\Key;

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