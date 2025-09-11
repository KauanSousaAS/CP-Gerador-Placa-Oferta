<?php

$requestUri = $_SERVER['REQUEST_URI'];

// Remove parâmetros da query string.
$path = parse_url($requestUri, PHP_URL_PATH);

// Se a URL for só "/index.php" ou "/index.php/"
if ($path === '/' || $path === '/index.php' || $path === '/index.php/') {
    header("Location:views/");
    exit;
}

// Quebra em partes: /index.php/produto/listar → ["index.php", "produto", "listar"]
$segments = explode('/', trim($path, '/'));

// Verifica se temos pelo menos 3 partes.
if (count($segments) >= 3) {
    $controllerName = $segments[1] . 'Controller'; // produto → produtoController
    $method = $segments[2];                        // listar → listar
    
    $controllerFile = 'controllers/' . $controllerName . '.php';
    
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                echo "Método '$method' não encontrado no controller '$controllerName'.";
            }
        } else {
            echo "Controller '$controllerName' não encontrado.";
        }
    } else {
        echo "Arquivo de controller '$controllerFile' não existe.";
    }
} else {
    echo "Rota inválida.";
}
