<?php

require_once('../controllers/loginController.php');

$controller = new loginController();
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
    <h3>Pagina Inicial</h3>
</body>
</html>