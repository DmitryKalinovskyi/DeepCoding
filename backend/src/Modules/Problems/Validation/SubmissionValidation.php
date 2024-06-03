<?php

namespace DeepCode\Modules\Problems\Validation;

use Framework\Attributes\Mapping\IgnoreMapper;
use Framework\Validation\Annotation\Required;

class SubmissionValidation
{
    #[IgnoreMapper]
    public int $ProblemId = 0;

    #[IgnoreMapper]
    public int $UserId = 0;

    #[Required]
    public ?string $Code= null;
    #[Required]
    public ?string $Compiler = null;
}