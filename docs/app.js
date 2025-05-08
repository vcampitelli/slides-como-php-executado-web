/**
 * Substitui tags <img> de SVGs pelo conteúdo real
 */
document.querySelectorAll('img.insert-svg').forEach(($img) => {
    // promises.push(
        fetch($img.src).then(response => response.text()).then(contents => {
            const $wrapper = document.createElement('div');
            $wrapper.classList.add('svg-wrapper');
            if ($img.dataset.id) {
                contents = contents.replace('<svg', '<svg data-id="' + encodeURIComponent($img.dataset.id) + '"');
            }
            $wrapper.innerHTML = contents.replace('<?xml version="1.0" encoding="UTF-8"?>', '');
            $img.parentNode.replaceChild($wrapper, $img);
        });
    // );
});


/**
 * Funcionalidade "Copiar para a área de transferência" em códigos
 */
Reveal.initialize({
    hash: true,
    transitionSpeed: 'fast',
    mouseWheel: false,
    overview: false,
    history: true,
    plugins: [RevealHighlight, RevealNotes],
    slideNumber: 'c/t',
});
