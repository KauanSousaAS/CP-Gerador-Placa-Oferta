<?php

require_once(__DIR__ . '/../config/conexao.php');

class PrecoModel {
    public $venda;
    public $preco;
    public $quantidade;
    public $uf;
    public $fkProduto;
    private $conexao;

    public function __construct($venda = null, $preco = null, $quantidade = null, $uf = null, $fkProduto = null) {
        $this->venda = $venda;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->uf = $uf;
        $this->fkProduto = $fkProduto;
        $this->conexao = getConexao();
    }
    
    public function cadastrar() {
        $stmt = $this->conexao->prepare("INSERT INTO tb_preco (venda, preco, quantidade, uf, fk_produto) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sdisi",
            $this->venda,
            $this->preco,
            $this->quantidade,
            $this->uf,
            $this->fkProduto
        );
        return $stmt->execute();
    }

    public function buscar($id, $uf) {
        $sql = "SELECT * FROM tb_preco WHERE fk_produto = ? AND uf = ?";

        // if ($uf) {
        //     $sql .= " AND uf = ?";
        // }

        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bind_param("is", $id, $uf);

        // if ($uf) {
        //     $stmt->bind_param("is", $id, $uf);
        // } else {
        //     $stmt->bind_param("i", $id);
        // }

        $stmt->execute();

        $resultado = $stmt->get_result();

        $precos = [];
        while ($row = $resultado->fetch_assoc()) {
            $precos[] = $row;
        }
        
        return $precos;
    }

    public function excluir($id) {
        // Excluir preços por ID do produto
    }
}
