<?php

require_once(__DIR__ . '/../config/conexao.php');

class ProdutoModel
{

    public $idProduto;
    public $descricao;
    public $manual;
    public $volume;
    public $status;
    private $conexao;

    public function __construct($idProduto = null, $descricao = null, $manual = null, $volume = null, $status = null)
    {
        $this->idProduto = $idProduto;
        $this->descricao = $descricao;
        $this->manual = $manual;
        $this->volume = $volume;
        $this->status = $status;
        $this->conexao = getConexao();
    }

    public function listarProdutos()
    {
        $stmt = $this->conexao->prepare("SELECT id_produto, descricao, status FROM tb_produto");

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        $produtos = [];
        while ($row = $resultado->fetch_assoc()) {
            $produtos[] = $row;
        }

        return $produtos;
    }

    public function cadastrar()
    {
        $stmt = $this->conexao->prepare("INSERT INTO tb_produto(descricao, manual, volume, status) VALUES (?,?,?,?)");
        $stmt->bind_param(
            "sisi",
            $this->descricao,
            $this->manual,
            $this->volume,
            $this->status
        );
        if ($stmt->execute()) {
            $this->idProduto = $this->conexao->insert_id;
        }
    }
}
