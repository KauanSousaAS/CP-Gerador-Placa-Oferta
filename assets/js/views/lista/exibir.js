window.addEventListener('message', function (event) {

    const data = event.data;

    const lista = document.getElementById("dados");

    fetch('/index.php/produto/exibir', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(dadosExibir = { data: data })
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
            data.forEach(produto => {

                console.log(produto);

                // Cria a placa
                const placa = gerarPlaca(produto);

                lista.appendChild(placa);
            });
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });




    // Gerando o panfleto
    function gerarPlaca(produto) {
        // Chama o construtor de elementos HTML
        const construtor = new Construtor();

        let placa = construtor.criar("div", {
            class: "placa"
        }, [
            // Adiciona a descrição do produto
            construtor.criar("div", {
                class: "placa__descricao"
            }, [
                produto.codigos.join(";") + " - " + produto.descricao,
            ]),
            (produto.precos.length > 0) ?
                ((produto.venda === "UN") ?
                    precoProdutoUnitario(produto.precos[0].preco)
                    :
                    ((produto.venda === "QN") ?
                        precoProdutoQuantidade(produto.precos, produto.volume)
                        :
                        console.log("ERRO")))
                :
                console.log("NÃO POSSUI PREÇO")
        ]);

        return placa;
    }

    function precoProdutoUnitario(preco) {
        // Chama o construtor de elementos HTML
        const construtor = new Construtor();

        const valorOferta = parseFloat(preco).toFixed(2).split('.');

        // =========================================================================
        // Observação: as porcentagems serão atributos variáveis manipulados 
        // =========================================================================

        // Calcula os valores para 3 parcelas
        let valorParcela1 = (preco * 1.04);

        let valorParcela3x = tirarMediaParcela(valorParcela1 / 3.0);

        let valorParcela3xParcela = (formatarNumeroComDecimais(valorParcela3x));

        let valorParcela3xTotal = (formatarNumeroComDecimais(valorParcela3x * 3));


        // Calcula os valores para 6 parcelas
        let valorParcela2 = ((preco * 1.04) * 1.03);

        let valorParcela6x = tirarMediaParcela(valorParcela2 / 6.0);

        let valorParcela6xParcela = (formatarNumeroComDecimais(valorParcela6x));

        let valorParcela6xTotal = (formatarNumeroComDecimais(valorParcela6x * 6));

        let quadro = construtor.criar("div", {
            class: "placa__quadro"
        }, [
            construtor.criar("div", {
                class: "valorUnitario"
            }, [
                construtor.criar("div", {
                    class: "textoRs"
                }, [
                    "R$"
                ]),
                construtor.criar("div", {
                    class: "valorInt"
                }, [
                    formatarNumero(valorOferta[0])
                ]),
                construtor.criar("div", {
                    class: "centAvista"
                }, [
                    construtor.criar("div", {
                        class: "centavo"
                    }, [
                        "," + valorOferta[1]
                    ]),
                    construtor.criar("div", {
                        class: "avista"
                    }, [
                        "À vista"
                    ])
                ])
            ])
        ]);

        quadro.appendChild(
            construtor.criar("div", {
                class: "parcela"
            }, [
                construtor.criar("div", {
                    class: "parcela_grupo"
                }, [
                    construtor.criar("div", {
                        class: "parcela_linha"
                    }, [
                        construtor.criar("div", {
                            class: "parcela_ou"
                        }, [
                            "OU"
                        ]),
                        construtor.criar("div", {
                            class: "parcela_vezes"
                        }, [
                            "3X"
                        ]),
                        construtor.criar("div", {
                            class: "parcela_rs"
                        }, [
                            " R$ "
                        ]),
                        construtor.criar("div", {
                            class: "parcela_preco"
                        }, [
                            valorParcela3xParcela.valorInteiro + "," + valorParcela3xParcela.centavo
                        ])
                    ]),
                    construtor.criar("div", {
                        class: "parcela_linha"
                    }, [
                        construtor.criar("div", {
                            class: "parcela_total"
                        }, [
                            "Total: R$ " + valorParcela3xTotal.valorInteiro + "," + valorParcela3xTotal.centavo
                        ])
                    ]),
                    construtor.criar("div", {
                        class: "parcela_linha"
                    }, [
                        construtor.criar("div", {
                            class: "parcela_ou"
                        }, [
                            "OU"
                        ]),
                        construtor.criar("div", {
                            class: "parcela_vezes"
                        }, [
                            "6X"
                        ]),
                        construtor.criar("div", {
                            class: "parcela_rs"
                        }, [
                            " R$ "
                        ]),
                        construtor.criar("div", {
                            class: "parcela_preco"
                        }, [
                            valorParcela6xParcela.valorInteiro + "," + valorParcela6xParcela.centavo
                        ])
                    ]),
                    construtor.criar("div", {
                        class: "parcela_linha"
                    }, [
                        construtor.criar("div", {
                            class: "parcela_total"
                        }, [
                            "Total: R$ " + valorParcela6xTotal.valorInteiro + "," + valorParcela6xTotal.centavo
                        ])
                    ])
                ])
            ])
        );

        return quadro;
    }

    function precoProdutoQuantidade(precos, volume) {
        // Chama o construtor de elementos HTML
        const construtor = new Construtor();

        // valor primeira quantidade
        volume = converteCodTipo(volume);

        precos[0].preco = formatarNumeroComDecimais(precos[0].preco);
        precos[1].preco = formatarNumeroComDecimais(precos[1].preco);
        precos[2].preco = formatarNumeroComDecimais(precos[2].preco);

        console.log(precos);

        console.log("\n");

        console.log(volume);

        let quadro = construtor.criar("div", {
            class: "placa__quadro__quantidade"
        }, [
            construtor.criar("div", {
                class: "quadro__quantidade"
            }, [
                construtor.criar("div", {
                    class: "primeiro"
                }, [
                    construtor.criar("div", {
                        class: "primeiro__descricao"
                    }, [
                        "Preço p/ " + volume.singular
                    ]),
                    construtor.criar("div", {
                        class: "primeiro__preco"
                    }, [
                        construtor.criar("div", {
                            class: "primeiro__preco__rs"
                        }, [
                            "R$"
                        ]),
                        construtor.criar("div", {
                            class: "primeiro__preco__inteiro"
                        }, [
                            precos[0].preco.valorInteiro
                        ]),
                        construtor.criar("div", {
                            class: "primeiro__centavo__avista"
                        }, [
                            construtor.criar("div", {
                                class: "primeiro__preco__centavo"
                            }, [
                                "," + precos[0].preco.centavo
                            ]),
                            construtor.criar("div", {
                                class: "primeiro__cadaavista"
                            }, [
                                "Cada"
                            ]),
                            construtor.criar("div", {
                                class: "primeiro__cadaavista"
                            }, [
                                "À vista"
                            ])
                        ])
                    ])
                ])
            ]),
            construtor.criar("div", {
                class: "quadro__quantidade__subprecos"
            }, [
                construtor.criar("div", {
                    class: "subprecos"
                }, [
                    construtor.criar("div", {
                        class: "subprecos__segundo"
                    }, [
                        construtor.criar("div", {
                            class: "subprecos__descricao"
                        }, [
                            "Preço p/ " + precos[1].quantidade + " " + volume.plural
                        ]),
                        construtor.criar("div", {
                            class: "subprecos__preco"
                        }, [
                            construtor.criar("div", {
                                class: "subprecos__preco__rs"
                            }, [
                                "R$"
                            ]),
                            construtor.criar("div", {
                                class: "subprecos__preco__inteiro"
                            }, [
                                precos[1].preco.valorInteiro
                            ]),
                            construtor.criar("div", {
                                class: "subprecos__centavo__avista"
                            }, [
                                construtor.criar("div", {
                                    class: "subprecos__preco__centavo"
                                }, [
                                    "," + precos[1].preco.centavo
                                ]),
                                construtor.criar("div", {
                                    class: "subprecos__cadaavista"
                                }, [
                                    "Cada"
                                ]),
                                construtor.criar("div", {
                                    class: "subprecos__cadaavista"
                                }, [
                                    "À vista"
                                ])
                            ])
                        ])
                    ])
                ]),
                construtor.criar("div", {
                    class: "subprecos"
                }, [
                    construtor.criar("div", {
                        class: "terceiro"
                    }, [
                        construtor.criar("div", {
                            class: "subprecos__descricao"
                        }, [
                            "Preço p/ " + precos[2].quantidade + " " + volume.plural
                        ]),
                        construtor.criar("div", {
                            class: "subprecos__preco"
                        }, [
                            construtor.criar("div", {
                                class: "subprecos__preco__rs"
                            }, [
                                "R$"
                            ]),
                            construtor.criar("div", {
                                class: "subprecos__preco__inteiro"
                            }, [
                                precos[2].preco.valorInteiro
                            ]),
                            construtor.criar("div", {
                                class: "subprecos__centavo__avista"
                            }, [
                                construtor.criar("div", {
                                    class: "subprecos__preco__centavo"
                                }, [
                                    "," + precos[2].preco.centavo
                                ]),
                                construtor.criar("div", {
                                    class: "subprecos__cadaavista"
                                }, [
                                    "Cada"
                                ]),
                                construtor.criar("div", {
                                    class: "subprecos__cadaavista"
                                }, [
                                    "À vista"
                                ])
                            ])
                        ])
                    ])
                ])
            ])
        ])

        return quadro;
    }

    // Utilitários

    function formatarNumero(numero) {
        // Verifica se o número é válido
        if (isNaN(numero)) {
            return "Número inválido";
        }

        // Converte o número para uma string e remove quaisquer caracteres não numéricos
        let numeroStr = numero.toString().replace(/\D/g, '');

        // Adiciona os pontos a cada 3 dígitos
        numeroStr = numeroStr.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return numeroStr;
    }
    function formatarNumeroComDecimais(numero) {
        // Verifica se o número é válido
        if (isNaN(numero)) {
            return "Número inválido";
        }

        // Converte o número para uma string com duas casas decimais e substitui o ponto por vírgula
        numero = parseFloat(numero).toFixed(2).toString().replace('.', ',');
        // Separa a parte inteira da parte decimal usando split(',')
        numero = numero.split(',');

        // Adiciona os pontos a cada 3 dígitos na parte inteira
        numero[0] = numero[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        let numeroSeparado = {
            valorInteiro: numero[0],
            centavo: numero[1]
        };

        // Recombina a parte inteira e a parte decimal
        return numeroSeparado;
    }
    function converteCodTipo(volumeSigla) {
        let volume = { singular: "", plural: "" };

        switch (volumeSigla) {
            case "UN":
                volume.singular = "unidade";
                volume.plural = "unidades";
                break;
            case "KG":
                volume.singular = "quilo";
                volume.plural = "quilos";
                break;
            case "MT":
                volume.singular = "metro";
                volume.plural = "metros";
                break;
            case "RL":
                volume.singular = "rolo";
                volume.plural = "rolos";
                break;
            case "PR":
                volume.singular = "par";
                volume.plural = "pares";
                break;
            case "CX":
                volume.singular = "caixa";
                volume.plural = "caixas";
                break;
            case "CT":
                volume.singular = "cento";
                volume.plural = "centos";
                break;
            case "ML":
                volume.singular = "milheiro";
                volume.plural = "milheiros";
                break;
            default:
                volume.singular = "erro";
                volume.plural = "erro";
                break;
        }

        return volume;
    }
    function tirarMediaParcela(numero) {
        if ((numero - Math.floor(numero)) >= 0.25 && (numero - Math.floor(numero)) <= 0.75) {
            numero = Math.floor(numero) + 0.5;
        } else if ((numero - Math.floor(numero)) > 0.75) {
            numero = Math.floor(numero) + 1;
        } else {
            numero = Math.floor(numero);
        }

        return numero;
    }
});