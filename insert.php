<?php
	if(isset($_POST['cpf']) && isset($_POST['senha']) && isset($_POST['tipo_usuario']) && isset($_POST['email']) && isset($_POST['nome_completo']) && isset($_POST['matricula_aluno'])){
		$oMysql = conecta_db();
		$query = "INSERT INTO tb_usuarios (cpf, senha, tipo_usuario, email, nome_completo, matricula_aluno) 
				  VALUES ('".$_POST['cpf']."', '".$_POST['senha']."', '".$_POST['tipo_usuario']."', '".$_POST['email']."' , '".$_POST['nome_completo']."' , '".$_POST['matricula_aluno']."')";
		$resultado = $oMysql->query($query);
		

		header('location: index.php');
		exit();
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
  <script src="C:\xampp\htdocs\SINA\script.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>Registro</h2>
  <p>Preencha os campos abaixo para registrar um usuário:</p>    

		<form
			method="POST"
			action="index.php?page=1">
		
			<input
				type="number"
				name="cpf"
				class="form-control"
				placeholder="CPF">

				<input
				type="text"
				name="senha"
				class="form-control"
				placeholder="Senha">

				<input
				type="text"
				name="email"
				class="form-control"
				placeholder="Email">

				<input
				type="text"
				name="nome_completo"
				class="form-control"
				placeholder="Nome completo">

				<div><br></div>

				<div class="form-check">
			<input type="radio" name="tipo_usuario" value="1" class="form-check-input" id="responsavel">
			<label class="form-check-label" for="responsavel">Usuário Responsável</label>
		</div>

		<div class="form-check">
			<input type="radio" name="tipo_usuario" value="2" class="form-check-input" id="professor">
			<label class="form-check-label" for="professor">Usuário Professor</label>
		</div>

		<div class="form-check">
			<input type="radio" name="tipo_usuario" value="3" class="form-check-input" id="coordenador">
			<label class="form-check-label" for="coordenador">Usuário Coordenador</label>
		</div>

		<div><br></div>

		<div id="matriculas-container">
            <div class="input-group mt-2">
                <input type="text" name="matricula_aluno[]" class="form-control" placeholder="Matrícula">
            </div>
        </div>

        <button type="button" class="btn btn-success mt-2" onclick="adicionarMatricula()">Adicionar Matrícula</button>

		<div><br></div>
				
			<button
				type="submit"
				class="btn btn-primary"> Enviar </button>
		
		</form>


  
</div>

</body>
</html>
