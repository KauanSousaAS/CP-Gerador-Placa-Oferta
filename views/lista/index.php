<?php

require_once('../../controllers/usuarioController.php');

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
    <h3>Lista</h3>
    <a href="../"><button>Voltar</button></a>
    <select name="selecao" id="seletorFilial" onchange="carregarProdutoFilial(this.value);">
        <option selected disabled> -- SELECIONE A FILIAL -- </option>
    </select>
    
    <br>
    
    <input type="text" name="pesquisarProduto" id="pesquisarProduto" placeholder="Pesquisar..." onkeyup="pesquisarProdutoFilial(this.value);">
    <div id="resultadoPesquisa" class="resultadoPesquisa"></div>
    <input type="button" onclick="adicionarProdutoFilial()" value="Adicionar">
    <a href="../cadastros/produto/cadastrar/"><button>Cadastrar</button></a>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Código(s)</th>
                <th class="textoEsquerda">Descrição</th>
                <th>Preço(s)</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="listaProdutosFilial"></tbody>
    </table>
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
</body>

<link rel="stylesheet" href="/assets/css/views/lista/lista.css">
<script src="/assets/js/views/lista/lista.js"></script>
<script src="/assets/js/views/util/contrutor.js"></script>

<script>
    window.onload = function() {
        carregarFiliais();
    }
</script>


</html>