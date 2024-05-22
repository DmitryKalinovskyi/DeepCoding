<?php

namespace DeepCode\models;

use framework\attributes\DataAnnotation\DBColumn;
use framework\attributes\DataAnnotation\Key;

class PlatformUser
{
    #[Key]
    public int $Id;
    #[DBColumn]
    public string $Login;
    #[DBColumn]
    public string $FirstName;
    #[DBColumn]
    public string $LastName;
    #[DBColumn]
    public string $AvatarUrl;
    #[DBColumn]
    public string $Description;

    public function GetFullName(): string{
        return "$this->FirstName $this->LastName";
    }
}