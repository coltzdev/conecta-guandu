const categorias = document.querySelectorAll('.categoria-menu');

function fecharCategoria(categoria) {
    categoria.classList.remove('aberto');
    categoria.querySelector('.categoria-menu-botao').setAttribute('aria-expanded', 'false');
}

categorias.forEach((categoria) => {
    const botao = categoria.querySelector('.categoria-menu-botao');

    botao.addEventListener('click', () => {
        const estaAberta = categoria.classList.contains('aberto');

        categorias.forEach((outraCategoria) => {
            if (outraCategoria !== categoria) {
                fecharCategoria(outraCategoria);
            }
        });

        categoria.classList.toggle('aberto');
        botao.setAttribute('aria-expanded', estaAberta ? 'false' : 'true');
    });
});

document.addEventListener('click', (evento) => {
    if (!evento.target.closest('.categoria-menu')) {
        categorias.forEach(fecharCategoria);
    }
});