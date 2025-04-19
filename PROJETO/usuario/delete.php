<?php
		if(isset($_GET['idUsuario'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_usuario  
				WHERE idUsuario = ".$_GET['idUsuario'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
