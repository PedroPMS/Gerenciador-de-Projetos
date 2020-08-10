<?php

namespace App\Controllers;

use App\lib\Twig;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Models\Tasks;

class TaskController {

    public $twig;

    public function __construct($router)
    {
        $this->twig = Twig::load();
    }

    public static function getAmoutTasks($id)
    {
        $tasksData =  self::getAllUsersTasks($id);

        return count($tasksData);
    }

    public static function getAllUsersTasks($id)
    {
        $usersTasks = [];
        $tasks = new Tasks;
        $tasksData =  $tasks->getAll();
        foreach($tasksData as $task){
            if ($task['id_user'] == $id) {
                $usersTasks[] = $task;
                
            }
        }
        return $usersTasks;
    }

    public function showAllUsersTasks($data)
    {
        if (!AuthController::verifyLogin()) {
            header('location: ' . URL_BASE);
        }

        if (!isset($data['id'])) {
            header('location: ' . URL_BASE);
            return false;
        }
        
        $tasksData =  self::getAllUsersTasks($data['id']);
        $userData = UserController::getUserById($data['id']);
        
        if (isset($_GET['success'])) {
            echo $this->twig->render('tasks.html',[
                'tasksData'  => $tasksData,
                'userData'  => $userData,
                'success'   => 'Tarefa criada com sucesso!',
                'session'   => $_SESSION
            ]);
            return true;
        }

        echo $this->twig->render('tasks.html',[
            'tasksData'  => $tasksData,
            'userData'  => $userData,
            'session'   => $_SESSION
        ]);
    }

    public function formCreateTasks($data)
    {
        if (!AuthController::verifyLogin()) {
            header('location: ' . URL_BASE);
        }
        if (!isset($data['id'])) {
            header('location: ' . URL_BASE);
            return false;
        }

        $userData = UserController::getUserById($data['id']);

        if (isset($_GET['error'])) {
            echo $this->twig->render('addTask.html',[
                'userData'  => $userData,
                'error'     => 'Erro ao cadastrar tarefa!',
                'session'   => $_SESSION
            ]);
            return false;
        }
        
        echo $this->twig->render('addTask.html',[
            'userData'  => $userData,
            'session'   => $_SESSION
        ]);
    }
    
    public function createTasks($data)
    {
        if (!AuthController::verifyLogin()) {
            header('location: ' . URL_BASE);
        }
        if (!isset($data['id'])) {
            header('location: ' . URL_BASE);
            return false;
        }

        $tasks = new Tasks;
        if($tasks->create($_POST)){
            header('location: '.URL_BASE.'tasks/'.$_POST['id_user'].'?success=1');
        }else{
            header('location: '.URL_BASE.'addTask/'.$_POST['id_user']).'?error=1';
        }
    }

}