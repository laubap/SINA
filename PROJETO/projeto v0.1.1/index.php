<?php
		include 'biblioteca.php';
		include 'header.php';
		include 'conecta_db.php';
		if(isset($_GET['page'])){
			if($_GET['page'] == 1){
				include 'insert.php';
				
			}else if($_GET['page'] == 2){
				include 'update.php';
				
			}else if($_GET['page'] == 3){
				include 'delete.php';
				
			}else{
				include 'main.php';
			}
		}else{
			include 'main.php';
		}
?>