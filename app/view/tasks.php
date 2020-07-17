<?php
/*
Esse view mostra todas as tarefas de um usuário
*/

include_once('../connections/connection.php');
include '../alerts.php';

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

if (!isset($_GET['userId'])) {
    header('location: gerenciar.php');
    return false;
}

$query = $connection->prepare(
    "SELECT email
    FROM users 
    WHERE id = :id"
    );
    $query->bindValue(':id', $_GET['userId'], PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>

<body>
    <?= include '../navbar.php' ?>
    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card  ">
                    <div class="card-header">Lista de Tarefas - <?=$user['email']?> 
                        <a href="addTask.php?userId=<?=$_GET['userId']?>"><img src="../css/add.svg" width="30" height="30"></a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Título</td>
                                    <td>Descrição</td>
                                    <td>Data de Início</td>
                                    <td>Data de Entrega</td>
                                    <td>Concluída</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $connection->prepare(
                                "SELECT id_user, id_tarefa, title, description
                                ,DATE_FORMAT( start_date, '%d/%m/%Y' ) AS start_date
                                ,DATE_FORMAT( end_date, '%d/%m/%Y' ) AS end_date
                                ,completed
                                FROM task 
                                WHERE id_user = :id ORDER BY id_tarefa DESC LIMIT 10"
                                );
                                $query->bindValue(':id', $_GET['userId'], PDO::PARAM_STR);
                                $query->execute();
                                $tasks = $query->fetchAll(PDO::FETCH_ASSOC);
                                if (!count($tasks)) {
                                ?>
                                    <tr>
                                        <td colspan="4">Não há tarefas</td>
                                    </tr>
                                <?php
                                }
                                foreach ($tasks as $task) {
                                ?>
                                    <tr>
                                        <td> <?= $task['title'] ?></td>
                                        <td> <?= $task['description'] ?></td>
                                        <td> <?= $task['start_date'] ?></td>
                                        <td> <?= $task['end_date'] ?></td>
                                        <td> <?= $task['completed'] ? 
                                        tarefaConcluida($task['id_user'],$task['id_tarefa'],$task['completed']) : 
                                        tarefaEmAndamento($task['id_user'],$task['id_tarefa'],$task['completed']) ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        if (isset($_SESSION['msg']) && !$_SESSION['msg']) {
                            error();
                            unset($_SESSION['msg']);
                        }
                        if (isset($_SESSION['msg']) && $_SESSION['msg']) {
                            sucesso();
                            unset($_SESSION['msg']);
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>