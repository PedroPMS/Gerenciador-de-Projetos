<?php
/*
Esse view é para o usuário cadastrar uma nova tarefa
*/

session_start();
if (!$_SESSION['online']) {
    header("location: ../index.html");
    return false;
}

include '../alerts.php';

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
                    <div class="card-header">Adicionar Tarefa</div>
                    <div class="card-body">
                        <form method="POST" action="../controllers/createTask.php">
                            <fieldset>
                                <input type="hidden" required="" value="<?=$_GET['userId']?>" name="id_user">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Título</label>
                                    <input type="text" class="form-control" required="" name="title">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Descrição</label>
                                    <input type="text" class="form-control" required="" name="description">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Data de Início</label>
                                    <input type="date" class="form-control" required="" name="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Data de Fim</label>
                                    <input type="date" class="form-control" required="" name="end_date">
                                </div>
                                <input type="hidden" required="" value="0" name="completed">
                                <button type="submit" class="btn btn-primary">Criar Tarefa</button>
                            </fieldset>
                        </form>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            $case = $_SESSION['msg'];
                            switch ($case) {
                                case 0:
                                    error('Senha antiga errada!');
                                    break;
                                case 1:
                                    error('Senhas não conferem!');
                                    break;
                                default:
                                    break;
                            }
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