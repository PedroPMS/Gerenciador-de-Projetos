<?php
/*
Esse controller é usando para criar um novo usuário no sistema
*/

include_once('../connections/connection.php');
$query = $connection->prepare("SELECT * FROM users  WHERE email = :email");
$query->bindParam(':email', $_POST['email'], PDO::PARAM_STR); //reserva o campo :email do sql para o email que veio do front
$query->execute();

if($query->rowCount()){ //retorna o número de linha que a consulta trouxe
    echo "Já existe um registro com esse email";
    return false;
}

$salt = md5('criptofoda'); //cria uma chave encriptada para "misturar" com a senha que veio do front
$password = md5($_POST['password'] . $salt); //"mistura" as duas palavras criptografadas

$query = $connection->prepare("INSERT INTO users VALUE (null, 0, :email, :password)");
$query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
$query->bindValue(':password', $password, PDO::PARAM_STR);
print_r($query->rowCount());
if($query->execute()){
    echo "Usuário cadastrado com sucesso!";
    header("location: ../index.html");
    return true;
}

echo "Erro no cadastro";


