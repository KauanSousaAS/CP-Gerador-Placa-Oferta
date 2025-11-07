<?php

require_once(__DIR__ . '/../config/conexao.php');

class ProdutoModel
{

    public $idProduto;
    public $descricao;
    public $venda;
    public $manual;
    public $volume;
    public $status;
    private $conexao;

    public function __construct($idProduto = null, $descricao = null, $venda = null, $manual = null, $volume = null, $status = null)
    {
        $this->idProduto = $idProduto;
        $this->descricao = $descricao;
        $this->venda = $venda;
        $this->manual = $manual;
        $this->volume = $volume;
        $this->status = $status;
        $this->conexao = getConexao();
    }
    
    public function cadastrar()
    {
        $stmt = $this->conexao->prepare("INSERT INTO tb_produto(descricao, venda, manual, volume, status) VALUES (?,?,?,?,?)");
        $stmt->bind_param(
            "ssisi",
            $this->descricao,
            $this->venda,
            $this->manual,
            $this->volume,
            $this->status
        );
        if ($stmt->execute()) {
            $this->idProduto = $this->conexao->insert_id;
        }
    }

    public function editar()
    {
        $stmt = $this->conexao->prepare("UPDATE tb_produto SET descricao = ?, venda = ?, manual = ?, volume = ?, status = ? WHERE id_produto = ?");
        $stmt->bind_param(
            "ssisii",
            $this->descricao,
            $this->venda,
            $this->manual,
            $this->volume,
            $this->status,
            $this->idProduto
        );
        $stmt->execute();
    }

    public function buscar($id)
    {
        $sql = "SELECT * FROM tb_produto";

        if ($id !== null) {
            $sql .= " WHERE id_produto = ?";
        }

        $stmt = $this->conexao->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        if ($id !== null) {
            $stmt->bind_param("i", $id);
        }

        $stmt->execute();

        $resultado = $stmt->get_result();

        $produtos = [];
        while ($row = $resultado->fetch_assoc()) {
            $produtos[] = $row;
        }

        return $produtos;
    }
}
