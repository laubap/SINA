window.addEventListener('DOMContentLoaded', () => {
    const tipo = sessionStorage.getItem('tipoUsuario');
    const link = document.getElementById('cadastroLink');

    if (link) {
        if (tipo === 'professor') {
            link.href = '../html/paginaCadastroProfessor.html';
        } else if (tipo === 'responsavel') {
            link.href = '../html/paginaCadastroResponsavel.html';
        } else if (tipo === 'coordenador') {
            link.href = '../html/paginaCadastroCoordenador.html';
        } else {
            link.href = '#';
        }
    }
});
