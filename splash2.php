<?php
mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');	

$q_motd="select value from config where attrib='motd'";
$r_motd=mysql_query($q_motd);
$motd=mysql_result($r_motd,0,'value');
?>
<br>
<center>
<p class="p_motd">
<?php
	if(date(H)<12){
		echo "Bom dia ".$_COOKIE['nome_funcionario'];
	}else{
		echo "Boa tarde ".$_COOKIE['nome_funcionario'];
	}
?>
</p>
<table id="hor-minimalist-b" summary="motd">
    <thead>
    	<tr>
        	<th scope="col">Mensagem Interna</th>
        </tr>
    </thead>
    <tbody>
				<tr>
					<td> <FONT color ="red" size="5"><?php echo $motd?></font></td>
				</tr>
    </tbody>
</table>
<table id="hor-minimalist-b" summary="motd">
    <thead>
    	<tr> <!-- LISTAGEM FERIAS E AVISOS -->
        	<th scope="col">A sua informação</th>
        </tr>
    </thead>
    <tbody>
				<tr>
					<td>Férias não agendadas</td>
				</tr>
				<tr>
					<td>
					<?php
						//
						//require("verificar_horas.php"); //chama o ficheiro com a funcao para verificar se hoje ja foram registadas horas
						// desactivado
					?>
					</td>
				</tr>
    </tbody>
</table>
<table id="hor-minimalist-b" summary="motd">
    <thead>
    	<tr > <!-- LISTAGEM MOVIMENTOS DO DIA ANTERIOR -->
        	<th colspan="2" scope="col">Ultimos Registos</th>
        </tr>
    </thead>
    <tbody>
					<?php
						//
						//require("verificar_horas.php"); //chama o ficheiro com a funcao para verificar se hoje ja foram registadas horas
						include('verificar_registo.php');
						// desactivado
					?>
    </tbody>
</table>
</center>
<!-- POP-UP -->
<div id='mypopup' name='mypopup' style='position: absolute; width: 500px; height: 400px; display: none; background: #666666; border: 1px solid #000; right: 0px; top: 500px'>
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