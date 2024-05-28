<?php

namespace DeepCode\Models;

use Framework\Attributes\DataAnnotation\DBColumn;
use Framework\Attributes\DataAnnotation\Key;

class PlatformUser
{
    #[Key]
    public int $Id;
    #[DBColumn]
    public string $Login;
    #[DBColumn]
    public string $Name;
    #[DBColumn]
    public string $AvatarUrl;
    #[DBColumn]
    public string $Password;
}