<?php

namespace DeepCode\Modules\Users\Validation;

use Framework\Validation\Annotation\Required;
use Framework\Validation\Annotation\StringLength;

class UserUpdateValidation
{
    #[Required]
    #[StringLength(5)]
    public ?string $Name = null;
    #[Required]
    public ?string $AvatarUrl = null;

    #[Required]
    #[StringLength(5)]
    public ?string $Password = null;

    #[Required]
    public ?string $Description = null;
}