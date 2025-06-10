<?php

class FilialProduto {
    public $fkProduto;
    public $fkFilial;
    public $ultimoExibir;
    public $estoqueFilial;
    public $status;

    public function __construct($fkProduto = null, $fkFilial = null, $ultimoExibir = null, $estoqueFilial = null, $status = null) {
        $this->fkProduto = $fkProduto;
        $this->fkFilial = $fkFilial;
        $this->ultimoExibir = $ultimoExibir;
        $this->estoqueFilial = $estoqueFilial;
        $this->status = $status;
    }

    public function associar() {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_filial_produto(fk_produto, fk_filial, ultimo_exibir, estoque_filial, status) VALUES (?,?,?,?,?");
        return $stmt->execute([$this->fkProduto, $this->fkFilial, $this->ultimoExibir, $this->estoqueFilial, $this->status]);
    }

    public function listaExibida($produto, $filial){
        $conn = getConexao();
        $stmt = $conn->prepare("UPDATE tb_filial_produto SET ultimo_exibir=? ,status=? WHERE fk_produto = ? AND fk_filial");
        $ultimoEbixir = date('Y-m-d H:i:s');
        return $stmt->execute([$this->fkProduto, $this->fkFilial, $this->ultimoExibir, $this->estoqueFilial, $this->status]);
    }

    public function buscarPorId($id){
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM tb_produto WHERE id_produto = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function deletar($id){
        $conn = getConexao();
        $stmt = $conn->prepare("DELETE FROM tb_filial_produto WHERE id_produto = ?");
        return $stmt->execute([$id]);
    }
}
