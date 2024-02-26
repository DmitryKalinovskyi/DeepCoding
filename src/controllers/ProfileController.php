<?php

namespace DeepCode\controllers;

use DeepCode\models\PlatformUser;
use Framework\mvc\ControllerBase;

class ProfileController extends ControllerBase{
    public function __construct(){

    }

    public function Index(){
        $data['profile'] = new PlatformUser();

        $data['profile']->Id=0;
        $data['profile']->FullName="Dmytro Kalinovskyi";
        $data['profile']->Description="Hello there!";
        $data['profile']->Login="DeeperXD";

        $data['profile']->AvatarUrl="public/img/testAvatar.png";

        $this->Render('profile.php', $data);
    }
}