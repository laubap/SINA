
function adicionarCampo() {
  const container = document.getElementById('matriculaContainer');
  const input = document.createElement('input');
  input.type = 'text';
  input.name = 'matriculaAluno[]';
  input.className = 'inputLogin';
  input.placeholder = 'Digite a matrícula do aluno';
  container.appendChild(input);
}

