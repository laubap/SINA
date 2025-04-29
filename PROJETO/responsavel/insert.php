<?php

		$oMysql = conecta_db();
		
		if(isset($_POST['id_usuario'])){
			$usuario = $_POST['id_usuario'];
			$query = "INSERT INTO tb_responsavel (idUsuario) 
						VALUES ($usuario)";
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}


		$usuarios = $oMysql->query("SELECT idUsuario, Nome FROM tb_usuario");

    	if (isset($_POST['id_usuario'])) {
    		$id_usuario = $_POST['id_usuario'];
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
  <h2>Insert - Responsavel</h2>
  <p>Adicione um responsavel</p>    

		<form
			method="POST"
			action="index.php?page=1">

			<div>
			<label>Usuario:</label>
	<!-- -->
			<select name="id_usuario" class="form-control" style="width: 400px;">
        	<option value="">Selecione um usuário</option>
        	<?php while($row = $usuarios->fetch_assoc()): ?>
          		<option value="<?= $row['idUsuario'] ?>"><?= $row['Nome'] ?></option>
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
