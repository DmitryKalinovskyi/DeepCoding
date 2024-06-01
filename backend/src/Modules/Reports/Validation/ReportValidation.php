<?php

namespace DeepCode\Modules\Reports\Validation;

use Framework\Attributes\Mapping\IgnoreMapper;
use Framework\Validation\Annotation\Required;
use Framework\Validation\Annotation\StringLength;

class ReportValidation
{
    #[IgnoreMapper]
    public int $UserId;

    #[Required]
    #[StringLength(5)]
    public ?string $Title = null;

    #[Required]
    public ?string $Content = null;
}