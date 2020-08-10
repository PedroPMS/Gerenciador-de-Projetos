<?php

namespace App\Controllers;

use App\lib\Twig;
use App\Controllers\AuthController;
use App\Models\Users;
use App\Models\Tasks;

class WebController {

    public $twig;

    public function __construct($router)
    {
        $this->twig = Twig::load();
    }

    public function home()
    {
        if (AuthController::verifyLogin()) {
            echo $this->twig->render('dashboard.html',[
                'session' => $_SESSION
            ]);
        } else {
            echo $this->twig->render('index.html');
        }
    }
    
    public function register()
    {
        echo $this->twig->render('register.html');
    }

    public function notfound(array $data): void
    {
        echo "<h3>Whoops!</h3>", "<pre>", print_r($data, true), "</pre>";
    }
}