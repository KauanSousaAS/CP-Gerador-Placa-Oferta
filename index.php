<?php

// Roteamento simples.
$requestUri = $_SERVER['REQUEST_URI'] ?? null;

// Redireciona para a página inicial 'views/index.php'.
if($requestUri == '/' || $requestUri == '/index.php'){

    header("Location:views/");

}

// Ativa a função 'iniciarSessao' de 'loginController.php'.
if (strpos($requestUri, '/index.php/usuario/logar') === 0) {

    require_once 'controllers/loginController.php';
    $controller = new loginController();
    $controller->iniciarSessao();
    
}