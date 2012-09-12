<?php
	if(!isset($viat)){ /* OBTEM A VIATURA A ADICIONAR AVARIA */
		$viat=$_GET['viatura'];
	}
	
	
	mysql_connect($DB_HOST,$DB_USER,$DB_PASS); //pesquisar detalhes da viatura
	mysql_select_db($DB_TABLE) or die ('Erro de ligação á base de dados!');
	$q_abviat="select * from viaturas where id_viatura=".$viat;
	$r_abviat=mysql_query($q_abviat);
	$q_kms_actuais="select max(kms_viatura) from mov_combustivel where id_viatura=".$viat;
	$r_kms_actuais=mysql_query($q_kms_actuais);
?>
	<br>
	<center>
	<!--TABELA VIATURAS -->
	<table id="hor-minimalist-b" summary="motd"> <!--descrição da viatura -->
		<thead>
			<tr>
				<th>AVARIA DE VIATURA</th>
			</tr>
			<!--
			<tr>
				<th scope="col">Imagem</th>
				<th scope="col">Nome</th>
				<th scope="col">Matricula</th>
				<th scope="col">Marca</th>
				<th scope="col">Modelo</th>
			</tr>
			-->
		</thead>
		<tbody>
					<tr>
						<td><img width="100" src=" <?php echo mysql_result($r_abviat,0,'imagem_viatura')?>"></td>
						<td> 
							<b>Nome: </b><?php echo mysql_result($r_abviat,0,'desc_viatura')?><br>
							<b>Matricula: </b><?php echo mysql_result($r_abviat,0,'matricula_viatura')?><br>
							<b>Marca: </b><?php echo mysql_result($r_abviat,0,'marca_viatura')?><br>
							<b>Modelo: </b><?php echo mysql_result($r_abviat,0,'modelo_viatura')?>
						</td>
						<td>
							<b>Tipo:</b><?php echo mysql_result($r_abviat,0,'tipo_viatura');?><br>
							<b>Kms Actuais:</b><?php echo mysql_result($r_kms_actuais,0,0);?>
						</td>
					</tr>
		</tbody>
	</table>
	<!-- FIM TABELA VIATURAS -->
	<!-- TABELA AVARIAS -->
	<table class="t_registo_horas">
	<tr>
		<td colspan="2">
			<center><font class="font_horas2">Tipo de Avaria</font></center>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<?php
		echo '<form name="avarias" method="POST" action="index.php?guardar=1&viatura='.$viat.'">';
		?>
			<select name="categorias" class="option_categoria_avaria">
				<option value="">Seleccione Tipo Avaria</option>
				<?php
					$q_cat_avarias="select desc_categoria from oficina_categorias order by desc_categoria"; //categorias de avarias
					$r_cat_avarias=mysql_query($q_cat_avarias);
					$n_cat_avarias=mysql_numrows($r_cat_avarias);
					for($i=0;$i<$n_cat_avarias;$i++)
					{
						echo '<option>'.mysql_result($r_cat_avarias,$i,0).'</option>';
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<br>
			<center><font class="font_horas2">Descrição da Avaria</font></center>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input style="font-size: 40px;text-align: right" name="obs" type="text" size="16">
		</td>
	</tr>
	<tr>
		<td  valign="middle"><font class="font_horas2">Horas</font>
						<input style="font-size: 30px;text-align: center" type="text" name="horas_avaria" size="1" value="0" onclick="this.value=''"><font class="font_horas">:</font>
				<select name="minutos_avaria" class="option_minutos">
					<option selected="selected">00</option>
					<option>15</option>
					<option>30</option>
					<option>45</option>
				</select>
		</td>
		<td  valign="middle"><font class="font_horas2">Valor</font>
			<input style="font-size: 40px;text-align: right" type="text" name="valor" size="3" value="0"><font class="font_horas2">€</font>
		</td>
	</tr>
	<tr>
	<td  valign="middle"><font class="font_horas2">Resolvida</font>
			<select name="concluida" class="option_categoria_avaria">
				<option selected="selected">Não</option>
				<option>Sim</option>
			</select>
		</td>
		<td>
		<br>
			<input type="image" src="botao_ok.png">
		</td>
	</tr>
</table>
<!-- FIM TABELA AVARIAS -->
<?php
 echo '</form>';
?>