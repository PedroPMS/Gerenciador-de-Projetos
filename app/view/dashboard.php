<?php
/*
Essa view é a inicial do sistema
*/

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
    <?= include '../navbar.php'?>
    <div class="container">
        <hr>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card text-white bg-info ">
                    <div class="card-header">Fodase</div>
                    <div class="card-body">

                        <p class="card-text">Seja bem vindo ao meu saite</p>
                        <img src="https://media.giphy.com/media/sIIhZliB2McAo/200_d.gif" alt="">
                        <i>Por: Pedro</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>