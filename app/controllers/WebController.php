<?php

namespace App\Controllers;

use App\lib\Twig;
use App\Controllers\AuthController;
use App\Models\Users;

class WebController {

    public $twig;

    public function __construct($router)
    {
        $this->twig = Twig::load();
    }

    public function home()
    {
        if (AuthController::verifyLogin()) {
            echo $this->twig->render('dashboard.html');
        } else {
            echo $this->twig->render('index.html');
        }
    }

    public function register()
    {
        echo $this->twig->render('register.html');
    }

    public function createUser($data)
    {
        $user = new Users;
        if($user->create($data)){
            echo $this->twig->render('index.html');
        }else{
            echo $this->twig->render('register.html');
        }
    }

}