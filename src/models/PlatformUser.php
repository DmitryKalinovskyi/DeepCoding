<?php

namespace DeepCode\models;

use Framework\attributes\Key;

class PlatformUser
{
    #[Key]
    public int $Id;
    public string $Login;
    public string $FullName;
    public string $AvatarUrl;
    public string $Description;
}