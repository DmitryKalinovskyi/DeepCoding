<?php

namespace DeepCode\Modules\Authentication\Validation;

use Framework\Validation\Annotation\Required;

class LoginValidation
{
    #[Required("Login field is required.")]
    public ?string $login = null;

    #[Required("Password field is required.")]
    public ?string $password = null;
}