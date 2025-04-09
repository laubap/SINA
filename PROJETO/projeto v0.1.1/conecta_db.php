<?php
	function conecta_db(){
		$db_name = "db_teste";
		$user	 = "root";
		$pass    = "12345678";
		$server  = "localhost:3306";
		$conexao = new mysqli($server, $user, $pass, $db_name);
		
		return $conexao;
	}
?>