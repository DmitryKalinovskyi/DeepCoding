<?php

namespace DeepCode\Modules\Problems\DTO;

use Framework\Attributes\Mapping\IgnoreMapper;

class SubmissionDTO
{
    public int $Id;
    public int $ProblemId;

    public int $UserId;
    public string $Code;
    public string $Compiler;
    public bool $IsPassed;
    #[IgnoreMapper]
    public object $Result;

    public int $CreatedTime;

    public string $UserLogin;

    public string $ProblemName;
}