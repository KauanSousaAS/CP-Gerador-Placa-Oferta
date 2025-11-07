<?php

require_once('../../../../controllers/usuarioController.php');

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
    <form action="../php/funcoes.php" method="POST" id="formulario">
        <input type="text" name="funcao" value="cadastrarProduto" style="display: none;">

        <div style="display: block; width: 100%;">
            <div style="width: 15%; display: inline-block; margin-right: 5%;">
                <label for="status">Status</label><br>
                <input type="checkbox" tabindex="1" name="status" id="status" checked>
            </div>
            <div style="width: 15%; display: inline-block; margin-right: 5%;">
                <label for="manual">Manual</label><br>
                <input type="checkbox" tabindex="" name="manual" id="manual">
            </div>
        </div>
        <div style="display: block; width: 100%;">
            <div style="width: 15%; display: inline-block; margin-right: 5%;">
                <label for="codigo">Códigos</label><br>
                <input autofocus autocomplete="off" tabindex="2" type="text" name="codigo" id="codigo" style="width: 100%;">
            </div>
            <div style="width: 75%; display: inline-block;">
                <label for="descricao">Descrição</label><br>
                <input autocomplete="off" tabindex="3" type="text" name="descricao" id="descricao" style="width: 100%;">
            </div>
        </div>

        <div style="display: block; width: 100%;">
            <div style="width: 15%; display: inline-block; margin-right: 5%;">
                <label for="volume">Volume:</label><br>
                <select tabindex="4" name="volume" id="volume">
                    <option value="UN">Unidade</option>
                    <option value="KG">Quilo</option>
                    <option value="MT">Metro</option>
                    <option value="RL">Rolo</option>
                    <option value="PR">Par</option>
                    <option value="CX">Caixa</option>
                    <option value="CT">Cento</option>
                    <option value="ML">Milheiro</option>
                </select>
            </div>
            <div style="width: 15%; display: inline-block; margin-right: 5%;">
                <label for="venda">Venda:</label><br>
                <select tabindex="5" name="venda" id="venda">
                    <option value="UN" selected>Unitária</option>
                    <option value="QN">Quantidade</option>
                </select>
            </div>
        </div>

        <div id="telaValorUnitario">
            <h4>Valor Unitário</h4>
            <Tr>
                <td>
                    <label for="valorUntPr">Valor PR</label><br>
                    <input autocomplete="off" tabindex="6" type="text" name="valorUntPr" id="valorUntPr"><br>
                </td>
                <td>
                    <label for="valorUntMs">Valor MS</label><br>
                    <input autocomplete="off" tabindex="7" type="text" name="valorUntMs" id="valorUntMs"><br>
                </td>
            </Tr>
        </div>

        <div id="telaValorQuantidade">
            <div class="valorQuant-conteiner">
                <div>
                    <h4>Quantidades</h4>
                </div>
                <div>
                    <label for="umQnt">Quantidade 1</label><br>
                    <input type="number" name="umQnt" id="umQnt" min="1" max="999">
                </div>
                <div>
                    <label for="doisQnt">Quantidade 2</label><br>
                    <input type="number" name="doisQnt" id="doisQnt" min="1" max="999">
                </div>
                <div>
                    <label for="tresQnt">Quantidade 3</label><br>
                    <input type="number" name="tresQnt" id="tresQnt" min="1" max="999">
                </div>
            </div>

            <div class="valorQuant-conteiner">
                <div>
                    <h4>PR</h4>
                </div>
                <div>
                    <label for="umVlrPrQnt">Valor 1:</label><br>
                    <input type="text" name="umVlrPrQnt" id="umVlrPrQnt">
                </div>
                <div>
                    <label for="doisVlrPrQnt">Valor 2:</label><br>
                    <input type="text" name="doisVlrPrQnt" id="doisVlrPrQnt">
                </div>
                <div>
                    <label for="tresVlrPrQnt">Valor 3:</label><br>
                    <input type="text" name="tresVlrPrQnt" id="tresVlrPrQnt">
                </div>
            </div>

            <div class="valorQuant-conteiner">
                <div>
                    <h4>MS</h4>
                </div>
                <div>
                    <label for="umVlrMsQnt">Valor 1:</label><br>
                    <input type="text" name="umVlrMsQnt" id="umVlrMsQnt">
                </div>
                <div>
                    <label for="doisVlrMsQnt">Valor 2:</label><br>
                    <input type="text" name="doisVlrMsQnt" id="doisVlrMsQnt">
                </div>
                <div>
                    <label for="tresVlrMsQnt">Valor 3:</label><br>
                    <input type="text" name="tresVlrMsQnt" id="tresVlrMsQnt">
                </div>
            </div>
        </div>

        <br>
    </form>
    <a href="../index.php"><button>Cancelar</button></a>
    <button id="butaoSalvar" onclick="editar();">Salvar</button>
</body>
<link rel="stylesheet" href="/assets/css/views/cadastros/produto/cadastrar.css">
<script src="/assets/js/views/cadastros/produto.js"></script>

<script>
    // Garante que tipoVenda seja iniciado para o cadastro.
    verificarTipoVenda();

    // Busca os dados do produto para edição.
    buscar();
</script>

</html>