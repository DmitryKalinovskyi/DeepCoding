<?php

namespace DeepCode\models;

use Framework\attributes\Key;

class PlatformUser
{
    #[Key]
    public int $Id;
    public string $Login;

    public string $FirstName;
    public string $LastName;
    public string $AvatarUrl;
    public string $Description;

    public function GetFullName(): string{
        return "$this->FirstName $this->LastName";
    }
}