<?php

namespace App\Controllers;

class AuthController {

    public static function verifyLogin(): Bool
    {
        session_start();
        if (isset($_SESSION['online'])) {
            return true;
        } else {
            return false;
        }
    }
}