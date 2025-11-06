<?php

class precoController
{
    public function atualizacao()
    {
        $dados_json = json_decode(file_get_contents('php://input'), true);

        $dados = json_decode($dados_json['dados'], true);
        $uf = $dados_json['uf'];

        usort($dados, function ($a, $b) {
            if ($a['codigo'] != $b['codigo']) {
                return $a['codigo'] - $b['codigo']; // Ordena primeiro por código
            }
            return $a['quantidade'] - $b['quantidade']; // Depois por quantidade
        });

        // Agrupamento de produtos por códigos
        $dadosUpdate = [];
        for ($i = 0; $i < count($dados); $i++) {
            $x = [];
            while (true) {
                if (isset($dados[$i + 1]) && $dados[$i]['codigo'] == $dados[$i + 1]['codigo']) {
                    $x[] = $dados[$i];
                    $i++;
                } else {
                    $x[] = $dados[$i];
                    break;
                }
            }
            $dadosUpdate[] = $x;
        }

        require_once(__DIR__ . '/../models/itemModel.php');
        require_once(__DIR__ . '/../models/produtoModel.php');
        require_once(__DIR__ . '/../models/precoModel.php');

        // echo json_encode($dadosUpdate);

        // Atualização dos preços no banco de dados
        foreach ($dadosUpdate as $produto) {

            // Verifica se há diferença de preço
            $temDiferenca = false;
            foreach ($produto as $prod){
                if ($prod['porcentagem'] != 0.00){
                    $temDiferenca = true;
                    break;
                }
            }
            
            // Se não houver diferença, pula para o próximo produto
            if(!$temDiferenca){
                echo "Nenhuma diferença de preço encontrada para o código " . $produto[0]['codigo'] . ". Pulando atualização.\n";
                continue;
            }

            // Buscar IDs dos produtos associados ao código
            $itemModel = new itemModel();
            $idsProdutos = $itemModel->pesquisarCodigo($produto[0]['codigo']);
            
            // Para cada ID de produto, atualizar os preços
            foreach ($idsProdutos as $id) {
                $produtoModel = new produtoModel();
                $p = $produtoModel->buscar($id['fk_produto']);

                // confere se o preço não é manual
                if ($p && $p[0]['manual'] == 0) {


                    // Apaga os preços antigos referentes ao ID do produto e UF selecionada
                    $precoModel = new precoModel();
                    $precoModel->excluir($id['fk_produto'], $uf);

                    if ($p[0]['venda'] == "UN" && count($produto) == 1) {
                        foreach ($produto as $pItem) {
                            $precoModel = new precoModel($pItem['preco'], $pItem['quantidade'], $uf, $id['fk_produto']);
                            $precoModel->cadastrar();
                        }
                        continue;
                    }
                    
                    if ($p[0]['venda'] == "QN" && count($produto) >= 1 && count($produto) <= 3) {
                        foreach ($produto as $pItem) {
                            $precoModel = new precoModel($pItem['preco'], $pItem['quantidade'], $uf, $id['fk_produto']);
                            $precoModel->cadastrar();
                        }
                        continue;
                    }

                    // Atribui os novos preços

                    // $precoModel->preco = $p['preco'];
                    // $precoModel->quantidade = $p['quantidade'];
                    // $precoModel->uf = $uf;
                    // $precoModel->fkProduto = $id['fk_produto'];

                    // Cadastra os novos preços no banco de dados

                    // $precoModel = new precoModel($p['preco'], $p['quantidade'], $uf, $id['fk_produto']);
                    // $precoModel->cadastrar();
                }
            }
        }
    }
}
