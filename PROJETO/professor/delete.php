<?php
		if(isset($_GET['Usuario_idUsuario'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_professor  
				WHERE Usuario_idUsuario = ".$_GET['Usuario_idUsuario'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
