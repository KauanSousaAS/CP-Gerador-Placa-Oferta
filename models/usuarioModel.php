<?php

class UsuarioModel
{
    public $idUsuario;
    public $nome;
    public $login;
    public $senha;
    public $token;
    public $status;

    public function __construct($idUsuario = null, $nome = null, $login = null, $senha = null, $token = null, $status = null)
    {
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
        $this->login = $login;
        $this->senha = $senha;
        $this->token = $token;
        $this->status = $status;
    }

    public function cadastrar()
    {
        $conn = getConexao();
        $stmt = $conn->prepare("INSERT INTO tb_usuario(nome, login, senha, token, status) VALUES (?,?,?,?,?)");
        $stmt->bind_param(
            "ssssi",
            $this->nome,
            $this->login,
            $this->senha,
            $this->token,
            $this->status
        );
        return $stmt->execute();
    }

    public static function login($loginInput, $senhaInput)
    {
        require_once('config/conexao.php');

        $conn = getConexao();
        $stmt = $conn->prepare("SELECT id_usuario, senha FROM tb_usuario WHERE login = ?");
        $stmt->bind_param(
            "s",
            $loginInput
        );
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $row = $resultado->fetch_assoc();
            $senhaHash = $row['senha'];

            // Verificar a senha
            if (password_verify($senhaInput, $senhaHash)) {
                $id = $row['id_usuario'];
                $token = bin2hex(random_bytes(16));

                $conn = getConexao();
                $stmt = $conn->prepare("UPDATE tb_usuario SET token = ? WHERE id_usuario = ?");
                $stmt->bind_param(
                    "si",
                    $token,
                    $id
                );
                $stmt->execute();

                // Inicia a sessão caso ainda não tenha sido feito.
                if (!isset($_SESSION)) {
                    session_start();
                }

                // Adiciona o id e o novo token a sessão do cliente.
                $_SESSION['idUsuario'] = $id;
                $_SESSION['token'] = $token;

                // Retorna 2 caso o login tenha sido realizado com sucesso.
                return 2;
            } else {
                // Retorna 1 caso a senha do Usuário informada esteja incorreta.
                return 1;
            }
        } else {
            // Retorna 0 caso o Usuário informado não tenha sido encontrado.
            return 0;
        }
    }

    public static function validarSessao()
    {
        require_once('../config/conexao.php');

        // Inicia a sessão caso ainda não tenha sido feito.
        if (!isset($_SESSION)) {
            session_start();
        }

        // Verifica se há um usuário e um token registrados na sessão.
        if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['token'])) {
            // Retorna nulo caso não exista dados nas sessões de id e token do usuário.
            return null;
        }

        // Realiza a busca do usuário da sessão e recebe o id do usuário caso encontrado.
        $conn = getConexao();
        $stmt = $conn->prepare("SELECT id_usuario FROM tb_usuario WHERE id_usuario = ? AND token = ?");
        $id = $_SESSION['idUsuario'];
        $token = $_SESSION['token'];
        $stmt->bind_param(
            "is",
            $id,
            $token
        );
        $stmt->execute();
        $usuario = $stmt->fetch();

        // Retorna nulo caso o usuário não tenha sido encontrado
        if (!$usuario) {
            return null;
        }

        // Retorna 1 caso o usuário tenha sido reconhecido.
        return 1;
    }
}
