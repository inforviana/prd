<?php
	@$apagar=$_GET['apagar'];
	@$id=$_GET['id'];
	if($apagar==1){
		$q_apagar="DELETE FROM funcionario WHERE id_funcionario=".$id;
		if (mysql_query($q_apagar)){
			$msg= '<font class="font_titulo"><img src="ok.gif">Funcionario apagado com sucesso!</font>';
		}else{
			$msg='<font class="font_titulo_erro"><img src="erro.gif">Erro ao gravar as altera��es!</font>';
		}
	}
	@$p_funcionarios=$_POST['procura'];
	$q_funcionarios="select * from funcionario where nome_funcionario like '%".$p_funcionarios."%' order by nome_funcionario asc"; //query para seleccionar todos os funcionarios
	$r_funcionarios=mysql_query($q_funcionarios);
	$n_funcionarios=mysql_num_rows($r_funcionarios);
	
	echo '<table width=700><tr><td>'.@$msg.'<br><b><img src="funcionario.gif">Funcionarios</b></td>';
	echo '<td align="right"><form method="POST" action="index.php?pagina=funcionarios"></td><td><input type="text" name="procura"><input type="image" src="lupa.gif" value="Procurar" alt="Procurar"></form></td></tr>
	</table><br><a href="index.php?pagina=editarfuncionario&novo=1"><img src="novo.gif" border=0><font class="font_novo">Adicionar Funcionario</font></a>';
	
	echo '<table id="hor-minimalist-b" summary="motd"><tbody>';
	//inicio do loop de preenchimento da tabela de funcionarios
	for($i=0;$i<$n_funcionarios;$i++){
		echo '<tr>';
			echo '<td align="center"><a href="index.php?pagina=editarfuncionario&id='.mysql_result($r_funcionarios,$i,'id_funcionario').'" class="botao_detalhes">Detalhes</a></td>';
			echo '<td>'.mysql_result($r_funcionarios,$i,'nome_funcionario').'</td>';
			echo '<td>'.mysql_result($r_funcionarios,$i,'grupo_funcionario').'</td>';
			echo '<td>'.mysql_result($r_funcionarios,$i,'estado').'</td>';
			echo '<td><a href="index.php?pagina=listagemcombustivel&idfuncionario='.mysql_result($r_funcionarios,$i,'id_funcionario').'"><img height=16 src="gasoleo.png" border=0></a></td>';
			echo '<td><a href="index.php?pagina=listagemavarias&idfuncionario='.mysql_result($r_funcionarios,$i,'id_funcionario').'"><img src="avarias.gif" border=0></a></td>';
			echo '<td><a href="index.php?pagina=listagemhoras&idfuncionario='.mysql_result($r_funcionarios,$i,'id_funcionario').'"><img src="grafico.gif" border=0></a></td>';
			echo '<td><input type="image" onclick="apagar(\'index.php?pagina=funcionarios&apagar=1&id='.mysql_result($r_funcionarios,$i,'id_funcionario').'\')" src="delete.gif"></td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
?>