<?php

class produtoController
{
    public function cadastrar()
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!isset($dados['codigo']) || $dados['codigo'] == "") {
            http_response_code(400); // <-- Define o código de erro HTTP
            echo json_encode(["erro" => "Insira o código do produto!"]);
            die();
        }

        if (!preg_match('/^[0-9;]+$/', $dados['codigo'])) {
            http_response_code(400); // <-- Define o código de erro HTTP
            echo json_encode(["erro" => "Insira somente números e separação por ( ; ) no campo 'Código'"]);
            die();
        }

        if (!isset($dados['descricao']) || $dados['descricao'] == "") {
            http_response_code(400); // <-- Define o código de erro HTTP
            echo json_encode(["erro" => "Insira a descrição do produto!"]);
            die();
        }

        switch ($dados['venda']) {
            case "UN":
                $precosRecebidos = $dados['valorUnt'];

                $precos[] = $this->prepararPrecoParaCadastro(
                    $dados['venda'],
                    $this->converterValorStringDouble($this->validarPreco($precosRecebidos['precoPr'])),
                    1,
                    "PR"
                );

                $precos[] = $this->prepararPrecoParaCadastro(
                    $dados['venda'],
                    $this->converterValorStringDouble($this->validarPreco($precosRecebidos['precoMs'])),
                    1,
                    "MS"
                );
                break;
            case "QN":
                $precosRecebidos = $dados['valorQnt'];

                foreach ($precosRecebidos as $preco) {

                    $precos[] = $this->prepararPrecoParaCadastro(
                        $dados['venda'],
                        $this->converterValorStringDouble($this->validarPreco($preco['precoPr'])),
                        intval($preco['quantidade']),
                        "PR"
                    );

                    $precos[] = $this->prepararPrecoParaCadastro(
                        $dados['venda'],
                        $this->converterValorStringDouble($this->validarPreco($preco['precoMs'])),
                        intval($preco['quantidade']),
                        "MS"
                    );
                }
                break;
        }




        $status = $dados['status'] ? 1 : 0;

        $manual = $dados['manual'] ? 1 : 0;

        $codigo = explode(";", $dados['codigo']);

        $descricao = $dados['descricao'];

        $volume = $dados['volume'];

        require_once(__DIR__ . '/../models/produtoModel.php');

        $produtoModel = new produtoModel();

        $produtoModel->status = $status;
        $produtoModel->manual = $manual;
        $produtoModel->descricao = $descricao;
        $produtoModel->volume = $volume;

        $produtoModel->cadastrar();

        require_once(__DIR__ . '/../models/itemModel.php');

        foreach ($codigo as $cod) {
            $itemModel = new itemModel();

            $itemModel->codigo = intval($cod);
            $itemModel->fkProduto = $produtoModel->idProduto;

            $itemModel->cadastrar();
        }

        require_once(__DIR__ . '/../models/precoModel.php');

        foreach ($precos as $preco) {
            $precoModel = new precoModel();

            $precoModel->venda = $preco['venda'];
            $precoModel->preco = $preco['preco'];
            $precoModel->quantidade = $preco['quantidade'];
            $precoModel->uf = $preco['uf'];
            $precoModel->fkProduto = $produtoModel->idProduto;

            $precoModel->cadastrar();
        }

        // codigo
        {
            // foreach (){

            // }

            // var_dump($status, $manual, $codigo, $descricao, $volume, $venda, $precos);

            // $sql = "INSERT INTO `tb_produto` (
            //         `status`,
            //         `cod_produto`,
            //         `desc_produto`,
            //         `tipo_produto`
            //         )VALUES(
            //         ?,
            //         ?,
            //         ?,
            //         ?
            //         );";

            // $statement = $conexao->prepare($sql);

            // if (!$statement) {
            //     throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            // }

            // $statement->bind_param("issi", $statusProduto, $codigoProduto, $descricaoProduto, $tipoProduto);

            // if (!$statement->execute()) {
            //     throw new Exception("Erro na execução da consulta: " . $conexao->error);
            // }

            // // Captura o id do produto adicionado
            // $idProduto = $conexao->insert_id;

            // // Adiciona o valor do produto caso seja vendido unitário
            // if ($_POST['tipoVenda'] == 1) {
            //     if (isset($_POST['valorUnitarioPr'])) {
            //         $valor = str_replace(",", ".", $_POST['valorUnitarioPr']);

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '1',
            //                 ?,
            //                 '1',
            //                 'PR',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("di", $valor, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            //     if (isset($_POST['valorUnitarioMs'])) {
            //         $valor = $_POST['valorUnitarioMs'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '1',
            //                 ?,
            //                 '1',
            //                 'MS',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("di", $valor, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            // }

            // // Adiciona o valor do produto caso seja vendido em quantidade
            // if ($_POST['tipoVenda'] == 2) {
            //     if (isset($_POST['valorProduto1pr'])) {
            //         $valor = str_replace(",", ".", $_POST['valorProduto1pr']);
            //         $quantidade = $_POST['quantidadeProduto1'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '2',
            //                 ?,
            //                 ?,
            //                 'PR',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            //     if (isset($_POST['valorProduto1ms'])) {
            //         $valor = str_replace(",", ".", $_POST['valorProduto1ms']);
            //         $quantidade = $_POST['quantidadeProduto1'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '2',
            //                 ?,
            //                 ?,
            //                 'MS',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            //     if (isset($_POST['valorProduto2pr'])) {
            //         $valor = str_replace(",", ".", $_POST['valorProduto2pr']);
            //         $quantidade = $_POST['quantidadeProduto2'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '2',
            //                 ?,
            //                 ?,
            //                 'PR',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            //     if (isset($_POST['valorProduto2ms'])) {
            //         $valor = str_replace(",", ".", $_POST['valorProduto2ms']);
            //         $quantidade = $_POST['quantidadeProduto2'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '2',
            //                 ?,
            //                 ?,
            //                 'MS',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            //     if (isset($_POST['valorProduto3pr'])) {
            //         $valor = str_replace(",", ".", $_POST['valorProduto3pr']);
            //         $quantidade = $_POST['quantidadeProduto3'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '2',
            //                 ?,
            //                 ?,
            //                 'PR',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            //     if (isset($_POST['valorProduto3ms'])) {
            //         $valor = str_replace(",", ".", $_POST['valorProduto3ms']);
            //         $quantidade = $_POST['quantidadeProduto3'];

            //         $sql = "INSERT INTO `tb_preco`(
            //                 `tipo_venda`,
            //                 `valor`,
            //                 `quantidade`,
            //                 `uf`,
            //                 `fk_produto`
            //                 )VALUES(
            //                 '2',
            //                 ?,
            //                 ?,
            //                 'MS',
            //                 ?
            //                 );";

            //         $statement = $conexao->prepare($sql);

            //         if (!$statement) {
            //             throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            //         }

            //         $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            //         if (!$statement->execute()) {
            //             throw new Exception("Erro na execução da consulta: " . $conexao->error);
            //         }
            //     }
            // }

            // header("Location: ../pages/cadastrar.html");
        }
    }

    private function validarPreco($precoValidar)
    {
        if (empty($precoValidar)) {
            http_response_code(400); // <-- Define o código de erro HTTP
            echo json_encode(["erro" => "Preencha todos os campos de preço do produto!"]);
            die();
        }

        if (!preg_match('/^\d{1,9}([.,]\d{1,9})?$/', $precoValidar)) {
            http_response_code(400); // <-- Define o código de erro HTTP
            echo json_encode(["erro" => "Insira valores válidos de preço! (xxxxxx,xx ou xxxxxx.xx)!"]);
            die();
        }

        return $precoValidar;
    }

    private function prepararPrecoParaCadastro($venda, $preco, $quantidade, $uf)
    {
        return [
            'venda' => $venda,
            'preco' => $preco,
            'quantidade' => $quantidade,
            'uf' => $uf
        ];
    }

    private function converterValorStringDouble($valor)
    {
        $valor = str_replace(',', '.', $valor);

        $valor = floatval($valor);

        return $valor;
    }
}
