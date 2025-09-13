<?php

require_once('../controllers/usuarioController.php');

$usuarioController = new usuarioController();
$usuarioController->validarSessao();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SistemaPDO</title>
</head>
<body>
    <h3>Pagina Inicial</h3>
    <div>
        <ul><a href="cadastros">Cadastros</a></ul>
        <ul><a href="lista">Lista</a></ul>
        <ul><a href="relatorios">Relatórios</a></ul>
        <ul><a href="logs">Logs</a></ul>
        <ul></ul>
    </div>
</body>
</html>