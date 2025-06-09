<?php

function getConexao()
{
    $conexao = mysqli_connect("localhost", "root", "", "bd_pdo");

    return $conexao;
}
