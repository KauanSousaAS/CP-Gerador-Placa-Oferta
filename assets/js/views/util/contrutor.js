class Construtor {

    // Método para criar elementos HTML
    criar(tag, attrs = {}, children = []) {
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
