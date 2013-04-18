<?php
$kms=$_POST['kms']; //variaveis globais
$litros=$_POST['litros'];
$viat=$_GET['viatura'];

	if(!isset($kms)){ //verifica se ja tem os dados para abastecimento ou nao
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');
	$q_abviat="select * from viaturas where id_viatura=".$viat;
	$r_abviat=mysql_query($q_abviat);
	?>
	<br>
	<center>
	<table id="hor-minimalist-b" summary="motd">
		<thead>
			<tr>
				<th>ABASTECER VIATURA</th>
			</tr>
			<tr>
				<th scope="col">Imagem</th>
				<th scope="col">Nome</th>
				<th scope="col">Matricula</th>
				<th scope="col">Marca</th>
				<th scope="col">Modelo</th>
			</tr>
			
		</thead>
		<tbody>
					<tr>
						<td><img width="100" src=" <?php echo mysql_result($r_abviat,0,'imagem_viatura')?>"></td>
						<td> <?php echo mysql_result($r_abviat,0,'desc_viatura')?></td>
						<td> <?php echo mysql_result($r_abviat,0,'matricula_viatura')?></td>
						<td> <?php echo mysql_result($r_abviat,0,'marca_viatura')?></td>
						<td> <?php echo mysql_result($r_abviat,0,'modelo_viatura')?></td>
					</tr>
		</tbody>
	</table>
	</center>
	<?php echo '<form action="index.php?pagina=abastecer&viatura='.$viat.'" method="POST" name="abast_viat">'; ?>
		<b><font color="black">LITROS:</font></b><br><input style="font-size: 60px;" class="keyboardInput"  type="text" name="litros" maxlength="" size="6"><br>
		<b><font color="black">H/KM:</font></b><br><input style="font-size: 60px;" class="keyboardInput"  type="text" name="kms" maxlength="" size="6"><br>
		<center><br><button class="pesquisa_btn" type="submit" style="height: 100px; width: 300px">Abastecer</button></center>
	</form>
	<?php
	} else {
		mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
		mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');	
		$q_abast="insert into mov_combustivel (id_funcionario,id_viatura,id_combustivel,data,tipo_movimento,valor_movimento,kms_viatura) values (".$_COOKIE['id_funcionario'].",".$viat.",'0','".date('Y-m-d H:i:s')."','S',".$litros.",".$kms.")";
		
		if(!mysql_query($q_abast)) {
		echo "erro"; //em caso de erro ao inserir na bd
		}else{
		 require("splash.php");
		}
	}
?>