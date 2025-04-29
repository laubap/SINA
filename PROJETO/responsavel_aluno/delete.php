<?php
		if (isset($_POST['id_aluno']) && isset($_POST['id_responsavel'])){
			$oMysql = conecta_db();
			$query = "DELETE FROM tb_responsavel_aluno  
				WHERE Aluno_idAluno = ".$_GET['Aluno_idAluno'].
				"AND Responsavel_idUsuario = ".$_GET['Responsavel_idUsuario'];
			$resultado = $oMysql->query($query);
			header('location: index.php');
		}
?>
