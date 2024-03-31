<?php

namespace DeepCode\controllers;

use DeepCode\db\DeepCodeContext;
use DeepCode\models\PlatformUser;
use Framework\mvc\ControllerBase;

class ProfileController extends ControllerBase{
    private DeepCodeContext $_context;

    public function __construct(DeepCodeContext $context){
        $this->_context = $context;
    }

    public function Index(){
        $data['profile'] = $this->_context->platformUsers->first();

        $this->render('profile.php', $data);
    }
}