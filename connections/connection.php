<?php
/*
Arquivo para conexão com o banco de dados
*/

$host = "localhost";
$dbname = "crud_php";
$port = "3308";
$user = "root";
$password = "Acc09d123";

$connection =  new PDO("mysql:host=$host;dbname=$dbname;port=$port", "$user", "$password");