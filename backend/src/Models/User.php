<?php

namespace DeepCode\Models;

use Framework\Attributes\DataAnnotation\DBColumn;
use Framework\Attributes\DataAnnotation\Key;

class User
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
    #[DBColumn]
    public int $RegisterDate;
    #[DBColumn]
    public string $Description;


    // socials
//    #[DBColumn]
//    public ?string $Twitter;
//    #[DBColumn]
//    public ?string $GitHub;
//    #[DBColumn]
//    public ?string $YouTube;
}