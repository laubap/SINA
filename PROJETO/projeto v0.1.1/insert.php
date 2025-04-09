<?php 
	if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['tipo_usuario'])) {
		$oMysql = conecta_db();
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$tipo = $_POST['tipo_usuario'];
		$query = "INSERT INTO tb_usuario (Nome, Email, tipoUsuario)  VALUES ('$nome', '$email', '$tipo')";
		$resultado = $oMysql->query( $query );
		header('location: index.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Adicionar Usuario</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
	<h2>Adicionar Novo Usuario</h2>
	<p>Preencha os campos abaixo:</p>

		<form method="POST" action="index.php?page=1">
			<div class="mb-3">
				<label class="form-label">Nome</label>
				<input type="text" name="nome" class="form-control" placeholder="Digite o nome" required>
			</div>

			<div class="mb-3">
				<label class="form-label">Email</label>
				<input type="email" name="email" class="form-control" placeholder="Digite o email" required>]
			</div>

			<div class="mb-3">
				<label class="form-label">Tipo de Usuario</label>
				<select name="tipo_usuario" class="form-control" required>
					<option value="">Selecione ...</option>
					<option value="1">Estudante</option>
					<option value="2">Professor</option>
					<option value="3">Coordenador</option>
				</select>
			</div>

			<button type="submit" class="btn btn-primary">Cadastrar</button>
		</form>
</div>
</body>
</html>