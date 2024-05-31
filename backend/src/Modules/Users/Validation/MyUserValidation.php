<?php

namespace DeepCode\Modules\Users\Validation;

use Framework\Validation\Annotation\Required;
use Framework\Validation\Annotation\StringLength;

class MyUserValidation
{
    #[Required]
    #[StringLength(5)]
    public ?string $Name = null;
    public string $AvatarUrl = "";

    #[Required]
    #[StringLength(5)]
    public ?string $Password = null;
}