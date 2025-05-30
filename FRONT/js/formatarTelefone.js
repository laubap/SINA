function formatarTelefone() {
    document.querySelector('input[name="telefoneResponsavel"]').addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });
}

// Executa quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', formatarTelefone);