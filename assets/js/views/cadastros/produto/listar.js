function listarProdutos() {
    fetch('/index.php/produto/listar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => {
            if (!response.ok) {
                // Se status for 400, 404, 500 etc.
                return response.json().then(err => {
                    // Exibi o erro no console, caso houver.
                    if (err.erro != null) {
                        alert(err.erro);
                    } else {
                        throw new Error("Erro desconhecido");
                    }
                });
            }
            return response.json();
        })
        .then(data => {

            console.log(data);

            let produtos = '';
            data.forEach(function (produto) {
                if (produto.manual == 1) {
                    produto.manual = 'Sim';
                } else {
                    produto.manual = 'Não';
                }

                produtos += `<tr>
                    <td><input type="checkbox" value="${produto.id_produto}"></td>
                    <td>${produto.id_produto}</td>
                    <td>${produto.descricao}</td>
                    <td>${produto.volume}</td >
                    <td>${produto.manual}</td >
                <td><button class="btn btn-danger">Excluir</button></td>
                </tr > `;
            });
            document.getElementById('listaProdutos').innerHTML = produtos;

        })
        .catch(error => {
            // Retorna o erro no console.error.
            console.error('Erro na requisição:', error);
        });
}

listarProdutos();