function carregarFiliais() {
    fetch('/index.php/filial/listar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        // body: JSON.stringify(dadosCadastro)
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
            // Chama o construtor de elementos HTML
            const construtor = new Construtor();

            // Chama o seletor de filial
            const seletor = document.getElementById('seletorFilial');

            // Adiciona as filiais no seletor
            data.forEach(filial => {
                let linhaFilial = construtor.criar("option", {
                    value: filial.id_filial
                }, [
                    "Filial: " + filial.filial + " - " + filial.uf
                ]);
                seletor.appendChild(linhaFilial);
            });

        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

function pesquisarProdutoFilial() {

    fetch('/index.php/filialProduto/pesquisar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_filial: document.getElementById('seletorFilial').value,
            pesquisa: document.getElementById('pesquisarProduto').value,
        })
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

            let pesquisarProduto = document.getElementById("pesquisarProduto").value;

            let resultadoPesquisa = document.getElementById("resultadoPesquisa");

            resultadoPesquisa.innerHTML = "";

            if (pesquisarProduto === "") {
                resultadoPesquisa.style.display = "none";

                return;
            }

            // Chama o construtor de elementos HTML
            const construtor = new Construtor();

            // Agrupa os produtos pelo id_produto, concatenando os códigos
            const agrupado = Object.values(
                data.reduce((acc, item) => {
                    if (!acc[item.id_produto]) {
                        acc[item.id_produto] = {
                            id_produto: item.id_produto,
                            codigos: item.codigo.toString(),
                            descricao: item.descricao
                        };
                    } else {
                        acc[item.id_produto].codigos += "; " + item.codigo;
                    }

                    return acc;
                }, {})
            );

            // Exibe os produtos na tabela
            agrupado.forEach(function (produto) {

                let linhaProduto = construtor.criar("div", {}, [produto.codigos + " - " + produto.descricao + " ",
                construtor.criar("button", {
                    type: "button",
                    onclick: () => vincularProdutoFilial(produto.id_produto)
                }, ['+'])
                ]);

                resultadoPesquisa.appendChild(linhaProduto);

                resultadoPesquisa.style.display = "block";
            });
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}


function carregarProdutoFilial(id_filial) {

    fetch('/index.php/filialProduto/listar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_filial: id_filial })
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
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

function vincularProdutoFilial(id_produto) {
    fetch('/index.php/filialProduto/vincular', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_filial: document.getElementById('seletorFilial').value,
            id_produto: id_produto
        })
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
                }
                );
            }
            return response.text();
        }
        )
        .then(data => {
            pesquisarProdutoFilial();
        }
        )
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

