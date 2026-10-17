import phpBinary from './php-web.mjs';
import { CodeJar } from '../vendor/codejar/codejar.js';

export async function loadPhp(code) {
    const output = [];
    const print = (data) => output.push(String(data));
    const { ccall } = await phpBinary({ print, printErr: print });

    ccall('phpw_run', null, ['string'], ['?>' + code]);
    return output.join('\n');
}

const input = document.getElementById('sample-php');
const button = document.getElementById('wasm-run');
const output = document.getElementById('wasm-output');

if (input && button && output) {
    const highlighter = RevealHighlight().hljs;
    const editor = CodeJar(input, (element) => {
        element.innerHTML = highlighter.highlight(element.textContent, {
            language: 'php',
        }).value;
    }, { tab: '    ' });
    editor.updateCode(input.textContent);

    button.addEventListener('click', async () => {
        button.disabled = true;
        output.textContent = 'Executando…';

        try {
            output.textContent = await loadPhp(editor.toString());
        } catch (error) {
            output.textContent = `Erro ao executar PHP: ${error.message ?? error}`;
        } finally {
            button.disabled = false;
        }
    });
}
