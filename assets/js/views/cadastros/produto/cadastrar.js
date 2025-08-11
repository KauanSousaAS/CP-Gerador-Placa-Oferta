// Encaminhar as informações de login para o loginController.
function cadastrar() {

    // Desativa o botão de Salvar para evitar multiplas inserções.
    document.getElementById('butaoCadastrar').disabled = true;

    // Captura as informações de login e preparando o array 'dadosCadastr' para envio.
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

    // Gera a requisição para encaminhamento das informações para o loginController.php.
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
            // Exibe uma mensagem de sucesso.
            alert('Produto cadastrado com sucesso!');
            
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

// Adiciona o evento change ao select.
vendaSelect.addEventListener('change', verificarTipoVenda);

// Chama a função inicialmente para garantir que a mensagem padrão seja exibida.
verificarTipoVenda();
