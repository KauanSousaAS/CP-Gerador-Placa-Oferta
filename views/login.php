<?php

// require_once('../controllers/usuarioController.php');

// validarSessao();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SistemaPDO - Login</title>
</head>

<body>
    <form method="post">
        <label for="login">Login</label>
        <input type="text" id="login" name="login"><br>
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha"><br>
        <button type="button" onclick="logar();">Logar</button>
    </form>
</body>
<script src="/assets/js/views/login.js"></script>
</html>