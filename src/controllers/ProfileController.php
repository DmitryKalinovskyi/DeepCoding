<?php

namespace DeepCode\controllers;

use DeepCode\db\DeepCodeContext;
use DeepCode\models\PlatformUser;
use Framework\mvc\ControllerBase;

class ProfileController extends ControllerBase{
    private DeepCodeContext $_db;

    public function __construct(DeepCodeContext $context){
        $this->_db = $context;
    }

    public function Index(){
        $data['profile'] = $this->_db->platformUsers
            ->select()
            ->first();

        $this->render('profile.php', $data);
    }
}