<?php

require_once(__DIR__ . '/../config/conexao.php');

class ItemModel
{
    public $codigo;
    public $fkProduto;

    public function __construct($codigo = null, $fkProduto = null)
    {
        $this->codigo = $codigo;
        $this->fkProduto = $fkProduto;
    }

    // Cadastrar um novo código a um produto
    public function cadastrar()
    {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_item (codigo, fk_produto) VALUES (?, ?)");
        $stmt->bind_param(
            "ii",
            $this->codigo,
            $this->fkProduto
        );
        return $stmt->execute();
    }

    // Busca os códigos do produto pelo ID
    public static function buscarPorId($id)
    {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT codigo FROM tb_item WHERE fk_produto = ?");

        $stmt->bind_param("i", $id);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $conn->error);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        $codigos = [];
        while ($row = $resultado->fetch_assoc()) {
            $codigos[] = $row['codigo'];
        }       
        
        return $codigos;
    }

    public static function excluir($id)
    {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM tb_item WHERE id_item = ?");
        return $stmt->execute([$id]);
    }
}
