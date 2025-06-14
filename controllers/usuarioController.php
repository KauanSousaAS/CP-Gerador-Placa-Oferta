<?php

class usuarioController
{
    // Função usada para validar se o usuário está logado em uma conta.
    public function iniciarSessao()
    {

        // Recebe o corpo da requisição HTTP, converte para array e recebe os dados de login
        $contentsInput = json_decode(file_get_contents('php://input'), true);
        $login = $contentsInput['login'] ?? null;
        $senha = $contentsInput['senha'] ?? null;

        // Verifica se login e senha foram fornecidos, interrompe a execução caso não tenham sido fornecidos.
        if (empty($login) || empty($senha)) {
            http_response_code(400); // <-- Define o código de erro HTTP
            echo json_encode(["erroLogin" => "Login e/ou senha não fornecidos."]);
            exit;
        }

        // Recebe o model de Usuário.
        require_once(__DIR__ . '/../models/usuarioModel.php');

        $controller = new UsuarioModel();

        $controller->login = $login;
        $controller->senha = $senha;
        
        // Inicia a função de login do model de Usuário.
        $resultado = $controller->login();

        switch ($resultado) {
            case 2:
                echo json_encode(["redirect" => "index.php"]);
                break;
            case 1:
                http_response_code(400); // Define o resultado da requisição como erro do cliente.
                echo json_encode(["erroLogin" => "Senha incorreta!"]);
                break;
            case 0:
                http_response_code(400); // Define o resultado da requisição como erro do cliente.
                echo json_encode(["erroLogin" => "Usuário não encontrado!"]);
                break;
            default:
                http_response_code(400); // Define o resultado da requisição como erro do cliente.
                echo json_encode(["erroLogin" => "Erro desconhecido!"]);
                break;
        }
    }

    // Função usada para validar se o usuário está logado em uma conta.
    public function validarSessao()
    {
        // Inicia a sessão caso ainda não tenha sido feito.
        if (!isset($_SESSION)) {
            session_start();
        }
        
        // Verifica se há um usuário e um token registrados na sessão.
        if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['token'])) {
            // Retorna nulo caso não exista dados nas sessões de id e token do usuário.
            return null;
        }
        
        // Recebe o model de Usuário.
        require_once(__DIR__ . '/../models/usuarioModel.php');

        $controller = new UsuarioModel();

        $controller->idUsuario = $_SESSION['idUsuario'];
        $controller->token = $_SESSION['token'];

        // Inicia a função de verificação de login/sessão do Usuário.
        if (!$controller->validarSessao()) {
            header("Location: /views/login.php");
            exit();
        }
    }
}
