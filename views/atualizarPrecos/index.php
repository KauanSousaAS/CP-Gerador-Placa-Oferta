<?php

require_once('../../controllers/usuarioController.php');
$usuarioController = new usuarioController();
$usuarioController->validarSessao();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SistemaPDO</title>
</head>

<body>
    <h3>Atualizar preços dos produtos</h3>

    <Label>Importar preços novos</Label><br><br>
    <input type="file" name="dados" id="dados"><br><br>
    <select name="uf" id="uf">
        <option value="PR" selected>PR</option>
        <option value="MS">MS</option>
    </select><br><br>
    <a href="../"><button>Voltar</button></a>
    <button type="button" onclick="atualizarPreco()">Importar</button>
</body>

<!-- Importando biblioteca para transcrição do excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


<script src="/assets/js/views/util/atualizarPreco.js"></script>

</html>