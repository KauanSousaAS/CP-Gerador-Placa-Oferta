<?php

class filialProdutoController
{
    public function listar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');
        require_once(__DIR__ . '/../models/produtoModel.php');
        require_once(__DIR__ . '/../models/itemModel.php');

        $filialProdutoModel = new filialProdutoModel();
        $produtoModel = new produtoModel();
        $itemModel = new itemModel();

        $filialProdutos = $filialProdutoModel->listar($dados['id_filial']);

        $resultado = [];

        foreach ($filialProdutos as &$produto) {
            $informacoes = $produtoModel->buscar($produto['fk_produto']);
            $codigos = $itemModel->buscarPorId($produto['fk_produto']);

            $produto['descricao'] = $informacoes[0]['descricao'] ?? null;
            $produto['manual'] = $informacoes[0]['manual'] ?? null;
            $produto['status_produto'] = $informacoes[0]['status'] ?? null;
            $produto['codigos'] = $codigos ?? null;

            $resultado[] = $produto;
        }

        echo json_encode($resultado);
    }

    public function pesquisar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        $filialProdutos = $filialProdutoModel->pesquisarProdutoFilial($dados['id_filial'], $dados['pesquisa']);

        echo json_encode($filialProdutos);
        // echo json_encode($dados);
    }

    public function vincular()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        $resultado = $filialProdutoModel->vincular($dados['id_produto'], $dados['id_filial']);

        echo json_encode($resultado);
    }
}
