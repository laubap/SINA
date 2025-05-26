<?php
	function conecta_db(){
		$db_name = "sina";
		$user	 = "root";
		$pass    = "";
		$server  = "localhost:3306";
		$conexao = new mysqli($server, $user, $pass, $db_name);
		
		if ($conexao->connect_error) {
			return false;
		}


		return $conexao;
	}
?>