<?php

		$oMysql = conecta_db();

		if(isset($_POST['id_turma'])){
			$idade = $_POST['idade'];
			$nome = $_POST['nome'];
			$turma = $_POST['id_turma'];
			$data = $_POST['data_nasc'];
			$query = "UPDATE tb_aluno
				SET Nome = '$nome',
					Idade = $idade,
					dataNasc = '$data',
					Turma_idTurma = $turma
				WHERE idAluno = ".$_GET['idAluno'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}



		$turmas = $oMysql->query("SELECT * FROM tb_turma");

    	if (isset($_POST['id_turma'])) {
    		$id_turma = $_POST['id_turma'];
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
  <h2>Aluno ID: <?php echo $_GET['idAluno']; ?></h2>
  <p>Alterar dados de aluno:</p>    

		<form
			method="POST"
			action="index.php?page=2&idAluno=<?php echo $_GET['idAluno']; ?>">

			<?php
				$oMysql = conecta_db();
				$query = "SELECT
    					a.*,
    					u.Nome AS Nome_Turma
						FROM
    					tb_aluno a
						JOIN
    					tb_turma u
						WHERE idAluno = ".$_GET['idAluno'];
				$resultado = $oMysql->query($query);

				$nome = "";
				$idade = "";
				$turma = "";
				$data = "";
				if($resultado){
					while($linha = $resultado->fetch_object()){
						$nome = $linha->Nome;
						$idade = $linha->Idade;
						$data = $linha->dataNasc;
						$id_turma = $linha->Turma_idTurma;
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
			<label>Idade</label>
			<input
				type="number"
				name="idade"
				class="form-control"
				style="width: 150px;"
				value="<?php echo $idade;?>">
			</div>

			<br/>

			<div>
			<label>Data de Nascimento</label>
			<input
				type="date"
				name="data_nasc"
				class="form-control"
				style="width: 150px;"
				value="<?php echo $data;?>">
			</div>

			<br/>

			<div>
			<label>Turma</label>

			<select name="id_turma" class="form-control" style="width: 400px;">
        	<option value="">Selecione uma turma</option>
        	<?php while($row = $turmas->fetch_assoc()): ?>

				<?php
					$selected = "";
					if($id_turma == $row['idTurma']){
						$selected = "selected";
					}
				?>
          		<option value="<?= $row['idTurma'] ?>" <?=$selected?>><?= $row['Nome'] ?></option>
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
