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

        // Redireciona para a página de produtos após o cadastro
        http_response_code(201); // <-- Define o código de sucesso HTTP
        echo json_encode([
            'redirect' => './',
        ]);
    }

    public function listar()
    {
        require_once(__DIR__ . '/../models/produtoModel.php');

        $produtoModel = new produtoModel();

        $produtos = $produtoModel->listar();

        echo json_encode($produtos);
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
