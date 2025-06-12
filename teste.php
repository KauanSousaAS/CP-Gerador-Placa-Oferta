<?php

// Inicia a sessão caso ainda não tenha sido feito.
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['idUsuario'] = 123;
