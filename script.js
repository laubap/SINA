function adicionarMatricula() {
    let container = document.getElementById("matriculas-container");
    let div = document.createElement("div");
    div.className = "input-group mt-2";

    let novoInput = document.createElement("input");
    novoInput.type = "text";
    novoInput.name = "matricula_aluno[]"; 
    novoInput.className = "form-control";
    novoInput.placeholder = "Matrícula";


    div.appendChild(novoInput);


    container.appendChild(div);
}