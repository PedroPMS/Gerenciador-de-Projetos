<?php
/*
Esse view mostra as informações completa de um usuário específico
*/

include_once('../connections/connection.php');
include '../alerts.php';

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

if (!isset($_GET['userId'])) {
    header('location: dashboard.php');
    return false;
}

$query = $connection->prepare("SELECT * FROM users WHERE id = :id");
$query->bindParam(':id', $_GET['userId'], PDO::PARAM_INT);
$query->execute();

if (!$query->rowCount()) {
    header("location: dashboard.php?error=1");
    return false;
}
$user = $query->fetch(PDO::FETCH_ASSOC);

$query = $connection->prepare("SELECT COUNT(id_tarefa) as tasks FROM task WHERE id_user = :id AND completed = 0");
$query->bindParam(':id', $_GET['userId'], PDO::PARAM_INT);
$query->execute();
$tasks = $query->fetch(PDO::FETCH_ASSOC);

if (!$query->rowCount()) {
    header("location: dashboard.php?error=1");
    return false;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <title>Dashboard</title>
</head>

<body>
    <?= include '../navbar.php' ?>
    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card  ">
                    <div class="card-header">Perfil</div>
                    <div class="card-body">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td><?= $user['id'] ?></td>
                                </tr>
                                <tr>
                                    <td>E-mail</td>
                                    <td><?= $user['email'] ?></td>
                                </tr>
                                <tr>
                                    <td>Admin</td>
                                    <td><?= $user['admin'] ? "Sim" : "Não" ?></td>
                                </tr>
                                <tr>
                                    <td>Tarefas em Andamento</td>
                                    <td><?=$tasks['tasks']?></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php
                        if ($_SESSION['id'] == $user['id'] || $_SESSION['admin']) {
                        ?>
                            <a class="btn btn-primary" href="edit.php?userId=<?= $user['id'] ?>">Alterar Email</a>
                        <?php
                        }
                        ?>
                        <?php
                        if ($_SESSION['id'] == $user['id']) {
                        ?>
                            <a class="btn btn-primary" href="editSenha.php">Alterar Senha</a></td>
                        <?php
                        }
                        if (isset($_GET['status'])) {
                            sucesso();
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>