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
  <h2>Lista de Usuários</h2>
  <p>Dados de tb_usuario:</p>
  <p><a class="btn btn-primary" 
		href="index.php?page=1">Adicione um novo usuário</a></p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>Descrição</th>
		<th>Email</th>
		<th>Cpf</th>
		<th>Senha</th>
      </tr>
    </thead>
    <tbody>
	<?php
		$oMysql = conecta_db();
		$query = "SELECT * FROM tb_usuario";
		$resultado = $oMysql->query($query);
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$botoes = "<a 
				class='btn btn-success' 
				 href='index.php?page=2&idUsuario=".$linha->idUsuario."'>Alterar</a>";
				$botoes .= "<a 
				class='btn btn-danger'				
				 href='index.php?page=3&idUsuario=".$linha->idUsuario."'>Excluir</a>";
				
				$html = "<tr>";
				$html .= "<td>".$botoes."</td>";
				$html .= "<td>".$linha->idUsuario."</td>";
				$html .= "<td>".$linha->Nome."</td>";
				$html .= "<td>".$linha->Email."</td>";
				$html .= "<td>".$linha->cpf."</td>";
				$html .= "<td>".$linha->senha."</td>";
				
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
