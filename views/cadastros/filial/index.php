<?php

require_once('../../../controllers/usuarioController.php');

$controller = new usuarioController();
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
    <h3>Filial</h3>
    <table>
        <thead>
            <th class="width10">Código(s)</th>
            <th class="textoEsquerda">Descrição</th>
            <th class="width10">Preço(s)</th>
            <th class="width20">Ações</th>
        </thead>
        <tbody>

        </tbody>
    </table>
    
    <a href="../"><button>Voltar</button></a>
</body>
<link rel="stylesheet" href="/assets/css/lista.css">
</html>