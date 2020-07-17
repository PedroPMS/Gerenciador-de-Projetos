<?php
/*
Esse controller é usando para alterar o email de um usuário do sistema
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

$id = $_POST['userId'];

$query = $connection->prepare("UPDATE users SET email = :email WHERE id = :id");
$query->bindParam(':id',$_POST['userId'],PDO::PARAM_STR);
$query->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
$query->execute();

if(!$query->rowCount()){
    $_SESSION['msg'] = "0";
    header("location: ../view/edit.php?userId=$id");
    return false;
}
$_SESSION['msg'] = "1";
header('location: ../view/gerenciar.php');

