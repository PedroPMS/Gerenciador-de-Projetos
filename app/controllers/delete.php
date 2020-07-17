<?php
/*
Esse controller é usando para deletar um usuário do sistema @users
*/
include_once('../connections/connection.php');

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

if(!$_SESSION['admin']){
    header('location: ../index.html');
    return false;
}

if(!isset($_GET['userId'])){
    header('location: ../view/dashboard.php');
    return false;
}

$query = $connection->prepare("DELETE FROM users WHERE id = :id");
$query->bindValue(':id', $_GET['userId'],PDO::PARAM_STR);
$query->execute();

if(!$query->rowCount()){
    echo 'deu ruim';
    return false;
}

header('location: ../view/gerenciar.php');

?>
