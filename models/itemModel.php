<?php

require_once(__DIR__ . '/../config/conexao.php');

class ItemModel {
    public $codigo;
    public $fkProduto;

    public function __construct($codigo = null, $fkProduto = null) {
        $this->codigo = $codigo;
        $this->fkProduto = $fkProduto;
    }

    public function cadastrar() {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_item (codigo, fk_produto) VALUES (?, ?)");
        $stmt->bind_param(
            "ii",
            $this->codigo,
            $this->fkProduto
        );
        return $stmt->execute();
    }

    public static function buscarPorId($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM tb_item WHERE id_item = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function excluir($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM tb_item WHERE id_item = ?");
        return $stmt->execute([$id]);
    }
}