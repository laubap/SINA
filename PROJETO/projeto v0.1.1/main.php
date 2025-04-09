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
  <h2>Lista de Registros</h2>
  <p>Os dados que estão registrados na tabela tb_teste são:</p>
  <p><a class="btn btn-primary" 
		href="index.php?page=1">Adicione um novo registro</a></p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>Descrição</th>
      </tr>
    </thead>
    <tbody>
	<?php
		$oMysql = conecta_db();
		$query = "SELECT * FROM tb_teste";
		$resultado = $oMysql->query($query);
		if($resultado){
			while($linha = $resultado->fetch_object()){
				$tipo_usuario = '';
				switch($linha->tipoUsuario){
					case 1: $tipoUsuario = 'Estudante'; break;
					case 2: $tipoUsuario = 'Professor'; break;
					case 3: $tipoUsuario = 'Coordenador'; break;
					default: $tipoUsuario = 'Desconhecido';
				}

				$html .= "<td>".$tipoUsuario."</td>";
				$botoes = "<a 
				class='btn btn-success' 
				 href='index.php?page=2&teste_id=".$linha->teste_id."'>Alterar</a>";
				$botoes .= "<a 
				class='btn btn-danger'				
				 href='index.php?page=3&teste_id=".$linha->teste_id."'>Excluir</a>";
				
				$html = "<tr>";
				$html .= "<td>".$botoes."</td>";
				$html .= "<td>".$linha->teste_id."</td>";
				$html .= "<td>".$linha->descricao."</td>";
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
