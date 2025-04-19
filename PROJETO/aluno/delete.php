<?php
		if(isset($_GET['idAluno'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_aluno  
				WHERE idAluno = ".$_GET['idAluno'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
