<?php
		if(isset($_POST['nome']) && isset($_POST['email'])  && isset($_POST['cpf']) && isset($_POST['senha'])){
			$oMysql = conecta_db();
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$cpf = $_POST['cpf'];
			$senha = $_POST['senha'];
			$query = "INSERT INTO tb_usuario (Nome, Email, cpf, senha) 
          VALUES ('$nome', '$email', '$cpf', '$senha')";
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
			<label>Cpf</label>
			<input
				type="number"
				name="cpf"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite aqui o cpf.">
			</div>
		
			<br/>

			<div>
			<label>Senha</label>
			<input
				type="password"
				name="senha"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite aqui a senha.">
			</div>
				
			<button
				type="submit"
				class="btn btn-primary"> Enviar </button>
		
		</form>


  
</div>

</body>
</html>
