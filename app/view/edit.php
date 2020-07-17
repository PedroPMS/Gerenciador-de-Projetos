<?php
/*
Esse view é para fazer a alteração do email do usuário
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

if($_GET['userId'] != $_SESSION['id'] && !$_SESSION['admin']){
    header('location: dashboard.php');
    return false;
}

$query = $connection->prepare("SELECT * FROM users WHERE id = :id");
$query->bindParam(':id', $_GET['userId'], PDO::PARAM_STR);
$query->execute();

if (!$query->rowCount()) {
    $_SESSION['msg'] = "0";
    header("location: gerenciar.php");
    return false;
}

$user = $query->fetch(PDO::FETCH_ASSOC);

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
    <?= include '../navbar.php';
    ?>
    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card  ">
                    <div class="card-header">Gerenciar CRUD</div>
                    <div class="card-body">
                        <form method="POST" action="../controllers/update.php">
                            <input type="hidden" name="userId" value="<?= $user['id'] ?>">
                            <fieldset>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $user['email'] ?>" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </fieldset>
                            <?php
                            if (isset($_SESSION['msg']) && !$_SESSION['msg']) {
                                error();
                                unset($_SESSION['msg']);
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>