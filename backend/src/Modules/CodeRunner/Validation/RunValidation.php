<?php

namespace DeepCode\Modules\CodeRunner\Validation;

use Framework\Validation\Annotation\Required;

class RunValidation
{
    #[Required]
    public ?string $Code = null;

    #[Required]
    public ?string $Compiler = null;

}