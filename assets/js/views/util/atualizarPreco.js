function atualizarPreco() {
    const input = document.getElementById('dados');

    const file = input.files[0];

    if (!file) {
        alert('Por favor, selecione um arquivo Excel primeiro.');
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        // Pegando a primeira aba da planilha
        const firstSheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[firstSheetName];

        // Convertendo em array de objetos
        const json = XLSX.utils.sheet_to_json(worksheet);

        if (confirm("Atualizar os preços?")) {
        fetch('/index.php/preco/atualizacao', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                dados: JSON.stringify(json),
                uf: document.getElementById('uf').value
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
                console.log(data);
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
            });
    }
    };

    reader.readAsArrayBuffer(file);
}