<?php

require_once('config/token.php');

$sessao = new Token();

$sessao->validarSessao();


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SistemaPDO - Login</title>
</head>
<body>
    <form action="php/login.php" method="post">
        <label for="login">Login</label>
        <input type="text" id="login" name="login"><br>
        <label for="senha">Senha</label>
        <input type="text" id="senha" name="senha"><br>
        <button type="button">Logar</button>
    </form>
</body>
</html>