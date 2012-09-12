<?php
	setcookie("id_funcionario","",time()-3600); //eliminar as cookies
	setcookie("nome_funcionario","",time()-3600);
	$id = $_GET['funcionario']; //criar novas
	$nome = $_GET['nome'];
	
	setcookie('id_funcionario',$id);
	setcookie('nome_funcionario',$nome);
	
	echo '<img src="graph.php">';
?>