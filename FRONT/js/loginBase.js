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





src="https://cdn.jsdelivr.net/npm/sweetalert2@11"


    // Exibir mensagem da sessão (se existir)
    fetch('http://localhost/SINA/BACK/get_mensagem.php')
    .then(response => response.json())
    .then(data => {
        if (data && data.tipo && data.texto) {
            Swal.fire({
                icon: data.tipo === 'erro' ? 'error' : 'success',
                title: data.texto
            });
        }
    });

