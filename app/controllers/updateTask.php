<?php
/*
Esse controller é usando para atualizar o status de uma tarefa do usuário para concluída ou não concluída
*/

include_once('../connections/connection.php');

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

$id_user = $_POST['id'];
$id_task = $_POST['task'];
$completed = $_POST['completed'];

if ($completed) {
    $completed = 0;
} else {
    $completed = 1;
}

$query = $connection->prepare("UPDATE task SET completed = :completed WHERE id_user = :id_user AND id_tarefa = :id_task");
$query->bindParam(':id_user', $id_user, PDO::PARAM_STR);
$query->bindParam(':id_task', $id_task, PDO::PARAM_STR);
$query->bindParam(':completed', $completed, PDO::PARAM_STR);

$query->execute();

if (!$query->rowCount()) {
    header("location: ../view/tasks.php?userId=$id_user");
    return false;
}
header("location: ../view/tasks.php?userId=$id_user");
