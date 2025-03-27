<!DOCTYPE html>
<html lang="en">
<head>
  <title>SINA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Registros de Usuários SINA </h2>
  <div><br></div>
  <p>Os dados que estão registrados na tabela tb_usuarios são:</p>
  <p><a class="btn btn-primary" 
		href="index.php?page=1">Adicione um novo registro</a></p>
		
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>CPF</th>
		<th>Senha</th>
		<th>Tipo usuário</th>
		<th>Email</th>
		<th>Nome</th>
		<th>Matricula</th>
      </tr>
    </thead>
    <tbody>
	<?php
    $oMysql = conecta_db();
    $query = "
        SELECT id, cpf, senha, tipo_usuario, email, nome_completo, matricula_aluno, 
       CASE
           WHEN tipo_usuario = 1 THEN 'Responsável'
           WHEN tipo_usuario = 2 THEN 'Professor'
           WHEN tipo_usuario = 3 THEN 'Coordenador'
           ELSE 'Desconhecido'
       	END AS tipo_usuario
		FROM tb_usuarios;

    ";
    $resultado = $oMysql->query($query);
    
    if($resultado){
        while($linha = $resultado->fetch_object()){
            
            // Gerando os botões
            $botoes = "<a class='btn btn-success' href='index.php?page=2&id=".$linha->id."'>Alterar</a>";
            $botoes .= "<a class='btn btn-danger' href='index.php?page=3&id=".$linha->id."'>Excluir</a>";
            
            // Criando a linha da tabela
            $html = "<tr>";
            $html .= "<td>".$botoes."</td>";
            $html .= "<td>".$linha->id."</td>";
            $html .= "<td>".$linha->cpf."</td>";
            $html .= "<td>".$linha->senha."</td>";
            $html .= "<td>".$linha->tipo_usuario."</td>"; 
			$html .= "<td>".$linha->email."</td>";
			$html .= "<td>".$linha->nome_completo."</td>";
			$html .= "<td>".$linha->matricula_aluno."</td>";    
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
