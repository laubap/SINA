<?php
		if(isset($_GET['idTurma'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_turma  
				WHERE idTurma = ".$_GET['idTurma'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
