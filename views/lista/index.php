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

    <select name="seletorFilial" id="seletorFilial" onchange="carregarProdutoFilial(this.value);">
        <option selected disabled> -- SELECIONE A FILIAL -- </option>
    </select>

    <br><br>

    <label for="pesquisarProduto">Adicionar Produto</label><br>
    <input type="text" name="pesquisarProduto" id="pesquisarProduto" placeholder="Pesquisar..." onkeyup="pesquisarProdutoFilial(this.value);">
    <div id="resultadoPesquisa" class="resultadoPesquisa"></div>
    <a href="../cadastros/produto/cadastrar/"><button>Cadastrar Novo Produto</button></a>
    <button type="button" onclick="carregarProdutoFilial(document.getElementById('seletorFilial').value)">Atualizar</button>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>
                        <select name="selecaoProdutosLista" id="selecaoProdutosLista" onchange="marcarCheckboxs(this.value);">
                            <option value=0 selected>--</option>
                            <option value=1>T</option>
                            <option value=2>P</option>
                        </select>
                    </th>
                    <th>Código(s)</th>
                    <th class="textoEsquerda">Descrição</th>
                    <th>Manual</th>
                    <th>Estoque</th>
                    <th>Situação</th>
                    <th>Última Tiragem</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="listaProdutosFilial"></tbody>
        </table>
    </div>

    <a href="../"><button>Voltar</button></a>
    <button type="button" onclick="exibir();">Exibir</button>
    <button type="button" onclick="concluir();">Concluir</button>
    <button type="button" onclick="retirar();">Retirar</button>
</body>

<link rel="stylesheet" href="/assets/css/views/lista/lista.css">
<script src="/assets/js/views/lista/lista.js"></script>
<script src="/assets/js/views/util/construtor.js"></script>

<script>
    window.onload = function() {
        carregarFiliais();
    }
</script>


</html>