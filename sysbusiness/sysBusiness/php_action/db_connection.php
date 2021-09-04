<?php

	try{
		$pdo=new PDO('mysql:host=143.106.241.3;dbname=cl19592','cl19592','cl*19032004');
	}
	catch(PDOException $e){
		$erroDBConnection="Não foi possível conectar ao banco de dados";
	}

?>