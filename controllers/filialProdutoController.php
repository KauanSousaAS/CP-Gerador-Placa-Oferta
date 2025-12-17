<?php

class filialProdutoController
{
    public function listar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();
        
        $produtos = $filialProdutoModel->buscarProdutosFilial(intval($dados['id_filial']));

        echo json_encode($produtos);
    }

    public function pesquisar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        $filialProdutos = $filialProdutoModel->pesquisarProdutoFilial($dados['id_filial'], $dados['pesquisa']);

        echo json_encode($filialProdutos);
    }

    public function vincular()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        $resultado = $filialProdutoModel->vincular($dados['id_produto'], $dados['id_filial']);

        echo json_encode($resultado);
    }

    public function retirar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        foreach ($dados['ids'] as $id) {
            $filialProdutoModel->excluir($id, $dados['filial']);
        }
    }

    public function concluir()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        foreach ($dados['ids'] as $id) {
            $filialProdutoModel->concluir($id, $dados['filial']);
        }
    }
}
