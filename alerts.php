<link rel="stylesheet" href="/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php
function error($var = 'Erro!')
{
?>

    <div id="status" class="alerta error"><?= $var ?></div>
    <script>
        $('#status').delay(2000).fadeOut(500);
    </script>
<?php
}
?>

<?php
function sucesso()
{
?>
    <div id="status" class="alerta sucesso">Sucesso!</div>
    <script>
        $('#status').delay(2000).fadeOut(500);
    </script>
<?php
}
?>

<?php
function tarefaConcluida($id_user,$id_tarefa,$completed)
{
?>
    <form method="POST" action="../controllers/updateTask.php">
    <input type="hidden" name="id" value="<?= $id_user ?>">
    <input type="hidden" name="task" value="<?= $id_tarefa ?>">
    <input type="hidden" name="completed" value="<?= $completed ?>">
    <button type="submit" id="btn" class="btn btn-primary">Sim</button>
    </form>
<?php
}
?>

<?php
function tarefaEmAndamento($id_user,$id_tarefa,$completed)
{
?>
    <form method="POST" action="../controllers/updateTask.php">
    <input type="hidden" name="id" value="<?= $id_user ?>">
    <input type="hidden" name="task" value="<?= $id_tarefa ?>">
    <input type="hidden" name="completed" value="<?= $completed ?>">
    <button type="submit" id="btn" class="btn btn-danger">Não</button>
    </form>
<?php
}
?>