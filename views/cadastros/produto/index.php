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
    <h3>Produto</h3>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Código(s)</th>
                <th class="textoEsquerda">Descrição</th>
                <th>Preço(s)</th>
                <th>Manual</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="listaProdutos">
        </tbody>
    </table>
    <a href="../"><button>Voltar</button></a>
    <select name="selecao" id="selecao">
        <option selected> -- sem seleção -- </option>
        <option value="1">Todos</option>
        <option value="2">Pendêntes</option>
    </select>
    <select name="acao" id="acao">
        <option selected> -- sem ação -- </option>
        <option value="exibir">Exibir</option>
        <option value="concluir">Concluir</option>
        <option value="excluir">Excluir</option>
    </select>
    <button type="button" onclick="acoesExecutar(document.getElementById('acao').value);">Executar</button>
    <a href="cadastrar"><button>Cadastrar</button></a>
</body>

<link rel="stylesheet" href="/assets/css/views/cadastros/produto/produto.css">
<script src="/assets/js/views/util/construtor.js"></script>
<script src="/assets/js/views/cadastros/produto.js"></script>

<script>
    // Iniciar a requisição para listar os produtos.
    listarProdutos();
</script>

</html>