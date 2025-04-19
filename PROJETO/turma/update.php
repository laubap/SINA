<?php

		$oMysql = conecta_db();

		if(isset($_POST['id_professor'])){
			$sala = $_POST['sala'];
			$nome = $_POST['nome'];
			$professor = $_POST['id_professor'];
			$query = "UPDATE tb_turma
				SET Nome = '$nome',
					Sala = $sala,
					Professor_Usuario_idUsuario = $professor
				WHERE idTurma = ".$_GET['idTurma'];
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
  <h2>Usuário ID: <?php echo $_GET['idTurma']; ?></h2>
  <p>Alterar dados de usuário:</p>    

		<form
			method="POST"
			action="index.php?page=2&idTurma=<?php echo $_GET['idTurma']; ?>">

			<?php
				$oMysql = conecta_db();
				$query = "SELECT t.*,
    					u.Nome AS Nome_Professor,
						u.idUsuario AS idProfessor
						FROM
    					tb_turma t
						JOIN
    					tb_usuario u ON t.Professor_Usuario_idUsuario = u.idUsuario
						WHERE idTurma = ".$_GET['idTurma'];
				$resultado = $oMysql->query($query);

				$nome = "";
				$sala = "";
				$professor = "";
				if($resultado){
					while($linha = $resultado->fetch_object()){
						$nome = $linha->Nome;
						$sala = $linha->Sala;
						$professor = $linha->Nome_Professor;
						$idProfessor = $linha->idProfessor;
					}
				}

			?>


			<div>
			<label>Nome</label>
			<input
				type="text"
				name="nome"
				class="form-control"
				style="width: 400px;"
				value="<?php echo $nome;?>"
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
				value="<?php echo $sala;?>"
				placeholder="Digite a sala">
			</div>

			<br/>

			<div>
			<label>Professor</label>
			<select name="id_professor" class="form-control" style="width: 400px;">
        	<option value="">Selecione um Professor:</option>
        	<?php while($row = $professores->fetch_assoc()): ?>

				<?php
					$selected = "";
					if($idProfessor == $row['Usuario_idUsuario']){
						$selected = "selected";
					}
				?>
          		<option value="<?= $row['Usuario_idUsuario'] ?>" <?=$selected?>><?= $row['Nome'] ?></option>
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
