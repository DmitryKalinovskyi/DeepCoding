<?php

namespace DeepCode\Modules\GroupedAPIRequests\DTO;

class UserDTO
{
    public int $Id;
    public string $Login;
    public string $Name;
    public string $AvatarUrl;
    public int $RegisterDate;
    public string $Description;

    public int $Followers;
    public int $Followings;

    public bool $IsFollowed;

    // later add submissions


}