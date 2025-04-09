<?php
		if(isset($_GET['teste_id'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_usuario  
				WHERE idUsuario = ".$_GET['teste_id'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
