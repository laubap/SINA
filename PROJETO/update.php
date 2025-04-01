<?php
		if(isset($_POST['senha']) || isset($_POST['email']) || isset($_POST['nome_completo'])){
			$oMysql = conecta_db();
			$query = "UPDATE tb_usuarios 
			SET senha = '".$_POST['senha']."',
    		email = '".$_POST['email']."',
    		nome_completo = '".$_POST['nome_completo']."'  
			WHERE id = ".$_GET['id'];

				
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
  <h2>CRUD - Update - ID: <?php echo $_GET['id']; ?></h2>
  <p>Preencha o campo para alterar os dados existentes:</p>    

		<form
			method="POST"
			action="index.php?page=2&id=<?php echo $_GET['id']; ?>">
		
			<input
				type="text"
				name="senha"
				class="form-control"
				placeholder="Altere aqui a senha.">

			<input
				type="text"
				name="email"
				class="form-control"
				placeholder="Altere aqui o email.">
				
			<input
				type="text"
				name="nome_completo"
				class="form-control"
				placeholder="Altere aqui o nome completo.">

			<button
				type="submit"
				class="btn btn-primary"> Enviar </button>
		</form>
</div>

</body>
</html>
