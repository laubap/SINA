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


// Enviar o tipo de usuário via POST para o login.php para fazer a filtragem de login, fazendo com q o usuário
// só consiga fazer login no local certo.
// EX: responsável só pode fazer login na aba de responsável

document.addEventListener("DOMContentLoaded", () => {
    const tipoLogin = sessionStorage.getItem("tipoUsuario");

    const form = document.querySelector("form");

    if (form && tipoLogin) {
        const inputHidden = document.createElement("input");
        inputHidden.type = "hidden";
        inputHidden.name = "tipoUsuario";
        inputHidden.value = tipoLogin;
        form.appendChild(inputHidden);
    }
});

