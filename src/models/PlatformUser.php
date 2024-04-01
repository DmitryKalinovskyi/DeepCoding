<?php

namespace DeepCode\models;

use Framework\attributes\DBColumn;
use Framework\attributes\Key;

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