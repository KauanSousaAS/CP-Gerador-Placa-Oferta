<?php

class filialProdutoController
{
    public function listar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        $filialProdutos = $filialProdutoModel->listar($dados['id_filial']);

        echo json_encode($filialProdutos);
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
}
