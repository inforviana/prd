<?php
//obter pin da pagina de login
$pin_g=$_GET['pin'];
if (isset($pin_g)){
	$pin=$pin_g;  
} else { 
	$pin=$_POST['pin'];
}

//ligar á base de dados
mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
//seleccionar a tabela a utilizar
@mysql_select_db($DB_TABLE) or die('Erro de ligação á base de dados!');

//query sql para verficiar o utilizador a partir do pin
$query_login="select * from funcionario where pin_funcionario=".$pin;
//executar a query
$dados=mysql_query($query_login);

$num=mysql_numrows($dados);
//fechar o acesso á base de dados
mysql_close();

//verificar utilizador e preencher variaveis
if($num>0)
{
	//$nome_funcionario=mysql_result($dados,0,"nome_funcionario");
	//$id_funcionario=mysql_result($dados,0,"id_funcionario");
	require("header.php");
	require("menu_inicial.php");
} else {
	//PIN INCORRECTO
	echo "Nenhum funcionario encontrado com esse PIN!";
	echo '<br><br><a class="a_1" href="index.php">Tentar Novamente</a>';
}
?>