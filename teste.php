<?php
// ================================================================================
// Arquivo para inserção de código para executar testes
// ================================================================================

// Inicia a sessão caso ainda não tenha sido feito.
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['idUsuario'] = 123;
