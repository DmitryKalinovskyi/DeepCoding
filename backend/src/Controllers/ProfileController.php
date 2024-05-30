<?php

namespace DeepCode\Controllers;

use DeepCode\DB\DeepCodeContext;
use DeepCode\Models\User;
use Framework\attributes\Routing\Route;
use Framework\MVC\ControllerBase;

class ProfileController extends ControllerBase{
    private DeepCodeContext $_db;

    public function __construct(DeepCodeContext $context){
        $this->_db = $context;
    }

    #[Route("/")]
    public function Index(){
        $data['profile'] = $this->_db->platformUsers
            ->select()
            ->first();

        $this->render('profile.php', $data);
    }
}