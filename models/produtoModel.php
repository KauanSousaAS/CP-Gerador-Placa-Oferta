<?php

require_once(__DIR__ . '/../config/conexao.php');

class ProdutoModel
{

    public $idProduto;
    public $descricao;
    public $manual;
    public $volume;
    public $status;

    public function __construct($idProduto = null, $descricao = null, $manual = null, $volume = null, $status = null)
    {
        $this->idProduto = $idProduto;
        $this->descricao = $descricao;
        $this->manual = $manual;
        $this->volume = $volume;
        $this->status = $status;
    }

    public function listar()
    {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT id_produto, descricao, status FROM tb_produto");

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $conn->error);
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
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_produto(descricao, manual, volume, status) VALUES (?,?,?,?)");
        $stmt->bind_param(
            "sisi",
            $this->descricao,
            $this->manual,
            $this->volume,
            $this->status
        );
        if ($stmt->execute()) {
            $this->idProduto = $conn->insert_id;
        }
    }

    public function atualizar()
    {
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE tb_produto SET id_produto=?, descricao =?, manual=? ,volume=? ,status=? WHERE 1");
        return $stmt->execute([$this->idProduto, $this->descricao, $this->manual, $this->volume, $this->status]);
    }

    public function buscarPorId($id)
    {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM tb_produto WHERE id_produto = ?");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletar($id)
    {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM tb_produto WHERE id_produto = ?");
        return $stmt->execute([$id]);
    }
}
