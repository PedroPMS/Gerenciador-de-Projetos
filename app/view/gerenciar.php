<?php
/*
Esse view lista todos os usuários do sistema e mostra as ações que o usuário da sessão pode tomar com o usuário da lista
*/

include_once('../connections/connection.php');
include '../alerts.php';

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
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
    <?=include '../navbar.php'?>
        <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card  ">
                    <div class="card-header">Gerenciar Equipe</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Email</td>
                                    <td>Admin</td>
                                    <td>Ações</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $connection->prepare("SELECT * FROM users WHERE id != :id ORDER BY id DESC LIMIT 10");
                                $query->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
                                $query->execute();
                                $users = $query->fetchAll(PDO::FETCH_ASSOC);
                                if (!count($users)) {
                                ?>
                                    <tr>
                                        <td colspan="4">Não há registros</td>
                                    </tr>
                                <?php
                                }
                                foreach ($users as $user) {
                                ?>
                                    <tr>
                                        <td> <?= $user['id'] ?></td>
                                        <td> <?= $user['email'] ?></td>
                                        <td> <?= $user['admin'] ? "Sim" : "Não" ?></td>
                                        <td>
                                            <a class="btn btn-primary" href="read.php?userId=<?= $user['id'] ?>">Perfil</a>
                                            <a class="btn btn-primary" href="/view/tasks.php?userId=<?= $user['id'] ?>">Tarefas</a>
                                            <?php
                                            if (!$user['admin'] && $_SESSION['admin']) {
                                            ?>
                                                <a class="btn btn-primary" href="edit.php?userId=<?= $user['id'] ?>">Editar</a>
                                                <a class="btn btn-danger" href="../controllers/delete.php?userId=<?= $user['id'] ?>">Deletar</a>
                                            <?php
                                            }
                                            ?>
                                        </td>
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