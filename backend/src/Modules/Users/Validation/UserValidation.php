<?php

namespace DeepCode\Modules\Users\Validation;

use Framework\Validation\Annotation\Required;
use Framework\Validation\Annotation\StringLength;

class UserValidation
{
    #[Required]
    #[StringLength(4)]
    public ?string $Login = null;

    #[Required]
    #[StringLength(5)]
    public ?string $Name = null;
    public string $AvatarUrl = "";

    #[Required]
    #[StringLength(5)]
    public ?string $Password = null;
}