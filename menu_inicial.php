<table class="tb_menu_inicial" align="center">
	<tr>
		<td class="td_menu1">
		<?php
			//MENU LATERAL
			//echo '<a href="index.php?pagina=combustivel"><img width="200" src="botao_menu_1.png" border=0></a>';
			//echo '<a href="index.php?pagina=registo"><img  width="200" src="botao_menu_2.png" border=0></a>';
			$r_func=mysql_query("select nome_funcionario from funcionario where id_funcionario=".$_COOKIE["id_funcionario"]);
			echo '<a href="./index.php"><img class="img_func" src="./img/semimagem.jpg"></a><br><font class="txt_func">'.mysql_result($r_func,0,0).'</font><br><br>';
			echo '<button style="font-size:30px;width:220px;height:100px" class="fg-button ui-state-default ui-corner-all" id="but_registodiario">Registo Diario</button><br>';
			echo '<button style="font-size:30px;width:220px;height:100px" class="fg-button ui-state-default ui-corner-all" id="but_oficina">Outros Servicos</button><br>'; 
			echo '<button style="font-size:30px;width:220px;height:100px" class="fg-button ui-state-default ui-corner-all" id="but_defs">Oficina</button><br><br>';
			echo "<a href=\"./index.php?accao=sair\"><img src=\"$IMG_SAIR\" border=0></a>";
			echo '<br>PRD 2012<br><font style="font-size:12px">Versão '.$VERSAO.'</font>';
			//echo '<a href="index.php?pagina=oficina"><img  width="200" src="botao_menu_3.png" border=0></a>';
			//echo '<a href="index.php?pagina=opcoes"><img  width="200" src="botao_menu_4.png" border=0></a>';
		?>
				
				
		</td>	
		<td class="td_menu2">
			<?php //CONTEUDO PRINCIPAL /////////
				$pagina=$_GET['pagina'];
				if(isset($pagina)) { //verifica se estamos na pagina inicial ou não :)
					switch($pagina){
						case "combustivel": //seleccionar viatura para bastecer
                                                                                                                                require("sel_viatura.php");
                                                                                                                                break;
						case "abastecer": // abastecer combustivel
                                                                                                                                require("combustivel.php");
                                                                                                                                break;
						case "registo": //REGISTO DIARIO
                                                                                                                                require("sel_viatura.php");
                                                                                                                                break;
						case "horas": //REGISTO DE HORAS
                                                                                                                                require("horas.php");
                                                                                                                                break;
						case "avarias": //AVARIAS
						                    require("avarias.php");
                                                                                                                                break;
						case "oficina": //oficina
                                                                                                                                break; 
						case "opcoes": //opções do funcionario
							require("opcoes.php");
						break;
						case "perfil":
							require("perfil.php");
						break;
					}
				} else {
					//alarmes e motd
					require("splash.php");
				}
			?>
		</td>
	</tr>
</table>