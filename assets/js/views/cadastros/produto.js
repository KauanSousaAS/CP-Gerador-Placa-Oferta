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

            // Chama o construtor de elementos HTML
            const construtor = new Construtor();

            // Exibe os produtos na tabela
            let listaProduto = document.getElementById('listaProdutos');
            data.forEach(function (produto) {

                // Cria uma nova linha na tabela para cada produto
                let linhaProduto = construtor.criar("tr", {}, [
                    construtor.criar("td", {}, [
                        construtor.criar("input", {
                            type: "checkbox",
                            value: produto.id_produto
                        })
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/produto/editar?id_produto=${produto.id_produto}`
                        }, [
                            produto.codigos.join(";")
                        ])
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/produto/editar?id_produto=${produto.id_produto}`
                        }, [
                            produto.descricao
                        ])
                    ]),
                    construtor.criar("td", {}, ["visualizar"]),
                    construtor.criar("td", {}, [produto.manual == 1 ? "Sim" : "Não"]),
                    construtor.criar("td", {}, [
                        construtor.criar("button", {}, ["Excluir"])
                    ])
                ]);

                // Adiciona a linha à tabela
                listaProduto.appendChild(linhaProduto);
            });

        })
        .catch(error => {
            // Retorna o erro no console.error.
            console.error('Erro na requisição:', error);
        });
}

// Iniciar a requisição para cadastro de produto.
function cadastrar() {

    // Desativa o botão de Salvar para evitar multiplas inserções.
    document.getElementById('butaoCadastrar').disabled = true;

    // Captura as informações do produto e preparando o array para envio.
    const venda = document.getElementById('venda').value;

    const dadosCadastro = {
        status: document.getElementById('status').checked, // checkbox
        manual: document.getElementById('manual').checked, // checkbox
        codigo: document.getElementById('codigo').value,
        descricao: document.getElementById('descricao').value,
        volume: document.getElementById('volume').value,
        venda: venda
    };

    // Se for unitário, adiciona apenas valor unitário
    if (venda === "UN") {
        dadosCadastro.valorUnt = {
            precoPr: document.getElementById('valorUntPr').value,
            precoMs: document.getElementById('valorUntMs').value
        };
    }

    // Se for por quantidade, adiciona estrutura de quantidade
    if (venda === "QN") {
        dadosCadastro.valorQnt = [
            {
                quantidade: document.getElementById('umQnt').value,
                precoPr: document.getElementById('umVlrPrQnt').value,
                precoMs: document.getElementById('umVlrMsQnt').value
            },
            {
                quantidade: document.getElementById('doisQnt').value,
                precoPr: document.getElementById('doisVlrPrQnt').value,
                precoMs: document.getElementById('doisVlrMsQnt').value
            },
            {
                quantidade: document.getElementById('tresQnt').value,
                precoPr: document.getElementById('tresVlrPrQnt').value,
                precoMs: document.getElementById('tresVlrMsQnt').value
            }
        ];
    }

    fetch('/index.php/produto/cadastrar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dadosCadastro)
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
            // Redireciona para a página de listagem de produtos.
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.erroLogin || data.erro) {
                alert(data.erroLogin || data.erro);
            }
        })
        .catch(error => {
            // Ativa novamente o botão de Salvar após a resposta da requisição.
            document.getElementById('butaoCadastrar').disabled = false;

            // Retorna o erro no console.error.
            console.error('Erro na requisição:', error);
        });
}

// Iniciar a requisição para edição de produto.
function editar() {

    // Desativa o botão de Salvar para evitar multiplas inserções.
    document.getElementById('butaoSalvar').disabled = true;

    // Captura as informações do produto e preparando o array para envio.
    const venda = document.getElementById('venda').value;

    const dadosEditar = {
        id_produto: new URL(window.location.href).searchParams.get("id_produto"),
        status: document.getElementById('status').checked, // checkbox
        manual: document.getElementById('manual').checked, // checkbox
        codigo: document.getElementById('codigo').value,
        descricao: document.getElementById('descricao').value,
        volume: document.getElementById('volume').value,
        venda: venda
    };

    // Se for unitário, adiciona apenas valor unitário
    if (venda === "UN") {
        dadosEditar.valorUnt = {
            precoPr: document.getElementById('valorUntPr').value,
            precoMs: document.getElementById('valorUntMs').value
        };
    }

    // Se for por quantidade, adiciona estrutura de quantidade
    if (venda === "QN") {
        dadosEditar.valorQnt = [
            {
                quantidade: document.getElementById('umQnt').value,
                precoPr: document.getElementById('umVlrPrQnt').value,
                precoMs: document.getElementById('umVlrMsQnt').value
            },
            {
                quantidade: document.getElementById('doisQnt').value,
                precoPr: document.getElementById('doisVlrPrQnt').value,
                precoMs: document.getElementById('doisVlrMsQnt').value
            },
            {
                quantidade: document.getElementById('tresQnt').value,
                precoPr: document.getElementById('tresVlrPrQnt').value,
                precoMs: document.getElementById('tresVlrMsQnt').value
            }
        ];
    }


    fetch('/index.php/produto/editar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dadosEditar)
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
            // Redireciona para a página de listagem de produtos.
            if (data.redirect) {
                window.location.href = data.redirect;
            } else if (data.erroLogin || data.erro) {
                alert(data.erroLogin || data.erro);
            }
        })
        .catch(error => {
            // Ativa novamente o botão de Salvar após a resposta da requisição.
            document.getElementById('butaoSalvar').disabled = false;

            // Retorna o erro no console.error.
            console.error('Erro na requisição:', error);
        });
}

function buscar() {
    var idProduto = new URL(window.location.href).searchParams.get("id_produto");

    fetch(`/index.php/produto/buscar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_produto: idProduto })
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
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
            // Preenche os campos do formulário com os dados retornados.
            document.getElementById('status').checked = data.status == 1;
            document.getElementById('manual').checked = data.manual == 1;
            document.getElementById('codigo').value = data.codigos.join(';') || '';
            document.getElementById('descricao').value = data.descricao || '';
            document.getElementById('volume').value = data.volume || '';
            document.getElementById('venda').value = data.venda || 'UN';

            // Chama a função para ajustar os campos de valor conforme o tipo de venda.
            verificarTipoVenda();
            if (data.venda === "UN") {
                data.precos.forEach(preco => {
                    console.log(preco);
                    if (preco.uf == "PR") {
                        document.getElementById('valorUntPr').value = formatarValor(preco.preco) || '';
                    }
                    if (preco.uf == "MS") {
                        document.getElementById('valorUntMs').value = formatarValor(preco.preco) || '';
                    }
                })
            } else if (data.venda === "QN") {
                var precosPR = [];
                var precosMS = [];

                data.precos.forEach(preco => {
                    if (preco.uf == "PR") {
                        precosPR.push(preco);
                    } else if (preco.uf == "MS") {
                        precosMS.push(preco);
                    }
                })

                if (precosPR[0].quantidade == precosMS[0].quantidade) {
                    document.getElementById('umQnt').value = precosPR[0].quantidade || '';
                }
                document.getElementById('umVlrPrQnt').value = formatarValor(precosPR[0].preco) || '';
                document.getElementById('umVlrMsQnt').value = formatarValor(precosMS[0].preco) || '';

                if (precosPR[1].quantidade == precosMS[1].quantidade) {
                    document.getElementById('doisQnt').value = precosPR[1].quantidade || '';
                }
                document.getElementById('doisVlrPrQnt').value = formatarValor(precosPR[1].preco) || '';
                document.getElementById('doisVlrMsQnt').value = formatarValor(precosMS[1].preco) || '';

                if (precosPR[2].quantidade == precosMS[2].quantidade) {
                    document.getElementById('tresQnt').value = precosPR[2].quantidade || '';
                }
                document.getElementById('tresVlrPrQnt').value = formatarValor(precosPR[2].preco) || '';
                document.getElementById('tresVlrMsQnt').value = formatarValor(precosMS[2].preco) || '';
            }
        });
}

// Obtém o elemento select e o parágrafo para exibir o resultado.
const vendaSelect = document.getElementById('venda');

// Função para verificar o valor selecionado.
function verificarTipoVenda() {
    const venda = vendaSelect.value;

    if (venda === "UN") {
        document.getElementById('telaValorUnitario').style.display = 'block';
        document.getElementById('telaValorQuantidade').style.display = 'none';
    } else if (venda === "QN") {
        document.getElementById('telaValorQuantidade').style.display = 'block';
        document.getElementById('telaValorUnitario').style.display = 'none';
    }
}

function formatarValor(valor) {
    var valorFormatado = valor.toFixed(2).replace('.', ',');
    return valorFormatado;
}

// Adiciona o evento change ao select.
vendaSelect.addEventListener('change', verificarTipoVenda);
