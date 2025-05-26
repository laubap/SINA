<?php
    include(__DIR__ . "/conecta_db.php");
	if(isset($_GET['idComunicado'])){
		$oMysql = conecta_db();
		$query = "DELETE FROM tb_comunicado  
			WHERE idComunicado = ".$_GET['idComunicado'];
		$resultado = $oMysql->query($query);
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Comunicado excluido'];
		$fallback = "../FRONT/index.html";
        $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
        header("Location: $anterior");
        exit;
	}
?>
