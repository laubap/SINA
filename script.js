function adicionarMatricula() {
    let container = document.getElementById("matriculas-container");

    // Criar o div para o novo input
    let div = document.createElement("div");
    div.className = "input-group mt-2";

    // Criar o input de matrícula
    let novoInput = document.createElement("input");
    novoInput.type = "text";
    novoInput.name = "matricula_aluno[]"; // Array no PHP
    novoInput.className = "form-control";
    novoInput.placeholder = "Matrícula";

    // Adicionar o novo input ao div
    div.appendChild(novoInput);

    // Adicionar o div ao container de matrículas
    container.appendChild(div);
}