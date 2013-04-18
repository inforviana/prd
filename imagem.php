<?php
	header("Content-type: image/jpeg");
	
	require('config.php'); //carregar variaveis globais
	//ligar с base de dados
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	//seleccionar a tabela a utilizar
	mysql_select_db($DB_TABLE) or die('Erro de ligaчуo с base de dados!');
	
	$imgid=$_GET['idviatura'];
	
	$q="select img from viaturas where id_viatura=".$imgid;
	
	$r=mysql_query($q);
	$img=mysql_result($r,0);
	
	if(strlen($img)<100)
	{
		$r=mysql_query("select value_img from config where attrib='sem_imagem'");
		$img=mysql_result($r,0);
	}
	
	echo $img;
?>