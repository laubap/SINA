function adicionarInput() {
    // Cria o novo elemento HTML com o input
    const novoInput = `
        <div class="input-group mt-2">
            <input type="text" name="matricula_aluno[]" class="form-control" placeholder="Matrícula">
        </div>
    `;
    
    // Pega o container onde os inputs serão adicionados
    const container = document.getElementById("matriculas-container");
    
    // Adiciona o novo input ao container
    container.innerHTML += novoInput;
}
