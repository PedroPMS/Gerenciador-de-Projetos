<?php
/*
Esse view é para fazer a alteração de senha do usuário
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
                    <div class="card-header">Gerenciar CRUD</div>
                    <div class="card-body">
                        <form method="POST" action="../controllers/updatePassword.php">
                            <fieldset>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Senha Antiga</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" required="" name="senhaAntiga">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Senha Nova</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" required="" name="senhaNova">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirme a Senha Nova</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" required="" name="senhaConfirma">
                                </div>
                                <button type="submit" class="btn btn-primary">Alterar Senha</button>
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