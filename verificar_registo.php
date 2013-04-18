<script type='text/javascript'>
//abrir a popup calculando a sua posicao
function popup(n) {
	var nome=n;
  document.getElementById(nome).style.top = 150;
  document.getElementById(nome).style.left = (document.body.clientHeight/2);
  document.getElementById(nome).style.display = "block";
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

//apagar os registos do dia
function apagar(id,tipo){
	var texto = "Deseja apagar o registo "+id+" ?";
	var url = "apagar.php?tipo="+tipo+"&id="+id;
	var answer = confirm(texto);
	if(answer)
		window.location=url;			
}

function alterar_data(){
	var dt = document.getElementById("data_registo").value
	window.location="index.php?data="+dt;
}
</script> 
<?php

$data_sql=$_GET['data']; //variavel de data a usar nas querys sql

if(!isset($data_sql)){
	$data_sql=date('Y/m/j');
	$dm=date('j/m/Y');
}else{
	$datas=explode("/",$data_sql);
	$data_sql=$datas[2]."/".$datas[1]."/".$datas[0];
	$dm=$_GET['data'];
}

echo '<table><tr>'; //calendario
echo '<td align="center"><form><input onchange="alterar_data()" style="text-align:center;font-size:30px;"class="ui-widget" type="text" id="data_registo" size=10 value="'.$dm.'"></form></td>'; //mostra data
echo '</tr></table>';

//QUERYS ///////////////////////////////////////////
	$q_mov_horas="SELECT mov_viatura.id_movviatura as 'id', time(data) as 'data',mov_viatura.horas_viatura,viaturas.desc_viatura,viaturas.tipo_viatura FROM mov_viatura JOIN viaturas ON mov_viatura.id_viatura=viaturas.id_viatura WHERE  id_funcionario='".$_COOKIE['id_funcionario']."' AND date(mov_viatura.data)='".$data_sql."' ORDER BY mov_viatura.data DESC LIMIT 10";
	$r_mov_horas=mysql_query($q_mov_horas);
	$n_mov_horas=mysql_num_rows($r_mov_horas);
	
	$q_mov_combustivel="SELECT mov_combustivel.id_movcombustivel as 'idc',time(mov_combustivel.data) as 'data',mov_combustivel.kms_viatura,mov_combustivel.valor_movimento,viaturas.desc_viatura,viaturas.tipo_viatura FROM mov_combustivel JOIN viaturas ON mov_combustivel.id_viatura=viaturas.id_viatura WHERE mov_combustivel.id_funcionario='".$_COOKIE['id_funcionario']."' AND date(mov_combustivel.data)='".$data_sql."' AND mov_combustivel.valor_movimento > 0 ORDER BY mov_combustivel.data DESC LIMIT 3";
	$r_mov_comb=mysql_query($q_mov_combustivel);
	$n_mov_comb=mysql_num_rows($r_mov_comb);
	
	$q_mov_avarias="SELECT mov_avarias.id_avaria as 'ida', time(data) as 'data', mov_avarias.categoria, mov_avarias.preco, viaturas.desc_viatura, viaturas.tipo_viatura FROM mov_avarias JOIN viaturas ON mov_avarias.id_viatura=viaturas.id_viatura WHERE mov_avarias.id_funcionario='".$_COOKIE['id_funcionario']."' AND date(mov_avarias.data)='".$data_sql."' ORDER BY mov_avarias.data DESC LIMIT 3";
	$r_mov_avarias=mysql_query($q_mov_avarias);
	$n_mov_avarias=mysql_num_rows($r_mov_avarias);
	

//desenhar as linhas na tabela dos ultimos registos	
?>
<table id="hor-minimalist-b" summary="motd">
    <tbody>
<?php 
for($i=0;$i<$n_mov_horas;$i++){
	if(mysql_result($r_mov_horas,$i,'mov_viatura.horas_viatura')>0){
?>

<tr>
	<td>
		<?php echo '<img src="'.$IMG_CAMIAO.'" height=20>'?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_horas,$i,'data')?>
	</td>
	<td>
		<?php 
			$t_minutos=mysql_result($r_mov_horas,$i,'mov_viatura.horas_viatura');
			$t_horas=intval($t_minutos/60);
			$t_min=$t_minutos-($t_horas*60);
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
		<?php echo categoria_veiculo(mysql_result($r_mov_horas,$i,'viaturas.tipo_viatura'));?>
	</td>
	<td>
		<?php echo '<input type="image" onclick="apagar('.mysql_result($r_mov_horas, $i,'id').',0)" src="apagar.png">'?>
	</td>	
</tr>
<?php
	}
}
?>
    </tbody>
</table>
<!-- //////////////////////////////////////////////////////// TABELA DO COMBUSTIVEL  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
<table id="hor-minimalist-b" summary="motd">
    <tbody>
<?php 
for($i=0;$i<$n_mov_comb;$i++){
	if(mysql_result($r_mov_comb, $i,'valor_movimento')>0){
?>
<tr>
	<td>
		<?php echo '<img src="'.$IMG_GASOLEO.'" height=20>'?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_comb,$i,'data')?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_comb, $i,'valor_movimento')." L"?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_comb, $i,'kms_viatura')." H/KMs"?>
	</td>		
	<td>
		<?php echo mysql_result($r_mov_comb,$i,'viaturas.desc_viatura')?>
	</td>
	<td>
		<?php echo categoria_veiculo(mysql_result($r_mov_comb,$i,'viaturas.tipo_viatura'));?>
	</td>
	<td>
		<?php echo '<input type="image" onclick="apagar('.mysql_result($r_mov_comb, $i,'idc').',1)" src="apagar.png">'?>
	</td>	
</tr>
<?php
	}
}
?>
    </tbody>
</table>
<!-- ///////////////////////////////////////////////////////TABELA DAS AVARIAS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
<table id="hor-minimalist-b" summary="motd">
    <tbody>
<?php 
for($i=0;$i<$n_mov_avarias;$i++){
?>

<tr>
	<td>
		<?php echo '<img src="'.$IMG_OFICINA.'" height=20>'?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_avarias,$i,'data')?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_avarias, $i,'desc_viatura')?>
		
	</td>	
	<td>
		<?php echo categoria_veiculo(mysql_result($r_mov_avarias,$i,'viaturas.tipo_viatura'));?>
	</td>
	<td>
		<?php echo mysql_result($r_mov_avarias,$i,'categoria')?>
	</td>
	<td>
		<?php echo "€ ".mysql_result($r_mov_avarias,$i,'preco')?>
	</td>
	<td>
		<?php echo '<input type="image" onclick="apagar('.mysql_result($r_mov_avarias, $i,'ida').',2)" src="apagar.png">'?>
	</td>	
</tr>
<?php
}
?>
    </tbody>
</table>