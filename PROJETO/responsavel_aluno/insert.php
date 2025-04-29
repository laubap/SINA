<?php

		$oMysql = conecta_db();
		
		if (isset($_POST['id_aluno']) && isset($_POST['id_responsavel'])){
			$responsavel = $_POST['id_responsavel'];
			$aluno = $_POST['id_aluno'];
			$query = "INSERT INTO tb_responsavel_aluno (Aluno_idAluno, Responsavel_idUsuario) 
						VALUES ($aluno, $responsavel)";
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}


		$responsaveis = $oMysql->query("SELECT
    									r.*,
    									u.Nome AS Nome
										FROM
    									tb_responsavel r
										JOIN
										tb_usuario u ON r.idUsuario = u.idUsuario;");

		$alunos = $oMysql->query("SELECT idAluno, Nome FROM tb_aluno");

?>
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
  <h2>Insert - Responsavel</h2>
  <p>Adicione um responsavel</p>    

		<form
			method="POST"
			action="index.php?page=1">

			<div>
			<label>Aluno:</label>
			<select name="id_aluno" class="form-control" style="width: 400px;">
        	<option value="">Selecione um Aluno</option>
        	<?php while($row = $alunos->fetch_assoc()): ?>
          		<option value="<?= $row['idAluno'] ?>"><?= $row['Nome'] ?></option>
        		<?php endwhile; ?>
      		</select>
			</div>

			<br/>

			<div>
			<label>Responsável:</label>
			<select name="id_responsavel" class="form-control" style="width: 400px;">
        	<option value="">Selecione um Responsável</option>
        	<?php while($row = $responsaveis->fetch_assoc()): ?>
          		<option value="<?= $row['idUsuario'] ?>"><?= $row['Nome'] ?></option>
        		<?php endwhile; ?>
      		</select>
			</div>

			<br/>
				
			<button
				type="submit"
				class="btn btn-primary"> Enviar </button>
		
		</form>


  
</div>

</body>
</html>
