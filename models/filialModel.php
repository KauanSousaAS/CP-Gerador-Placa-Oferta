<?php

require_once(__DIR__ . '/../config/conexao.php');

class filialModel {
    
    public $idFilial;
    public $filial;
    public $uf;
    public $status;
    private $conexao;   

    public function __construct($idFilial = null, $filial = null, $uf = null, $status = null) {
        $this->idFilial = $idFilial;
        $this->filial = $filial;
        $this->uf = $uf;
        $this->status = $status;
        $this->conexao = getConexao();
    }

    public function listar() {
        $stmt = $this->conexao->prepare("SELECT id_filial, filial, uf, status FROM tb_filial");

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        $filiais = [];
        while ($row = $resultado->fetch_assoc()) {
            $filiais[] = $row;
        }

        return $filiais;
    }
}