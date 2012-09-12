<?php
mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');	

$q_motd="select value from config where attrib='motd'";
$r_motd=mysql_query($q_motd);
$motd=mysql_result($r_motd,0,'value');
?>
<br>
<center>
<table id="hor-minimalist-b" summary="motd">
    <tbody>
				<tr>
					<td align="center"> <FONT color ="red" size="5"><?php echo $motd?></font></td>
				</tr>
    </tbody>
</table>
					<?php
						//
						//require("verificar_horas.php"); //chama o ficheiro com a funcao para verificar se hoje ja foram registadas horas
							include('verificar_registo.php');
						// desactivado
					?>
</center>
<?php
	$q_mov_horas="SELECT * FROM mov_viatura JOIN viaturas ON mov_viatura.id_viatura=viaturas.id_viatura WHERE  id_funcionario='".$_COOKIE['id_funcionario']."' ORDER BY mov_viatura.data DESC LIMIT 4";
	$r_mov_horas=mysql_query($q_mov_horas);
	$n_mov_horas=mysql_num_rows($r_mov_horas);
	
//popups dos ultimos registos
for($i=0;$i<$n_mov_horas;$i++){
	?>
		<!-- POP-UP -->
		<div id='<?php echo $i?>' name='<?php echo $i?>' style='position: absolute; width: 500px; height: 400px; display: none; background: #666666; border: 1px solid #000; right: 0px; top: 500px'>
			<!--BEGIN CONTEUDO POP-UP DETALHES-->
				<form>
					<center><font class="popup_texto">Detalhes do registo</font></center>
					<br>
					<input type="text" onchange="procurar(this.value);"></input>
					<button onclick="fechar();">Fechar</button>
				</form>
			<!--END CONTEUDO POP-UP DETALHES-->
		</div> 
		<!-- FIM POP-UP -->
	<?php
}
?>