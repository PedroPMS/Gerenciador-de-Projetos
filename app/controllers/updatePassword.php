<?php
/*
Esse controller é usando para alterar a senha de um usuário do sistema
*/

include_once('../connections/connection.php');
session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

$query = $connection->prepare("SELECT * FROM users WHERE id = :id");
$query->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
$query->execute();

if(!$query->rowCount()){
    header("location: ../view/read.php?userId=$_SESSION[id]");
    return false;
}

$data = $query->fetch(PDO::FETCH_ASSOC);

$passwordAntigaBD = $data['senha'];
$salt = md5('criptofoda');
$passwordAntigaSession = md5($_POST['senhaAntiga'] . $salt);

if($passwordAntigaSession != $passwordAntigaBD){
    $_SESSION['msg'] = "0";
    header('location: ../view/editSenha.php');
    return false;
}

if($_POST['senhaNova'] != $_POST['senhaConfirma']){
    $_SESSION['msg'] = "1";
    header('location: ../view/editSenha.php');
    return false;
}

$newPassword = md5($_POST['senhaNova'] . $salt);

$query = $connection->prepare("UPDATE users SET senha = :pass WHERE id = :id");
$query->bindParam(':id',$_SESSION['id'],PDO::PARAM_STR);
$query->bindParam(':pass',$newPassword,PDO::PARAM_STR);
$query->execute();

if(!$query->rowCount()){
    echo 'deu ruim';
    return false;
}

header("location: ../view/read.php?userId=$_SESSION[id]&status=1");