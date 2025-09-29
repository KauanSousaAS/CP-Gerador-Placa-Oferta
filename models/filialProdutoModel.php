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

    public function buscar($id)
    {
        if ($id === null) {
            throw new Exception("ID da filial não fornecido.");
        }

        $sql = "SELECT * FROM tb_filial_produto WHERE fk_filial = ?";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bind_param("i", $id);

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

        $lista = [];
        while ($row = $resultado->fetch_assoc()) {
            $lista[] = $row;
        }

        return empty($lista) ? null : $lista;
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

    public function vincular($id_produto, $id_filial)
    {
        $sql = "INSERT INTO tb_filial_produto (fk_produto, fk_filial, ultimo_exibir, estoque_filial, status) VALUES (?, ?, now(), 0, 2);";

        $stmt = $this->conexao->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        $stmt->bind_param("ii", $id_produto, $id_filial);

        if (!$stmt) {
            throw new Exception("Erro ao inserir os dados da consulta: " . $this->conexao->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erro ao vincular produto à filial: " + $stmt->error);
        }
    }

    public function excluir($produto, $filial)
    {
        $sql = "DELETE FROM tb_filial_produto WHERE fk_produto = ? AND fk_filial = ?;";

        $stmt = $this->conexao->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        $stmt->bind_param("ii", $produto, $filial);

        if (!$stmt) {
            throw new Exception("Erro ao inserir os dados da consulta: " . $this->conexao->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erro ao excluir produto da filial: " + $stmt->error);
        }
    }

    public function concluir($produto, $filial) {
        $sql = "UPDATE tb_filial_produto SET status = 1 WHERE fk_produto = ? AND fk_filial = ?;";

        $stmt = $this->conexao->prepare($sql);

        if(!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . $this->conexao->error);
        }

        $stmt->bind_param("ii", $produto, $filial);

        if (!$stmt){
            throw new Exception("Erro ao inserir os dados da consulta: " . $this->conexao->error);
        }

        if(!$stmt->execute()){
            throw new Exception("Erro ao alterar o status do produto pela filial: " . $this->conexao->error);
        }
    }
}
