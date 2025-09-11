<?php

require_once(__DIR__ . '/../config/conexao.php');

class FilialProdutoModel
{
    public $fkProduto;
    public $fkFilial;
    public $ultimoExibir;
    public $estoqueFilial;
    public $status;
    private $conexao;

    public function __construct($fkProduto = null, $fkFilial = null, $ultimoExibir = null, $estoqueFilial = null, $status = null)
    {
        $this->fkProduto = $fkProduto;
        $this->fkFilial = $fkFilial;
        $this->ultimoExibir = $ultimoExibir;
        $this->estoqueFilial = $estoqueFilial;
        $this->status = $status;
        $this->conexao = getConexao();
    }

    public function listar($id_filial)
    {

        if ($id_filial === null) {
            throw new Exception("ID da filial não fornecido.");
        }

        $sql = "SELECT * FROM tb_filial_produto WHERE fk_filial = ?";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bind_param("i", $id_filial);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar consulta: " . $stmt->error);
        }

        $resultado = $stmt->get_result();

        if (!$resultado) {
            throw new Exception("Erro ao obter resultados: " . $stmt->error);
        }

        $produtosFilial = $resultado->fetch_all();

        return $produtosFilial;
    }


    public function pesquisarProdutoFilial($id_filial, $pesquisa)
    {
        $pesquisa = "%" . $pesquisa . "%";

        $sql = "SELECT p.id_produto, i.codigo, p.descricao
                FROM tb_item i
                INNER JOIN tb_produto p ON p.id_produto = i.fk_produto
                WHERE p.id_produto NOT IN(
                    SELECT pf.fk_produto 
                    FROM tb_filial_produto pf
                    WHERE pf.fk_filial = ?
                ) 
                AND (i.codigo LIKE ? OR p.descricao LIKE ?)
                AND p.status = 1
                ;";

        $stmt = $this->conexao->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        $stmt->bind_param("iss", $id_filial, $pesquisa, $pesquisa);

        if (!$stmt) {
            throw new Exception("Erro ao inserir os dados da consulta: " . $this->conexao->error);
        }

        $stmt->execute();

        $resultado = $stmt->get_result();

        $pesquisa = [];
        while ($row = $resultado->fetch_assoc()) {
            $pesquisa[] = $row;
        }

        return $pesquisa;
    }
}
