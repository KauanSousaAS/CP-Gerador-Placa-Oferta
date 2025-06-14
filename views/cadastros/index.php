<?php

require_once('../../controllers/usuarioController.php');

$controller = new usuarioController();
$controller->validarSessao();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SistemaPDO</title>
</head>

<body>
    <h3>Cadastros</h3>
    <div>
        <ul><a href="produto/">Produto</a></ul>
        <ul><a href="filial/">Filial</a></ul>
        <ul><a href="usuario/">Usuario</a></ul>
        <ul><a href=""></a></ul>
    </div>
    <a href="../"><button>Voltar</button></a>
</body>

</html>