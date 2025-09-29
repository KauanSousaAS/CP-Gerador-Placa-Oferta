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
            $listaProdutosFilial = document.getElementById("listaProdutosFilial");

            $listaProdutosFilial.innerHTML = "";

            // Chama o construtor de elementos HTML
            const construtor = new Construtor();

            data.forEach(function (produto) {
                // Cria uma nova linha na tabela para cada produto
                let linhaProduto = construtor.criar("tr", {}, [
                    construtor.criar("td", {}, [
                        construtor.criar("input", {
                            type: "checkbox",
                            class: "produtoSelecionado",
                            name: "produtoSelecionado",
                            value: produto.fk_produto
                        })
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/produto/editar?id_produto=${produto.fk_produto}`
                        }, [
                            produto.codigos.join(";")
                        ])
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/produto/editar?id_produto=${produto.fk_produto}`
                        }, [
                            produto.descricao
                        ])
                    ]),
                    construtor.criar("td", {}, [produto.manual == 1 ? "Sim" : "Não"]),
                    construtor.criar("td", {}, [produto.estoque_filial]),
                    construtor.criar("td", {}, [produto.situacao == 2 ? "Pendente" : (produto.situacao == 1 ? "Feito" : (produto.situacao == 0 ? "Desativado" : "Erro"))]),
                    construtor.criar("td", {}, [formatarDataHora(produto.ultimo_exibir)]),
                    construtor.criar("td", {}, [produto.status == 1 ? "Ativo" : "Inativo"]),
                    construtor.criar("td", {}, [
                        construtor.criar("button", {
                            type: "button",
                            onclick: () => console.log(produto.fk_produto, document.getElementById('seletorFilial').value)
                        }, ["Botão"])
                    ])
                ]);
                // Adiciona a linha à tabela
                $listaProdutosFilial.appendChild(linhaProduto);

            });
            document.getElementById("resultadoPesquisa").style.display = "none";
            document.getElementById("pesquisarProduto").value = "";
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
        })
        .then(data => {
            carregarProdutoFilial(document.getElementById('seletorFilial').value);
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

function exibir() {
    const novaJanela = window.open('exibir.php', '_blank');

    // Aguarda a nova aba carregar completamente
    novaJanela.onload = function () {
        novaJanela.postMessage({
            ids: capturarSelecionados(),
            filial: document.getElementById('seletorFilial').value
        }, '*');
    };
}

function excluir() {
    fetch('/index.php/filialProduto/excluir', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ids: capturarSelecionados(),
            filial: document.getElementById('seletorFilial').value
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
            return response.text();
        })
        .then(data => {
            carregarProdutoFilial(document.getElementById('seletorFilial').value);
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

function concluir() {
    fetch('/index.php/filialProduto/concluir', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ids: capturarSelecionados(),
            filial: document.getElementById('seletorFilial').value
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
            return response.text();
        })
        .then(data => {
            carregarProdutoFilial(document.getElementById('seletorFilial').value);
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });
}

// =================================================
//                   Utilitários
// =================================================

// Formata a data e hora no formato dd/mm/aa - hh:mm
function formatarDataHora(dataStr) {
    if (!dataStr) return "N/A";

    const data = new Date(dataStr.replace(" ", "T"));

    const dia = String(data.getDate()).padStart(2, "0");
    const mes = String(data.getMonth() + 1).padStart(2, "0");
    const ano = String(data.getFullYear()).slice(-2);

    const hora = String(data.getHours()).padStart(2, "0");
    const min = String(data.getMinutes()).padStart(2, "0");
    //   const seg   = String(data.getSeconds()).padStart(2, "0");

    return `${dia}/${mes}/${ano} - ${hora}:${min}`;
}

// Capturar produtos selecionados
function capturarSelecionados() {
    const checkboxes = document.querySelectorAll('.produtoSelecionado:checked');

    const ids = Array.from(checkboxes).map(cb => cb.value);

    return ids;
}

// será fracionado
function acoesExecutar(acao) {

    switch (acao) {
        case "exibir":
            const novaJanela = window.open('../pages/exibir.html', '_blank');

            // Aguarda a nova aba carregar completamente
            novaJanela.onload = function () {
                novaJanela.postMessage({
                    ids: ids
                }, '*');
            };
            break;
        case "concluir":
            const formDataConcluir = new FormData();
            formDataConcluir.append('funcao', 'concluirAssociacaoProdutoFilial');
            formDataConcluir.append('ids', JSON.stringify(ids));

            let xhrConcluir = new XMLHttpRequest();
            xhrConcluir.open("POST", '../../php/funcoes.php', true);
            xhrConcluir.onreadystatechange = function () {
                if (xhrConcluir.readyState == 4 && xhrConcluir.status == 200) {
                    loadData();
                    console.log(xhrConcluir.responseText);
                }
            }
            xhrConcluir.send(formDataConcluir);
            break;
        case "excluir":
            const formDataExcluir = new FormData();
            formDataExcluir.append('funcao', 'desvincularFilialProduto');
            formDataExcluir.append('ids', JSON.stringify(ids));

            let xhrExcluir = new XMLHttpRequest();
            xhrExcluir.open("POST", '../../php/funcoes.php', true);
            xhrExcluir.onreadystatechange = function () {
                if (xhrExcluir.readyState == 4 && xhrExcluir.status == 200) {
                    loadData();
                    console.log(xhrExcluir.responseText);
                }
            }
            xhrExcluir.send(formDataExcluir);
            break;
    }
}