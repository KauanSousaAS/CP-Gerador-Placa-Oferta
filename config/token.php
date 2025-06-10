<?php
class Token
{
    // Usado para verificar se o usuário está logado em uma conta 
    function validarSessao()
    {
        // Inicia a sessão caso ainda não tenha sido feito
        if (!isset($_SESSION)) {
            session_start();
        }

        // Recebe a conexão com o banco de dados
        require_once 'conexao.php';

        // Trava a execução do código caso não exista nenhuma sessão de login iniciada
        if (!isset($_SESSION['usuario_id'], $_SESSION['token'])) {
            die("Acesso negado. Faça login.");
        }

        // Verifica se há o usuário da sessão e se o token dele é igual ao token da sessão
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ? AND token = ?");
        $stmt->execute([$_SESSION['usuario_id'], $_SESSION['token']]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            die("Sessão inválida. Faça login novamente.");
        }

        // Usuário autenticado com sucesso!!
        echo "console.log(\"Usuário autenticado com sucesso!\"";
    }

    function verificarSessao() {}

    function gerarToken($tamanho = 32)
    {
        return bin2hex(random_bytes($tamanho));
    }

    function iniciarSessao($login, $senha) {}
}
