// Script para a criação de alertas de erro dentro da página de login
// Login.php vai fazer a verificação de credenciais e, caso hava algum erro, vai enviar por meio do get_mensagem.php em formato json
// Vai pegar o arquivo json e fazer a leitura do erro para fazer a exibição SwetAlert do q aconteceu

window.addEventListener('DOMContentLoaded', () => {
    fetch('../../BACK/get_mensagem.php')
        .then(response => response.json())
        .then(data => {
            if (data && data.tipo && data.texto) {
                Swal.fire({


                    // Template q identifica se é um erro ou sucesso com base na mensagem q vc enviar para o get_mensagem
                    // EX: $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Senha incorreta'];
                    // EX: $_SESSION['mensagem'] = ['tipo' => 'sucesso' ((((ou 'success')))), 'texto' => 'Mensagem de sucesso'];


                    icon: data.tipo === 'erro' ? 'error' : 'success',
                    title: data.tipo === 'erro' ? 'Erro!' : 'Sucesso!',
                    text: data.texto
                });
            }
        });
});