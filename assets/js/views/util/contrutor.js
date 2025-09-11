class Construtor {

    // Método para criar elementos HTML
    criar(tag, attrs = {}, children = []) {

        // ==========================================================
        // ===================== Como utilizar? =====================
        // ==========================================================
        //
        // 1. Importe a classe
        // <script src="/assets/js/views/util/contrutor.js"></script>
        //
        // 2. Crie uma instância da classe
        // const construtor = new Construtor();
        //
        // 3. Use o método criar para criar elementos HTML
        // construtor.criar("tag", {atributos}, ["conteúdo"]);
        // 
        // Exemplo 1:
        // construtor.criar("button", {type: "button"}, ["Botão"]);
        //
        // Exemplo 2:
        // construtor.criar("a", {
        //              href: "/home",
        //              class: "link"
        //          }, [
        //              produto.status == 1 ? "Ativo" : "Desativo"
        //          ]);
        // 
        // IMPORTANTE: manter as seguintes estruturas demonstradas
        // nos exemplos acima para padronizar o estrutura do código.
        // ==========================================================

        const el = document.createElement(tag);

        // adiciona atributos
        for (const [key, value] of Object.entries(attrs)) {
            if (key.startsWith("on") && typeof value === "function") {
                // eventos: onclick, onchange etc.
                el.addEventListener(key.substring(2), value);
            } else if (key === "class") {
                el.className = value;
            } else if (key in el) {
                // se for propriedade do elemento (ex: type, checked, value)
                el[key] = value;
            } else {
                // se for atributo comum
                el.setAttribute(key, value);
            }
        }

        // adiciona filhos (texto ou nós)
        children.forEach(child => {
            el.append(child instanceof Node ? child : document.createTextNode(child));
        });

        return el;
    }
}
