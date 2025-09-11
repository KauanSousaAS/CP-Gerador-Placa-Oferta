function listarFilial() {

    fetch('/index.php/filial/listar', {
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
            let listaFiliais = document.getElementById('listaFiliais');
            data.forEach(function (filial) {
                let linhaFilial = construtor.criar("tr", {}, [
                    construtor.criar("td", {}, [
                        construtor.criar("input", {
                            type: "checkbox",
                            value: filial.id_filial
                        })]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/filial/editar?id_filial=${filial.id_filial}`
                        }, [
                            filial.filial
                        ])
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/filial/editar?id_filial=${filial.id_filial}`
                        }, [
                            filial.uf
                        ])
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("a", {
                            href: `/views/cadastros/filial/editar?id_filial=${filial.id_filial}`
                        }, [
                            filial.status == 1 ? "Ativo" : "Inativo"
                        ])
                    ]),
                    construtor.criar("td", {}, [
                        construtor.criar("button", {
                            type: "button"
                        }, [
                            "Excluir"
                        ])
                    ])
                ]);
                listaFiliais.appendChild(linhaFilial);
            });
        })
        .catch(error => {
            // Retorna o erro no console.error.
            console.error('Erro na requisição:', error);
        });
}