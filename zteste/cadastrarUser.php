<?php
    require_once(__DIR__ . '/../models/usuarioModel.php');

    $usuario = new UsuarioModel();

    $usuario->nome = "Joao";
    $usuario->login = "joao";
    $usuario->senha = password_hash("joao123", PASSWORD_DEFAULT);
    $usuario->token = bin2hex(random_bytes(16));
    $usuario->status = 1;

    if ($usuario->cadastrar()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário.";
    }
?>