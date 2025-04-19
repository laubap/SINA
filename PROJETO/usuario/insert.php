<?php
		if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['tipo_usuario'])){
			$oMysql = conecta_db();
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$tipo = $_POST['tipo_usuario'];
			$query = "INSERT INTO tb_usuario (Nome, Email, tipoUsuario) 
						VALUES ('$nome', '$email', $tipo)";
			$resultado = $oMysql->query($query);
			header('location: index.php');
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
  <h2>Insert - Usuário</h2>
  <p>Adicione um usuário</p>    

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
				placeholder="Digite aqui o nome.">
			</div>

			<br/>

			<div>
			<label>Email</label>
			<input
				type="text"
				name="email"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite aqui o email.">
			</div>

			<br/>

			<div>
			<label>Tipo de Usuario</label>
			<input
				type="number"
				name="tipo_usuario"
				class="form-control"
				style="width: 50px;">
			</div>
		
			<br/>
				
			<button
				type="submit"
				class="btn btn-primary"> Enviar </button>
		
		</form>


  
</div>

</body>
</html>
