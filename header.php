<?php
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	mysql_select_db($DB_TABLE);
	$query_funcs="select * from funcionario where id_funcionario=".$_COOKIE['id_funcionario'];
	$funcs=mysql_query($query_funcs);
	mysql_close();
?>
<div class="ui-widget-content ui-corner-all " id="header">
	<table class="tb_header">
	<tr>
		<td class="td_header">
			<?php
				echo '<b>Funcionario:</b> '.mysql_result($funcs,0,"nome_funcionario");
				echo '<br><b>Status:</b> '.mysql_result($funcs,0,"estado");
			?>
		</td>
		<td class="td_header" align="center">
			<?php
			//mostrar data
			echo '<b>Data:</b> '.date('d-m-Y')."<br>";
			echo '<b>Hora:</b> '.date(G).':'.date(i).':'.date(s);
			?>
		</td>
		<td class="td_header" align="right">
			<a href="./index.php"><img src="<?php echo $IMG_INICIO; ?>" border=0></a>
		</td>
		<td class="td_header" align="right">
			<a href="./index.php?accao=sair"><img src="<?php echo $IMG_SAIR; ?>" border=0></a>
		</td>
	</tr>
	</table>
</div>
<button class="fg-button ui-state-default ui-corner-all" type="button" id="but_header">Menu Superior<br>BETA</button>