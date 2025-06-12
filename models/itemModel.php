<?php

class ItemModel {
    public $idItem;
    public $codigo;
    public $fkProduto;

    public function __construct($idItem = null, $codigo = null, $fkProduto = null) {
        $this->idItem = $idItem;
        $this->codigo = $codigo;
        $this->fkProduto = $fkProduto;
    }

    public function salvar() {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_item (codigo, fk_produto) VALUES (?, ?)");
        return $stmt->execute([$this->codigo, $this->fkProduto]);
    }

    public function atualizar() {
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE tb_item SET codigo=?, fk_produto=? WHERE id_item=?");
        return $stmt->execute([$this->codigo, $this->fkProduto, $this->idItem]);
    }

    public static function buscarPorId($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM tb_item WHERE id_item = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function deletar($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM tb_item WHERE id_item = ?");
        return $stmt->execute([$id]);
    }
}