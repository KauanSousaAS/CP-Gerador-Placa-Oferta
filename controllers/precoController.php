<?php

class precoController
{
    public function atualizacao()
    {
        $dados_json = json_decode(file_get_contents('php://input'), true);

        $dados = json_decode($dados_json['dados'], true);
        $uf = $dados_json['uf'];
        
        
        var_dump($dados);
        usort($dados, function ($a, $b) {
            if ($a['codigo'] != $b['codigo']) {
                return $a['codigo'] - $b['codigo']; // Ordena primeiro por código
            }
            return $a['quantidade'] - $b['quantidade']; // Depois por quantidade
        });
        
        var_dump($dados);
        
        // require_once(__DIR__ . '/../models/itemModel.php');

        // $itemModel = new itemModel();
        
        // require_once(__DIR__ . '/../models/precoModel.php');

        // $precoModel = new precoModel();

        // $precoModel->alterar($produto, $preco, $quantidade, $uf);

        // echo json_encode($filialProdutos);
    }
}
