<?php

		$oMysql = conecta_db();
		
		if(isset($_POST['id_turma'])){
			$idade = $_POST['idade'];
			$nome = $_POST['nome'];
			$turma = $_POST['id_turma'];
			$data = $_POST['data_nasc'];
			$query = "INSERT INTO tb_aluno (Nome, Idade, dataNasc, Turma_idTurma) 
						VALUES ('$nome',$idade,'$data',$turma);";
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
  <h2>Insert - Aluno</h2>
  <p>Adicione um aluno</p>    

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
			<label>Idade</label>
			<input
				type="number"
				name="idade"
				class="form-control"
				style="width: 150px;"
				placeholder="Digite a idade">
			</div>

			<br/>

			<div>
			<label>Data de Nascimento</label>
			<input
				type="date"
				name="data_nasc"
				class="form-control"
				style="width: 150px;"
				placeholder="0000-00-00">
			</div>

			<br/>

			<div>
			<label>Turma</label>

			<select name="id_turma" class="form-control" style="width: 400px;">
        	<option value="">Selecione uma turma</option>
        	<?php while($row = $turmas->fetch_assoc()): ?>
          		<option value="<?= $row['idTurma'] ?>"><?= $row['Nome'] ?></option>
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
