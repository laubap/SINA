<?php

		$oMysql = conecta_db();
		
		if(isset($_POST['id_professor'])){
			$sala = $_POST['sala'];
			$nome = $_POST['nome'];
			$professor = $_POST['id_professor'];
			$query = "INSERT INTO tb_turma (Sala, Nome, Professor_Usuario_idUsuario) 
						VALUES ($sala,'$nome',$professor)";
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}


		$professores = $oMysql->query("SELECT p.*,
    	u.Nome AS Nome
		FROM
    	tb_professor p
		JOIN
    	tb_usuario u ON p.Usuario_idUsuario = u.idUsuario;");

    	if (isset($_POST['id_professor'])) {
    		$id_professor = $_POST['id_professor'];
		}
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
  <h2>Insert - Turma</h2>
  <p>Adicione uma turma</p>    

		<form
			method="POST"
			action="index.php?page=1">

			<div>
			<label>Nome</label>
			<input
				type="text"
				name="nome"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite o nome">
			</div>

			<br/>

			<div>
			<label>Sala</label>
			<input
				type="number"
				name="sala"
				class="form-control"
				style="width: 150px;"
				placeholder="Digite a sala">
			</div>

			<br/>

			<div>
			<label>Professor</label>

			<select name="id_professor" class="form-control" style="width: 400px;">
        	<option value="">Selecione um professor</option>
        	<?php while($row = $professores->fetch_assoc()): ?>
          		<option value="<?= $row['Usuario_idUsuario'] ?>"><?= $row['Nome'] ?></option>
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
