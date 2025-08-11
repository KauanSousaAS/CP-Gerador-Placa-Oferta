<?php

// Roteamento simples.
$requestUri = $_SERVER['REQUEST_URI'] ?? null;

// Redireciona para a página inicial 'views/index.php'.
if ($requestUri == '/' || $requestUri == '/index.php') {

    header("Location:views/");
}

// Ativa a função 'iniciarSessao' de 'loginController.php'.
if (strpos($requestUri, '/index.php/usuario/logar') === 0) {

    require_once 'controllers/usuarioController.php';
    $controller = new usuarioController();
    $controller->iniciarSessao();
}

// Inicializador das funções de 'produtoController.php'.
if (strpos($requestUri, '/index.php/produto/') === 0) {

    // Instancia o controlador de produtos.
    require_once 'controllers/produtoController.php';
    $controller = new produtoController();

    // Inicia a função de cadastrar produtos.
    if (strpos($requestUri, '/index.php/produto/cadastrar') === 0) {
        $controller->cadastrar();
    }
    
    // Inicia a função de listar produtos.
    if (strpos($requestUri, '/index.php/produto/listar') === 0) {
        $controller->listar();
    }
}
