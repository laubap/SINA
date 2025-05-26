<?php
		session_start();
		include(__DIR__ . "/conecta_db.php");
		$oMysql = conecta_db();


#RESPONSAVEL

		if(isset($_POST['nomeResponsavel']) && isset($_POST['emailResponsavel']) && isset($_POST['senhaResponsavel'])){
			$oMysql = conecta_db();
			$nome = $_POST['nomeResponsavel'];
			$email = $_POST['emailResponsavel'];
			$senha = password_hash($_POST['senhaResponsavel'], PASSWORD_DEFAULT);
			$query = "UPDATE tb_responsavel 
				SET nomeResponsavel = '$nome',
					emailResponsavel = '$email',
					senhaResponsavel = '$senha'
				WHERE idUsuario = ".$_SESSION['usuario'];
			$resultado = $oMysql->query($query);
			$_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Perfil editado'];
		    $fallback = "../FRONT/index.html";
            $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
            header("Location: $anterior");
            exit;
		}



#PROFESSOR

		if(isset($_POST['nomeProfessor']) && isset($_POST['emailProfessor']) && isset($_POST['senhaProfessor'])){
			$oMysql = conecta_db();
			$nome = $_POST['nomeProfessor'];
			$email = $_POST['emailProfessor'];
			$senha = password_hash($_POST['senhaProfessor'], PASSWORD_DEFAULT);
			$query = "UPDATE tb_professor 
				SET nomeProfessor = '$nome',
					emailProfessor = '$email',
					senhaProfessor = '$senha'
				WHERE idUsuario = ".$_SESSION['usuario'];
			$resultado = $oMysql->query($query);
			$_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Perfil editado'];
		    $fallback = "../FRONT/index.html";
            $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
            header("Location: $anterior");
            exit;
		}

#COORDENADOR

		if(isset($_POST['nomeCoordenador']) && isset($_POST['emailCoordenador']) && isset($_POST['senhaCoordenador'])){
			$oMysql = conecta_db();
			$nome = $_POST['nomeCoordenador'];
			$email = $_POST['emailCoordenador'];
			$senha = password_hash($_POST['senhaCoordenador'], PASSWORD_DEFAULT);
			$query = "UPDATE tb_coordenador 
				SET nomeCoordenador = '$nome',
					emailCoordenador = '$email',
					senhaCoordenador = '$senha'
				WHERE idUsuario = ".$_SESSION['usuario'];
			$resultado = $oMysql->query($query);
			$_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Perfil editado'];
		    $fallback = "../FRONT/index.html";
            $anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
            header("Location: $anterior");
            exit;
		}
?>