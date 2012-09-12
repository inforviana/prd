<script type='text/javascript'>
//abrir a popup calculando a sua posicao
function popup() {
  document.getElementById("mypopup").style.top = 150;
  document.getElementById("mypopup").style.left = (document.body.clientHeight/2);
  document.getElementById("mypopup").style.display = "block";
}

//funcao para fechar a popup
function fechar(){
	document.getElementById("mypopup").style.display="none";
}

//funcao para enviar a viatura seleccionada de volta ao form de transporte
function enviar(v){
	var texto=v;
	document.getElementById("litros").value=texto;
}

//procurar e mostrar as viaturas que correspondam aos criterios
function procurar(t){
	
}
</script> 
<?php
	$q_mov_horas="SELECT * FROM mov_viatura JOIN viaturas ON mov_viatura.id_viatura=viaturas.id_viatura WHERE  id_funcionario='".$_COOKIE['id_funcionario']."' ORDER BY mov_viatura.data DESC LIMIT 4";
	$r_mov_horas=mysql_query($q_mov_horas);
	$n_mov_horas=mysql_num_rows($r_mov_horas);
	
for($i=0;$i<$n_mov_horas;$i++){
?>
<tr>
	<td>
		<?php echo mysql_result($r_mov_horas,$i,'data')?>
	</td>
	<td>
		<?php 
			$t_minutos=mysql_result($r_mov_horas,$i,'mov_viatura.horas_viatura');
			$t_horas=$t_minutos/60;
			$t_min=$_minutos%60;
			if($t_min=="0"){
				$t_min="00";
			}
			echo $t_horas.":".$t_min." H";
		?>
		
	</td>	
	<td>
		<?php echo mysql_result($r_mov_horas,$i,'viaturas.desc_viatura')?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_horas,$i,'viaturas.tipo_viatura')?>
	</td>
	<td>
		<?php echo '<input onclick="popup()" type="image" src="editar.png">'?>
	</td>
	<td>
		<?php echo '<input type="image" src="apagar.png">'?>
	</td>	
</tr>
<?php
}
?>