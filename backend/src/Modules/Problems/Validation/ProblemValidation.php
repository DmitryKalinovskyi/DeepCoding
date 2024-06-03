<?php

namespace DeepCode\Modules\Problems\Validation;

use Framework\Validation\Annotation\IsJson;
use Framework\Validation\Annotation\Required;

class ProblemValidation
{
    #[Required]
    public ?string $Name = null;

    #[Required]
    public ?string $Description = null;

    #[Required]
    public ?string $TestingScript = null;

    #[Required]
    public ?string $TestingScriptLanguage = null;

    #[Required]
    #[IsJson]
    public ?string $Tests = null;

}