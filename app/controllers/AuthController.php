<?php

namespace App\Controllers;

use App\Connections\Database;
use App\lib\Twig;

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

    public static function login(Array $userData): Bool
    {
        session_start();
        $connection = Database::Conection();
        $twig       = Twig::load();

        $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $userData['email'], \PDO::PARAM_STR);
        $query->execute();
        if(!$query->rowCount()) {

            echo $twig->render('index.html', [
                'error' => 'E-mail não encontrado!']);
            return false;
        
        } else {

            $data       = $query->fetch(\PDO::FETCH_ASSOC);
            $salt       = md5('criptofoda');
            $password   = md5($userData['password'] . $salt);

            if($password != $data['senha']){
                echo $twig->render('index.html', [
                    'error' => 'Senha incorreta!'
                ]);
                return false;
            }

            $_SESSION           = $data;
            $_SESSION['online'] = true;
            header('location: ' . URL_BASE);
        }
    }

    public static function logout(): void
    {
        session_start();
        session_destroy();
        header('location: ' . URL_BASE);
    }
}