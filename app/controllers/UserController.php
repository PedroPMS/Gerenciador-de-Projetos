<?php

namespace App\Controllers;

use App\lib\Twig;
use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Models\Users;

class UserController {

    public $twig;

    public function __construct($router)
    {
        $this->twig = Twig::load();
    }

    public function userProfile($data)
    {
        if (!AuthController::verifyLogin()) {
            header('location: ' . URL_BASE);
        }
        if (!isset($data['id'])) {
            header('location: ' . URL_BASE);
            return false;
        }

        $user = new Users;
        $userData = $user->getById($data['id']);
        
        $usersTaks = TaskController::getAmoutTasks($data['id']);

        echo $this->twig->render('read.html',[
            'userData'  => $userData,
            'userTasks' => $usersTaks,
            'session'   => $_SESSION
        ]);
    }

    public function createUser($data)
    {
        $user = new Users;
        if($user->create($data)){
            echo $this->twig->render('index.html', [
                'success' => 'Cadastrado com sucesso!'
            ]);
            
        }else{
              echo $this->twig->render('register.html', [
                'error' => 'Email já cadastrado!'
            ]);
            return false;
        }
    }

    public static function getUserById($id)
    {
        $user = new Users;
        return $user->getById($id);
    }

    public function management()
    {
        if (!AuthController::verifyLogin()) {
            header('location: ' . URL_BASE);
        }

        $user = new Users;
        $usersData = $user->getAll();
        if($usersData){
            echo $this->twig->render('gerenciar.html', [
                'usersData' => $usersData,
                'session'   => $_SESSION
            ]);
            
        }else{
              echo $this->twig->render('gerenciar.html', [
                'error' => 'Erro ao buscar usuário!'
            ]);
            return false;
        }

    }
}