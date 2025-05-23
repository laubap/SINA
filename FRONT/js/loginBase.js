window.addEventListener('DOMContentLoaded', () => {
    const tipo = sessionStorage.getItem('tipoUsuario');
    const link = document.getElementById('cadastroLink');
    let usu = document.getElementById('tipoUsu');

    if (link) {
        if (tipo === 'professor') {
            link.href = '../html/paginaCadastroProfessor.html';
            usu.textContent = "Professor";
        } else if (tipo === 'responsavel') {
            link.href = '../html/paginaCadastroResponsavel.html';
            usu.textContent = "Reponsável";
        } else if (tipo === 'coordenador') {
            link.href = '../html/paginaCadastroCoordenador.html';
            usu.textContent = "Coordenador";
        } else {
            link.href = '#';
            usu.textContent = "Selecione um usuário";
        }
    }
});

if (!sessionStorage.getItem("tipoUsuario")) {
    alert("Por favor, selecione o tipo de usuário primeiro.");
    window.location.href = "selecaoUsuario.html";
}



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




