<?php

require_once(__DIR__ . '/../config/conexao.php');

class PrecoModel {
    public $idPreco;
    public $venda;
    public $preco;
    public $quantidade;
    public $uf;
    public $fkProduto;

    public function __construct($idPreco = null, $venda = null, $preco = null, $quantidade = null, $uf = null, $fkProduto = null) {
        $this->idPreco = $idPreco;
        $this->venda = $venda;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->uf = $uf;
        $this->fkProduto = $fkProduto;
    }
    

    public function cadastrar() {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_preco (venda, preco, quantidade, uf, fk_produto) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->venda, $this->preco, $this->quantidade, $this->uf, $this->fkProduto]);
    }

    public static function buscarPorId($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM tb_preco WHERE id_preco = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function deletar($id) {
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM tb_preco WHERE id_preco = ?");
        return $stmt->execute([$id]);
    }
}
