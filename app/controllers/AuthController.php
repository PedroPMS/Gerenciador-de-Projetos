<?php

namespace App\Controllers;

use App\Connections\Database;
use App\lib\Twig;

class AuthController
{

    public static function verifyLogin(): Bool
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['online'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function login(array $userData): Bool
    {
        session_start();
        $connection = Database::Conection();
        $twig       = Twig::load();

        $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $userData['email'], \PDO::PARAM_STR);
        $query->execute();
        if (!$query->rowCount()) {

            echo $twig->render('index.html', [
                'error' => 'E-mail não encontrado!'
            ]);
            return false;
        } else {

            $data       = $query->fetch(\PDO::FETCH_ASSOC);
            $hashed_password = password_hash($userData['password'], PASSWORD_DEFAULT);

            if (password_verify($userData['password'], $hashed_password)) {
                $_SESSION['id']     = $data['id'];
                $_SESSION['admin']  = $data['admin'];
                $_SESSION['email']  = $data['email'];
                $_SESSION['online'] = true;
                header('location: ' . URL_BASE);
                exit();
            } else {
                echo $twig->render('index.html', [
                    'error' => 'Senha incorreta!'
                ]);
                return false;
            }
        }
    }

    public static function logout(): void
    {
        session_start();
        session_destroy();
        header('location: ' . URL_BASE);
    }
}
