<?php
		if(isset($_POST['nome']) && isset($_POST['email'])&& isset($_POST['cpf'])  && isset($_POST['senha'])){
			$oMysql = conecta_db();
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$cpf = $_POST['cpf'];
			$senha = $_POST['senha'];
			$query = "UPDATE tb_usuario 
				SET Nome = '$nome',
					Email = '$email',
					cpf = '$cpf',
					senha = '$senha'
				WHERE idUsuario = ".$_GET['idUsuario'];
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
  <h2>Usuário ID: <?php echo $_GET['idUsuario']; ?></h2>
  <p>Alterar dados de usuário:</p>    

		<form
			method="POST"
			action="index.php?page=2&idUsuario=<?php echo $_GET['idUsuario']; ?>">

			<?php
				$oMysql = conecta_db();
				$query = "SELECT * FROM tb_usuario WHERE idUsuario = ".$_GET['idUsuario'];
				$resultado = $oMysql->query($query);

				$nome = "";
				$email = "";
				$cpf = "";
				$senha = "";

				if($resultado){
					while($linha = $resultado->fetch_object()){
						$nome = $linha->Nome;
						$email = $linha->Email;
						$cpf = $linha->cpf;
						$senha = $linha->senha;
					}
				}

			?>
			<div>
			<label>Nome</label>
			<input
				type="text"
				name="nome"
				value="<?php echo $nome;?>"
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
				value="<?php echo $email;?>"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite aqui o email.">
			</div>

			<div>
			<label>Cpf</label>
			<input
				type="number"
				name="cpf"
				value="<?php echo $cpf;?>"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite aqui o cpf.">
			</div>

			
			<div>
			<label>Senha</label>
			<input
				type="password"
				name="senha"
				value="<?php echo $senha;?>"
				class="form-control"
				style="width: 400px;"
				placeholder="Digite aqui a senha.">
			</div>

			<br/>
			<br/>

			<button
				type="submit"
				class="btn btn-primary"> Enviar </button>
		</form>
</div>

</body>
</html>
