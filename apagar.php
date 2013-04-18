<?php 
	include 'config.php';
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');	
?>
<script type="text/javascript">
	function abrir(){
		window.location="index.php";
	}
</script>
<?php
$tipo=$_GET['tipo'];
$id=$_GET['id'];

if ($tipo==0){
	$q_apagar="delete from mov_viatura where id_movviatura=".$id;
}elseif ($tipo==1){
	$q_apagar="delete from mov_combustivel where id_movcombustivel=".$id;
}elseif ($tipo==2){
	$q_apagar="delete from mov_avarias where id_avaria=".$id;
}

mysql_query($q_apagar);
?>
<script type="text/javascript">
	abrir();
</script>