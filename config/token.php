<?php

function validarConexao()
{
    session_start();
    require_once 'conexao.php';

    if (!isset($_SESSION['usuario_id'], $_SESSION['token'])) {
        die("Acesso negado. Faça login.");
    }

    $conn = getConexao();
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ? AND token = ?");
    $stmt->execute([$_SESSION['usuario_id'], $_SESSION['token']]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        die("Sessão inválida. Faça login novamente.");
    }

    // Usuário autenticado
}


function gerarToken($tamanho = 32)
{
    return bin2hex(random_bytes($tamanho));
}
