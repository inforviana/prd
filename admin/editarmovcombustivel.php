<?php
	$id=$_GET['id'];
	@$guardar=$_GET['guardar'];
	@$idv=$_GET['idv'];
	if($guardar==1){
		$valor=$_POST['valor'];
		$kms=$_POST['kms'];
		$novo=$_GET['novo'];
		$data_n=$_POST['data'];
		$funcionario=$_POST['funcionario'];
		$viatura=$_POST['viatura'];
		
		
		if(isset($novo)&&$novo!=1){
			$q_guardar="UPDATE mov_combustivel SET id_viatura=".$viatura." ,id_funcionario=".$funcionario." ,data='".$data_n."', kms_viatura=".$kms." ,valor_movimento='".$valor."' where id_movcombustivel=".$id;
		}

		if(mysql_query($q_guardar)){
			$msg= 'Altera��es salvas com sucesso!';
		}else{
			$msg='Erro ao gravar as altera��es!\n'.$q_guardar;
		}
		echo '
		<script type="text/javascript">
			alert("'.$msg.'");
			window.location="index.php?pagina=listagemcombustivel&idviatura='.$idv.'";
		</script>
		';
	}

	//querys
	$q_mc="select * from mov_combustivel where id_movcombustivel=".$id;
	$r_mc=mysql_query($q_mc);
	$n_mc=mysql_num_rows($r_mc);
	
	$q_f="select * from funcionario order by nome_funcionario";
	$r_f=mysql_query($q_f);
	$n_f=mysql_num_rows($r_f);
	
	$q_v = "select * from viaturas order by desc_viatura";
	$r_v = mysql_query($q_v);
	$n_v = mysql_num_rows($r_v);
	
	
	//desenhar a pagina
	echo '<table id="hor-minimalist-b" summary="motd"><thead><th>EDITAR MOVIMENTO DE COMBUSTIVEL '.@$id.'</th></thead><tbody><tr></tr><tr><td><form method="POST" action="index.php?pagina=editarcomb&id='.$id.'&guardar=1&idv='.mysql_result($r_mc,0,'id_viatura').'&novo='.@$novo.'">
	Funcionario: <select name="funcionario">';
					for($i=0;$i<$n_f;$i++){
						//verifica se � o funcionario do registo
						if((mysql_result($r_mc,0,'id_funcionario'))==mysql_result($r_f,$i,'id_funcionario')){
							$selected='selected="selected"';
						}else{
							$selected="";
						}
						echo '<option value="'.mysql_result($r_f,$i,'id_funcionario').'" '.$selected.'>'.mysql_result($r_f,$i,'nome_funcionario').'</option>';
					}
	
	//combo das viaturas
	echo'		</select><br><br>
		Viatura: <select name="viatura">';
					for($i=0;$i<$n_v;$i++){
						//verifica se � a viatura do registo
						if((mysql_result($r_mc,0,'id_viatura'))==mysql_result($r_v,$i,'id_viatura')){
							$selected='selected="selected"';
						}else{
							$selected="";
						}
						echo '<option value="'.mysql_result($r_v,$i,'id_viatura').'" '.$selected.'>'.mysql_result($r_v,$i,'desc_viatura').' - '.mysql_result($r_v,$i,'marca_viatura').' '.mysql_result($r_v,$i,'modelo_viatura').'</option>';
					}
	echo'		</select><br><br>	
	
	Data: <input type="text" size=20 name="data" value="'.mysql_result($r_mc,0,'data').'"><br>
	Horas/Kilometros: <input type="text" size=10 name="kms" value="'.mysql_result($r_mc,0,'kms_viatura').'"><br>
	Litros:<input type="text" size=3 name="valor" value="'.mysql_result($r_mc,0,'valor_movimento').'">
		<br><br>';
	echo '</td></tr><tr><td align="right">'.@$msg.'<br><button type="submit">Guardar Altera��es</button></form></td></tr></tbody></table>';
?>