<?php

require_once(__DIR__ . '/../config/conexao.php');

class ItemModel
{
    public $codigo;
    public $fkProduto;
    private $conexao;

    public function __construct($codigo = null, $fkProduto = null)
    {
        $this->codigo = $codigo;
        $this->fkProduto = $fkProduto;
        $this->conexao = getConexao();
    }

    // Cadastrar um novo código a um produto
    public function cadastrar()
    {
        $stmt = $this->conexao->prepare("INSERT INTO tb_item (codigo, fk_produto) VALUES (?, ?)");
        $stmt->bind_param(
            "ii",
            $this->codigo,
            $this->fkProduto
        );
        return $stmt->execute();
    }

    // Busca os códigos do produto pelo ID
    public function buscar($id)
    {
        $sql = "SELECT * FROM tb_item";

        if ($id !== null) {
            $sql .= " WHERE fk_produto = ?";
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

        $codigos = [];
        while ($row = $resultado->fetch_assoc()) {
            $codigos[] = $row;
        }

        return $codigos;
    }

    public function excluir($id)
    {
        // Excluir códigos pelo ID do produto
    }
}
