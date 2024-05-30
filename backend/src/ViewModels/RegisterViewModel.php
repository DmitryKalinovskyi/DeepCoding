<?php

namespace DeepCode\ViewModels;

use Framework\Validation\Annotation\StringLength;

class RegisterViewModel
{
    public string $Login;

    #[StringLength(5)]
    public string $Name;
    public string $AvatarUrl;

    #[StringLength(5)]
    public string $Password;
}