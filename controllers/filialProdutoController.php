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

        $filialProdutos = $filialProdutoModel->buscar(intval($dados['id_filial']));

        $resultado = [];

        if (!($filialProdutos === null)) {
            $filialProdutos[0]['situacao'] = $filialProdutos[0]['status'];

            unset($filialProdutos[0]['status']);


            foreach ($filialProdutos as &$produto) {
                $p = $produtoModel->buscar($produto['fk_produto']);

                $p = $p[0];

                $c = $itemModel->buscar($produto['fk_produto']);

                $p['codigos'] = array_column($c, 'codigo');

                unset($p['id_produto']);

                $produto = array_merge($produto, $p);

                $resultado[] = $produto;
            }
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
    }

    public function vincular()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        require_once(__DIR__ . '/../models/filialProdutoModel.php');

        $filialProdutoModel = new filialProdutoModel();

        $resultado = $filialProdutoModel->vincular($dados['id_produto'], $dados['id_filial']);

        echo json_encode($resultado);
    }

    public function excluir()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        // require_once(__DIR__ . '/../models/filialProdutoModel.php');

        // $filialProdutoModel = new filialProdutoModel();

        // $resultado;

        // foreach ($dados['ids'] as $id) {
        //     $resultado = $filialProdutoModel->excluir($id, $dados['filial']);
        // }

        echo json_encode($dados);
    }
}
