<?php
/*
Esse controller é usando para finalizar a sessão de um usuário no sistema
*/

session_start();
session_destroy();
header('location: ../index.html');