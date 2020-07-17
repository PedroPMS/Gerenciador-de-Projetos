<?php
/*
Esse controller é usando para criar uma nova tarefa para um usuário @task
*/

include_once('../connections/connection.php');

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

$id_user = $_POST['id_user'];
$query = $connection->prepare("INSERT INTO task  VALUES (null, :id_user, :title, :description, :start_date, :end_date, 0)");
$query->bindValue(':id_user',$_POST['id_user'], PDO::PARAM_STR);
$query->bindValue(':title',$_POST['title'], PDO::PARAM_STR);
$query->bindValue(':description',$_POST['description'], PDO::PARAM_STR);
$query->bindValue(':start_date',$_POST['start_date'], PDO::PARAM_STR);
$query->bindValue(':end_date',$_POST['end_date'], PDO::PARAM_STR);

if($query->execute()){
    echo "Usuário cadastrado com sucesso!";
    header("location: ../view/tasks.php?userId=$id_user");
    return true;
}

echo "Erro no cadastro";