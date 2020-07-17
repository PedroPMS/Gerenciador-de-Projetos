<?php
/*
Esse controller é usando para validar o acesso de um usuário no sistema e iniciar sua sessão
*/

session_start();
include_once('../connections/connection.php');

$query = $connection->prepare("SELECT * FROM users WHERE email = :email");
$query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
$query->execute();
if(!$query->rowCount()){
    echo "Email não encontrado!";
    return false;
}

$data = $query->fetch(PDO::FETCH_ASSOC);

$salt = md5('criptofoda');
$password = md5($_POST['password'] . $salt);

if($password != $data['senha']){
    echo 'Senha incorreta!';
    return false;
}


$_SESSION = $data;
$_SESSION['online'] = true;
header('location: ../view/dashboard.php');