<!DOCTYPE html>
<html lang="en">
<head>
  <title>Lista de Registros</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Lista de Alunos</h2>
  <p>Dados de tb_aluno:</p>
  <p><a class="btn btn-primary" 
		href="index.php?page=1">Adicionar novo aluno</a></p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>Nome</th>
		<th>Idade</th>
		<th>Data de Nascimento</th>
		<th>Turma</th>

      </tr>
    </thead>
    <tbody>
	<?php
		$oMysql = conecta_db();

		$query = "SELECT
    	a.*,
    	u.Nome AS Nome_Turma
		FROM
    	tb_aluno a
		JOIN
    	tb_turma u ON a.Turma_idTurma = u.idTurma";

		$resultado = $oMysql->query($query);
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$botoes = "<a 
				class='btn btn-success' 
				 href='index.php?page=2&idAluno=".$linha->idAluno."'>Alterar</a>";
				$botoes .= "<a 
				class='btn btn-danger'				
				 href='index.php?page=3&idAluno=".$linha->idAluno."'>Excluir</a>";
				
				$html = "<tr>";
				$html .= "<td>".$botoes."</td>";
				$html .= "<td>".$linha->idAluno."</td>";
				$html .= "<td>".$linha->Nome."</td>";
				$html .= "<td>".$linha->Idade."</td>";
				$html .= "<td>".$linha->dataNasc."</td>";
				$html .= "<td>".$linha->Nome_Turma."</td>";
				$html .= "</tr>";
				echo $html;
			}
		}
	?>
	</tbody>
  </table>
</div>

</body>
</html>
