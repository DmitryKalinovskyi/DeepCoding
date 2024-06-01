<?php

namespace DeepCode\Modules\Problems\Validation;

class SubmissionValidation
{
    public int $Id;
    public int $ProblemId;

    public int $UserId;
    public string $Code;
    public string $Compiler;
    public string $Status;
}