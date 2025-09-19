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

    public function buscar($id) {

        $sql = "SELECT * FROM tb_filial";

        if ($id !== null) {
            $sql .= " WHERE id_filial = ?";
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