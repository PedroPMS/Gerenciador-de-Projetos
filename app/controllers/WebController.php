<?php

namespace App\Controllers;

use App\lib\Twig;
use App\Controllers\AuthController;

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

}