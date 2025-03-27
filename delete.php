<?php
		if(isset($_GET['id'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_usuarios  
				WHERE id = ".$_GET['id'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
