<?php

namespace DeepCode\Modules\News\Validation;

use DateTime;
use Framework\Attributes\Mapping\IgnoreMapper;
use Framework\Validation\Annotation\IsJson;
use Framework\Validation\Annotation\Required;
use Framework\Validation\Annotation\StringLength;

class NewsValidation
{
    #[Required]
    #[StringLength(3, 100)]
    public ?string $Title = null;

    #[Required]
    #[IsJson]
    public ?string $Content = null;

    #[IgnoreMapper]
    public int $CreatedTime;
}