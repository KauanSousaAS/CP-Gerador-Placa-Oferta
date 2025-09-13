// Encaminhar as informações de login para o loginController
function logar() {
    // Gera a requisição para encaminhamento das informações para o loginController.php
    fetch('/index.php/usuario/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            login: document.getElementById('login').value,
            senha: document.getElementById('senha').value
        })
    })
        .then(response => {
            if (!response.ok) {
                // Se status for 400, 404, 500 etc.
                return response.json().then(err => {
                    // Exibi o erro no console, caso houver.
                    if (err.erroLogin != null) {
                        alert(err.erroLogin);
                    } else {
                        throw new Error("Erro desconhecido");
                    }
                });

            }
            return response.json();
        })
        .then(data => {
            // Redireciona o usuário para a página inicial, caso o login seja bem sucedido.
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.erroLogin || data.erro) {
                alert(data.erroLogin || data.erro);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}