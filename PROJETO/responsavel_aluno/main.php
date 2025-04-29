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
  <h2>Relação Responsável / Aluno</h2>
  <p>Dados de tb_responsavel_aluno:</p>
  <p><a class="btn btn-primary" 
		href="index.php?page=1">Adicione um novo relacionamento</a></p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>ID - Responsavel</th>
        <th>Nome - Responsavel</th>
		<th>ID - Aluno</th>
        <th>Nome - Aluno</th>

      </tr>
    </thead>
    <tbody>
	<?php
		$oMysql = conecta_db();

		$query = "SELECT
    			r.*,
    			u.Nome AS Nome_resp,
    			a.Nome AS Nome_aluno
				FROM
    			tb_responsavel_aluno r
				JOIN
    			tb_usuario u ON r.Responsavel_idUsuario = u.idUsuario
				JOIN
   				tb_aluno a ON r.Aluno_idAluno = a.idAluno;";

		$resultado = $oMysql->query($query);
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$botoes = "<a 
				class='btn btn-success' 
				 href='index.php?page=2&id_aluno=".$linha->Aluno_idAluno."&id_responsavel=".$linha->Responsavel_idUsuario."'>Alterar</a>";
				$botoes .= "<a 
				class='btn btn-danger'				
				 href='index.php?page=3&id_aluno=".$linha->Aluno_idAluno."&id_responsavel=".$linha->Responsavel_idUsuario."'>Excluir</a>";
				
				$html = "<tr>";
				$html .= "<td>".$botoes."</td>";
				$html .= "<td>".$linha->Responsavel_idUsuario."</td>";
				$html .= "<td>".$linha->Nome_resp."</td>";
				$html .= "<td>".$linha->Aluno_idAluno."</td>";
				$html .= "<td>".$linha->Nome_aluno."</td>";
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
