<?php
//
//sel_viatura.php
//
$pagina_v=$_GET['paginav']; //numero da pagina da pesquisa

if(isset($pagina_v)){
	$p_viat=$_GET['viatura']; //obtem desc da viatura a pesquisar
}else{
	$p_viat=$_POST['p_viat']; //obtem string a pesquisar nas viaturas
}

if($p_viat=="Pesquisa"){$p_viat="";}//verifica se o valor não é pesquisa na mesma

if(isset($pagina_v)){ 
	$p_cat=$_GET['categoria']; 
}else{
	$p_cat=$_POST['categoria']; //categorias a pesquisar
}


	mysql_connect($DB_HOST,$DB_USER,$DB_PASS); //LIGACAO A BD
	mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');

if (isset($p_viat)||isset($p_cat)){ //verifica se é ou nao para pesquisar 
	//(select * from viaturas where tipo_viatura like '%".$p_cat."%')as vcat
	 $q_viat="select * from (select * from viaturas where acessorio=0 and tipo_viatura like '%".$p_cat."%')as vcat where modelo_viatura like '%".$p_viat."%' or desc_viatura like '%".$p_viat."%' or matricula_viatura like '%".$p_viat."%' or marca_viatura like '%".$p_viat."%'";//query para pesquisar as viaturas mediante determinados parametros
	 $r_viat=mysql_query($q_viat);
	 $c_viat=mysql_num_rows($r_viat);
}
?> 
	<br>
	<center>
		<?php
			//pagina do combustivel ficou sem efeito mas manteve-se a condição para uso futuro
			if ($pagina=='combustivel') {
				echo '<form action="index.php?pagina=combustivel" method="POST" name="p_viat">';
			}else{
				echo '<form action="index.php?pagina=registo" method="POST" name="p_viat">';
			}
		?>
			<center>
				<?php //echo '<a href="index.php?pagina=horas&serv=Serviço Externo"><img height=60 border=0 src="'.$IMG_SERVICO_EXTERNO.'"></a>';?>
				<?php //echo '<a href="index.php?pagina=horas&serv=Ajudante"><img height=60 border=0 src="'.$IMG_SERVICO_AJUDANTE.'"></a>';?>
				<?php //echo '<a href="index.php?pagina=horas&serv=Sem Serviço"><img height=60 border=0 src="'.$IMG_SERVICO_SEM.'"></a>';?>
			</center>
			<!--			
			<select onchange="abrir_url(this.value)" name="categoria" class="option_categorias" >

			<option value="">Tipo Serviço</option>
			<?php
				//PREENCHER COMBO DAS CATEGORIAS
				$q_cat="select categoria from categorias_viatura order by categoria";
				$r_cat=mysql_query($q_cat);
				$n_cat=mysql_numrows($r_cat);
				for($i==0;$i<$n_cat;$i++){
					if(mysql_result($r_cat,$i,0)==$p_cat){
						echo '<option selected="selected" value="'.mysql_result($r_cat,$i,0).'">'.mysql_result($r_cat,$i,0).'</option>';
					}else{
						echo '<option value="'.mysql_result($r_cat,$i,0).'">'.mysql_result($r_cat,$i,0).'</option>';
					}
				}
			?>
			</select>-->
			<table><tr><td>
			<input style="font-size: 30px;text-align: center;"  placeholder="Pesquisa"  onclick="this.value='';" type="text" name="p_viat" id="p_viatura" maxlength="" size="10"/><br></td><td>
			<button class="ui-button" type="submit" style="font-size:30px ;height: 55px; width: 140px">Procurar</button></td></tr></table>
		</form>
		<table id="hor-minimalist-b" summary="viaturas">
			<thead>
				<tr >
					<th COLSPAN="6">
					<?php //cabeçalho da pesquisa de viaturas
						 switch ($pagina){
							case "combustivel":
							echo "SELECCIONE VIATURA A ABASTECER";
							break;
							case "registo";
							echo "SELECCIONE VIATURA A REGISTAR HORAS";
							break;
						 }
				
					?></th>
				</tr>
				<tr><!-- titulo dos detalhes da viatura -->
					<th scope="col">Foto</th>
					<th scope="col">Desc</th>
					<th scope="col">Marca</th>
					<th scope="col">Modelo</th>
					<th scope="col">Matricula</th>
					<th scope="col">Tipo</th>
				</tr>
			</thead>
			<tbody>

				<?php
					for($i=0;$i<$c_viat;$i++){ //resultados da pesquisa de viaturas
						if($i==$MAX_VIATURAS||($i+(4*$pagina_v))==$c_viat){break;} 

						?>
						<tr>
							<td>
								<?php
								if($pagina_v<0){
									$pagina_v=0;
								}
									if ($pagina=='combustivel') {	//imagem e link para a viatura e operação a efectuar
										echo '<a href="index.php?pagina=abastecer&viatura='.mysql_result($r_viat,$i+(4*$pagina_v),'id_viatura').'"><img  class="sel_viat"  src="imagem.php?idviatura='.mysql_result($r_viat,$i,'id_viatura').'"></a>';
									}else{
										echo '<a href="index.php?pagina=horas&viatura='.mysql_result($r_viat,$i+(4*$pagina_v),'id_viatura').'"><img  class="sel_viat"  src="imagem.php?idviatura='.mysql_result($r_viat,$i+(4*$pagina_v),'id_viatura').'"></a>';
									}
								?>
							</td> <!-- detalhes da viatura -->
							<td> <?php echo mysql_result($r_viat,$i+(4*$pagina_v),'desc_viatura');?></td>
							<td> <?php echo mysql_result($r_viat,$i+(4*$pagina_v),'marca_viatura');?></td>
							<td> <?php echo mysql_result($r_viat,$i+(4*$pagina_v),'modelo_viatura');?></td>
							<td> <?php echo mysql_result($r_viat,$i+(4*$pagina_v),'matricula_viatura');?></td>
							<td> 
                                                            <?php 
                                                                $q_tipo="select categoria from categorias_viatura where id_categoria=".mysql_result($r_viat,$i+(4*$pagina_v),'tipo_viatura');
                                                                $r_tipo=mysql_query($q_tipo);
                                                                echo mysql_result($r_tipo,0,0);
                                                            ?>
                                                       </td>
						</tr>
						<?php
					}
				?>
			</tbody>
		</table>
		<?php
			//SEM RESULTADOS
			if($c_viat==0){echo '<font color="black"><h1>Sem Resultados</h1></font>';}
			
			$paginas=intval($c_viat/4); //descobrir o numero de paginas a apresentar
			if(($c_viat%4)>0){$paginas+=1;}
			
			echo "<table><tr>"; //desenhar os botoes de pagina e numeros
/*			echo "pagina_v:".$pagina_v."<br>";
			echo "paginas:".$paginas;*/
			
			if($pagina_v >= 0){
				$botao_esquerda = '<td><a href="index.php?pagina=registo&paginav='.($pagina_v-1).'&viatura='.$p_viat.'&categoria='.$p_cat.'"><img border=0 height="70" src="seta_esquerda.png")></a></td>';
				$botao_direita = '<td><a href="index.php?pagina=registo&paginav='.($pagina_v+1).'&viatura='.$p_viat.'&categoria='.$p_cat.'"><img border=0 height="70" src="seta_direita.png")></a></td>';				
			}
			
			if($paginas > 1){ //se existir mais de uma pagina
				if($pagina_v >= 1){ //botao avancar para a esquerda
					echo $botao_esquerda;
				}
			}
			
/*			for($z=1;$z<=$paginas;$z++) //desenhar os numeros de paginas
			{
				//echo '<td><font class="popup_texto"><a href="index.php?pagina=registo&paginav='.($z-1).'&viatura='.$p_viat.'&categoria='.$p_cat.'">'.$z.'</a></font></td>';
			}*/
			
			echo "<td><p class=\"paginas\">Página <b>".($pagina_v+1)."</b> de <b>".$paginas."</p></b></td>";
			
			if($paginas > 1){ //se existir mais de uma pagina
				if(($pagina_v+1)<$paginas){
					echo $botao_direita;
				}
			}

			
			echo "</tr></table>";
		?>
	</center>