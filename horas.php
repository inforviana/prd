<?php

//obra esta definida ...
if(isset($_POST['selectObra']))
{
    $local=$_POST['selectObra'];
    $data=$_POST['data'];
    $horas=$_POST['horas']; //variaveis globais
    $minutos=$_POST['minutos'];
    $horas_transporte=$_POST['horas_transporte'];
    $minutos_transporte=$_POST['minutos_transporte'];
    $litros=$_POST['litros'];
    $kms=$_POST['horasv'];
    $avarias=$_POST['avarias'];
    $desc=$_POST['desc'];
    $viat=$_GET['viatura'];
    $ajudante=$_POST['ajudante'];
    $tipo_serv=$_GET['serv']; //sem viatura
    $viatura_transporte=explode(' | ',$_POST['viat_t']); //separar o text o que vem do tranporte


    //verifica viatura de transporte (84 - sem viatura)
    if($viatura_transporte[1]=="") $viatura_transporte[1]=84;
}


	//verifica se e ou nao um trabalho sem viatura
    if(isset($_GET['viatura']))
    {
        $no_viat=0;
    }else{
        $no_viat=1;
    }
		

	if(!isset($horas)){ //verifica se ja tem os dados para abastecimento ou nao
		mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
		mysql_select_db($DB_TABLE) or die ('Erro de ligacao a base de dados!');
		//obter kms actuais da viatura
		$q_kms_actuais="select max(kms_viatura) from mov_combustivel where id_viatura=".$viat;
		$r_kms_actuais=mysql_query($q_kms_actuais);
		//pesquisar todas as viaturas para a popup do transporte, carrega para um array em JS
		$q_popup_viatura="select * from viatura";
		$r_popup_viatura=mysql_query($q_popup_viatura);
		/* SCRIPT DO POPUP
		echo "<script type='text/javascript'>\n";
		echo "var viaturas = new Array();\n";
		while ($row=mysql_fetch_array($r_popup_viatura)){
			echo "viaturas[viaturas.length]={id:'".$row['id_viatura']."',marca:'".$row['desc_viatura']."'}";
		}
		echo "</script>";
		*/
		//detalhes da viatura
	$q_abviat="select * from viaturas where id_viatura=".$viat;
	$r_abviat=mysql_query($q_abviat);
	?>
	<center>
	<?php
		if(isset($tipo_serv)){
			echo "<h1>".$tipo_serv."</h1>";
			$q_serv="select * from viaturas where desc_viatura='".$tipo_serv."'"; /* query para seleccionar a viatura se for sem servico DEPRECATED*/
			$r_serv=mysql_query($q_serv);
		}
		if($no_viat!=1){
	?>
                      <script>
                                   function alterar(inph,inpv)
                                   {
                                       //altera os valores das inputs escondidas de forma a conseguir passar os valores
                                       document.getElementById(inph).value=inpv;
                                     }
                       </script>
	<table id="hor-minimalist-b" summary="motd"> <!--descricao da viatura -->
		<thead>
			<tr>
				<th>DIARIA DA VIATURA</th>
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
						<td><img class="img_horas" width="200" height="133" src="imagem.php?idviatura=<?php echo mysql_result($r_abviat,0,'id_viatura')?>"></td>
						<td> 
							<b>Nome: </b><?php echo mysql_result($r_abviat,0,'desc_viatura')?><br>
							<b>Matricula: </b><?php echo mysql_result($r_abviat,0,'matricula_viatura')?><br>
							<b>Marca: </b><?php echo mysql_result($r_abviat,0,'marca_viatura')?><br>
							<b>Modelo: </b><?php echo mysql_result($r_abviat,0,'modelo_viatura')?>
						</td>
						<td>
							<b>Tipo:</b><?php 
                                                        
                                                                        $q_cat="select categoria from categorias_viatura where id_categoria=".mysql_result($r_abviat,0,'tipo_viatura');
                                                                        $r_cat=mysql_query($q_cat);
                                                                        echo mysql_result($r_cat,0,0);
                                                                    ?><br>
							<b>Contador: </b><?php echo mysql_result($r_kms_actuais,0,0);?>
						</td>
					</tr>
					<tr>
						<td colspan=3>
							<?php
								/* INICIO DO FORM */
								echo '<form accept-charset="ISO-8859-1" action="index.php?pagina=horas&viatura='.$viat.'" method="POST" name="horas_viat" id="horas_viat">'; 
							?>
							<center>
                                                            <select class="local" name="data">
                                                                   <?php
                                                                                                                                        
                                                                        for($i=0;$i<=3;$i++)
                                                                        {
                                                                            $dts=strtotime("-$i day",strtotime(date('Y-m-j')));
                                                                            $dia_semana=date('N',$dts);
                                                                            
                                                                            switch($dia_semana)
                                                                            {
                                                                                case '7':
                                                                                    $diasem='Domingo';
                                                                                    break;
                                                                                case '1':
                                                                                    $diasem='Segunda';
                                                                                    break;
                                                                                case '2':
                                                                                    $diasem='Terca';
                                                                                    break;
                                                                                case '3':
                                                                                    $diasem='Quarta';
                                                                                    break;
                                                                                case '4':
                                                                                    $diasem='Quinta';
                                                                                    break;
                                                                                case '5':
                                                                                    $diasem='Sexta';
                                                                                    break;
                                                                                default:
                                                                                    $diasem='Sabado';
                                                                                    break;
                                                                            }
                                                                            echo '<option value="'.date('Y-m-j',$dts).'">'.$diasem.'</option>';
                                                                        }
                                                                   ?>
                                                            </select>
                                                            <!--<input class="data" type="text" value="<?php echo date('Y-m-j');?>" id="data" name="data">  DATA -->
								<select class="local" id="div_local" name="selectObra"> <!-- LOCAL -->
								<?php
									/* LOCALIZACAO DO FUNCIONARIO */ 
									$r_locais=mysql_query("select * from obras");
									$n_locais=mysql_num_rows($r_locais);
									 
									for($i=0;$i<$n_locais;$i++)
									{
										echo '<option value="'.mysql_result($r_locais,$i,'id_obra').'">'.mysql_result($r_locais,$i,'descricao_obra').'</option>';
									}
								?>
								</select>
							</center>
						</td>
					</tr>
		</tbody>
	</table>
	 <!-- input box para as horas da viatura -->
	<?php 
	}
	?>
	<div class="div_horas">
	<table class="t_registo_horas" border=0 width=600>   
		<?php
			// <tr>
				// <font color="black"><b>HORAS/MINUTOS A REGISTAR:</b></font>
				// <br><input style="font-size: 60px;" align="center" type="text" name="horas" maxlength="" size="2">

				// <br>
				// <font color="black"><b>DESCRI��O:</b></font><br><input style="font-size: 30px;" class="keyboardInput" type="text" name="desc" maxlength="" size="35"><br>
				// <center><br><button class="pesquisa_btn" type="submit" style="height: 100px; width: 300px">Registar Horas</button></center>
		
/* 		<tr>
			<td ><font class="font_horas">Foi Ajudante:</font></td>
			<td>
				<select name="ajudante" class="option_minutos">
					<option value="0" selected="selected">N�o</option>
					<option value="1">Sim</option>
				</select></td>
		</tr> */
		
		
		if($no_viat!=1){ //COM VIATURA
		$d_viat=mysql_result($r_abviat,0,'desc_viatura');	
		?>
		<tr>
			<td valign="middle"><font class="font_horas2">Tempo Transporte:</font>
			</td>
			<td>
				<!-- HORAS E MINUTOS DO TRANSPORTE -->
			<input class="h_transp" style="font-size: 40px;text-align: center" type="text" name="horas_transporte"  value="0" onclick="this.value=''"><font class="font_horas">:</font>
			<select style="font-size:40px" name="minutos_transporte" class="option_minutos">
					<option selected="selected" >00</option>
					<option>10</option>
					<option>20</option>
					<option>30</option>
					<option>40</option>
					<option>50</option>
				</select>
			</td>
			<td>
				<button type="button" id="but_transp" class="fg-button ui-state-default ui-corner-all">Viatura <br>Transporte </button>
			</td>
			<td>
			 	<img id="icon_transporte" height="30" src="./img/icon_fail.png" border=0>
			</td>
		</tr>
		<tr>
			<td ><font class="font_horas2">Combustivel Utilizado:</font></td><td><input class="comb" style="font-size: 50px;text-align: right" align="center" type="text" name="litros" value="0" onclick="this.value='';"></td><td><font class="font_horas" style="text-align:left">Litros</font></td>
		</tr>
		<?php
		// FIM COM VIATURA
		}
		?>
		<tr>
			<?php 
                                                                if($no_viat!=1) 
                                                                        echo '<td ><font class="font_horas2">H/Kms do Veiculo:</font></td>';
                                                                    ?>
			<td><input id="horasv" class="horasv" style="font-size: 40px;text-align: right" type="text" name="horasv" onclick="this.value=''" value="0"></td>
		</tr>
		<tr>
			<?php  
				if($no_viat!=1){ 
			?>
					
			<?php
				}
			?>
			<input type="hidden" id="viat_t" name="viat_t" value=""> <!-- id da viatura de transporte-->
			<td ><font class="font_horas2">Horas Trabalhadas:</font> <!-- horas de trabalho -->
			</td>
			<td>
			<input class="horast" style="font-size: 40px;text-align: center" type="text" name="horas" >
			<font class="font_horas">:</font>
				<select style="font-size:40px" name="minutos" class="option_minutos">
					<option selected="selected">00</option>
					<option>15</option>
					<option>30</option>
					<option>45</option>
				</select>
			</td>
		</tr>
		<tr>
		<?php 
                                             if($no_viat!=1){ //AVARIAS COM VIATURA
		?>
			<br><!--
					<select name="avarias" class="option_minutos">
						<option selected="selected">S/Avarias</option>
						<option>C/Avarias</option>
					</select>
					-->
		<?php
		}
		?>
			<td align="center" colspan="2">      <!-- BOTAO DOS ACESSORIOS -->
				<input type="hidden"  id="id_acess" value=""> <!-- valor do id de acessorio para enviar com o form -->
				<button type="button" id="but_acess" class="acessorios ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">Acessorio</button>
				
				<!--  botao das avarias -->
				<button type="button" id="but_avarias" class="acessorios ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">Avarias</button>
			</td>
			
			<td align="center" colspan="3">
				<?php    
					if($no_viat==1){
					echo "<center>";
					echo '<br><font class="font_horas2">Descricao do servico: </font><br><input style="font-size: 40px;text-align: center" type="text" name="desc" type="text" size="20"></text><br><br>';
					}
				?>
				
				<!-- funcoes em para verificar valores e submeter o form em JS -->
				<script>
					//funcao para submeter o form
					function submeterForm()
					{
						var formViat = document.getElementById('horas_viat');
						formViat.submit();
					}

					
					//funcao em JS para comparar os valores dos contadores das viaturas
					function compararContador(){

						//margem de diferenca em % para os valores
						var margemComparacao = 0.1;

						//obter os quilometros actuais da viatura para comparar
						var kmsActuais = <?php echo mysql_result($r_kms_actuais,0,0);?>; 

						//kms / horas inseridos pelo funcioario
						var kmsInseridos = document.getElementById('horasv');
						var kmsContador = kmsInseridos.value;
						var diferenca = (kmsInseridos.value - kmsActuais);
						
						//verifica se o valor e fora do normal
						if((kmsInseridos.value - kmsActuais) > 700){
								$("#dlg_aviso").dialog("open");		
						}else{
							submeterForm();
						}
					}

				

				//fechar o aviso do contador
				function fecharAviso()
				{
					$("#dlg_aviso").dialog("close");
				}
				</script>
				
				
				<!--  BOTAO PARA GRAVAR -->
				<button id="but_fecharRegisto" type="button" onClick="compararContador()" class="acessorios ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all">Concluir Registo</button>
				<?php
					if($no_viat==1){echo "</center>";}
				?>
			</td>
		</tr>
	</table>
	</div>
	
	
		<!--  ********************************************* dialogos em javascript / jquery *********************************************** -->
	
				<!-- limpar o transporte -->
                  <script>
                        function limpar_transporte()
                           {
                               document.getElementById('transporte').value='';
                           }
                  </script>

                  
                  
                  
       <!--  DIALOGO PARA OS ERROS DE CONTADOR -->
       <div title="Aviso" id="dlg_aviso" class="ui-widget ui-dialog ui-widget-content ui-corner-all">
       		
       		<center><img src="./img/icon_warning.png"></center>
       		<center><h3>Valor de Contador Anormal!</h3>     
       		<u><i>Viatura errada ou contador novo?</i></u><br><br>  		
       			<button style="font-size: 24px;" class="ui-widget ui-button botoes_aviso" onClick="fecharAviso();">Corrigir Valor</button>
       			<button style="font-size: 24px;" class="ui-widget ui-button botoes_aviso" onClick="submeterForm();">Fechar Registo</button>
       		</center>
       </div>
		
		
		
		<!-- CAIXA DE DIALOGO PARA SELECCIONAR O TRANSPORTE -->
		<div title="Transporte" id="dlg_transp" class="ui-widget ui-dialog ui-widget-content ui-corner-all">
			<?
				echo '
				<center>
					<input style="text-align:center;font-size:30px" type="text" id="transporte" name="transporte" ><br><br>
					<button type="button" id="but_fechar_trans" class="fg-button ui-state-default ui-corner-all" style="font-size:40px">OK</button>
					<button type="button" id="but_limpar_trans" class="fg-button ui-state-default ui-corner-all" style="font-size:40px" onclick="limpar_transporte()">Limpar</button>
				</center>
				';
			?>
		</div>
	
	
		<!-- CAIXA DO ACESSORIO -->
		<div title="Acessorios" id="dlg_acess" class="ui-widget ui-dialog ui-widget-content ui-corner-all">
			<table>
			
				<?php
					$r_acess=mysql_query("SELECT acessorios_viatura.id_acessorio as id_acessorio, viaturas.desc_viatura as descricao FROM acessorios_viatura LEFT JOIN viaturas ON viaturas.id_viatura = acessorios_viatura.id_acessorio WHERE acessorios_viatura.id_viatura=".$viat." LIMIT 20");
					$n_acess=mysql_num_rows($r_acess);
					
					$max_c=5;//largura das colunas
					
					for($i=0;$i<$n_acess;$i++) //loop
					{
						if($i==0) echo '<tr>';
						if(($i)%$max_c==0) echo '</tr><tr>';  //linhas
						?>
						<!-- overlay gerado dinamicamente com nome do acessorio JS:CAPTY-->
						<script type="text/javascript"> 
							$('#<?php echo mysql_result($r_acess,$i,'id_acessorio');?>').capty({
								animation: 'fixed'
							});
			
						</script>
                                                                                                                              <!-- colunas -->
							<td>
                                                            <!-- link para seleccionar o acessorio--><a href="#" onclick="sel_acess(<?php echo mysql_result($r_acess,$i,'id_acessorio')?>,'<?php echo mysql_result($r_acess, $i,'descricao')?>')" id=""> 
                                                                                                                                         <!--imagem do acessorio--><img border=0 id="<?php echo mysql_result($r_acess,$i,'id_acessorio');?>" class="img_horas" width="150" height="133" alt="<?php echo mysql_result($r_acess,$i,'descricao');?>" src="imagem.php?idviatura=<?php echo mysql_result($r_acess,$i,'id_acessorio')?>">
                                                                                                                                    </a>
                                                                                                                             </td>
                                                                                                                                
						<?php
						if($i==$n_acess) echo '</tr>'; //fim da linha da tabela
					}
				?>
				</table>
		</div>
		
		
		
		
		<!-- DETALHES DO ACESSORIO -->
		<div title="Detalhes Acessorio" id="dlg_det_acess" class="ui-widget ui-dialog ui-widget-content ui-corner-all">
			<table class="tab_det_acess" border=0>
                                                                        <tr>
                                                                            <!-- descricao do acessorio --><td colspan="2"><input id="inp_descricao_acessorio" style="width:400px;text-align:center;" type="text" readonly="readonly" value=""></td>
                                                                        </tr>
				<tr>
					<td>Combustivel Acessorio</td>
					<td><input style="font-size: 50px; text-align:center;width:300px;" class="inp_acesso" type="text" name="comb_acess" onchange="alterar('hcomb_acess',this.value)" value="0"> L</td>
				</tr>
				<tr>
					<td>Horas efetuadas com Acessorio</td>
					<td><input style="font-size: 50px; text-align:center;width:100px;" class="inp_acesso" type="text" name="horas_acess" onchange="alterar('hhoras_acess',this.value)"> :
                                                                                                <select style="font-size: 50px; text-align:center;width:100px;" class="inp_acesso" type="text" name="minutos_acess" onchange="alterar('hminutos_acess',this.value)"> 
                                                                                                    <option selected="selected">00</option>
                                                                                                    <option>15</option>
                                                                                                    <option>30</option>
                                                                                                    <option>45</option>
                                                                                                </select>
                                                                                                </td>
				</tr>
				<tr>
					<td>Contador Acessorio</td>
					<td><input style="font-size: 50px; text-align:center;width:300px;" class="inp_acesso" type="text" name="horas_contador_acess" onchange="alterar('hcont_acess',this.value)"></td>
				</tr>				
				<tr>
					<td colspan="3"><button onclick="fechar_acessorio()" type="button" id="but_det_acess" class="fg-button ui-state-default ui-corner-all" style="font-size:40px">Guardar</button></td>
				</tr>
			</table>
		</div>
                
                
                
	<!-- DETALHES DA AVARIA  -->
	<div title="Avaria" id="dlg_avarias" class="ui-widget ui-dialog ui-widget-content ui-corner-all" style="position:relative">
                                    <!-- tipo de avaria -->    
                                    <select onchange="alterar('htipo_avaria',this.value)" style="font-size:40px;width:550px;" name="tipo_avaria">
                                            <?php
                                                $q_tipo_avaria="select * from oficina_categorias order by desc_categoria";
                                                $r_tipo_avaria=mysql_query($q_tipo_avaria);
                                                
                                                while($tipo_avaria=  mysql_fetch_array($r_tipo_avaria))
                                                {
                                                    echo '<option value="'.$tipo_avaria['desc_categoria'].'">'.$tipo_avaria['desc_categoria'].'</option>';
                                                }
                                            ?>
                                        </select><br>
                                        <!-- descricao da avaria --><br>
                                        <input onchange="alterar('hdesc_avaria',this.value)" style="font-size:20px;width:550px;text-align:center;" type="text"  placeholder="descricao da avaria" name ="desc_avaria" id="inp_desc_avaria">
                                        <!-- tempo gasto na avaria -->
                                        <br><br>
                                        <table border="0" style="width:580px;">
                                            <tr>
                                                <td><label>Tempo Gasto</label></td>
                                                <td><label>Custo</label></td>
                                            </tr>
                                            <tr>
                                                <td>                                        
                                                    <input onchange="alterar('hhoras_avaria',this.value)" style="font-size:50px; width:100px;text-align:center" type="text" name="horas_avaria" value="0">:
                                                    <select onchange="alterar('hminutos_avaria',this.value)"style="font-size:50px;"  name="minutos_avaria">
                                                        <option value="0">00</option>
                                                        <option value="15">15</option>
                                                        <option value="30">30</option>
                                                        <option value="45">45</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input onchange="alterar('hcusto_avaria',this.value)" style="font-size:50px; width:200px;text-align:center" type="text" name="custo_avaria"> Euros</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <label for="">Estado da Avaria</label>
                                        <select  onchange="alterar('hestado_avaria',this.value)"  style="font-size:50px" name="estado_avaria">
                                            <option style="color:green;" value="Sim">Resolvida</option>
                                            <option style="color:red;" value="Nao" selected="selected">Nao Resolvida</option>
                                        </select>
                                        <br><brZ
                                        <center>
                                        	<button onclick="fechar_avaria()" type="button" id="but_fechar_avaria" class="fg-button ui-state-default ui-corner-all" style="font-size:40px;">Guardar</button></center>
                                    </div>
                                            <!-- resolvem o problema das divs externas -->
                                            <input type="hidden" id="htipo_avaria" name="htipo_avaria" value="Caixa">
                                            <input type="hidden" id="hdesc_avaria" name="hdesc_avaria">
                                            <input type="hidden" id="hhoras_avaria" name="hhoras_avaria" value="0">
                                            <input type="hidden" id="hminutos_avaria" name="hminutos_avaria" value="00">
                                            <input type="hidden" id="hestado_avaria" name="hestado_avaria" value="N�o">
											<input type="hidden" id="hcusto_avaria" name="hcusto_avaria" value="0">
                                            <!-- hiddens do acessorio -->
                                            <input type="hidden" name="id_acesso" id="id_acesso" value="0">
                                            <input type="hidden" name="hminutos_acess" id="hminutos_acess" value="0">
                                            <input type="hidden" name="hhoras_acess" id="hhoras_acess" value="0">
                                            <input type="hidden" name="hcomb_acess" id="hcomb_acess" value="0">
                                            <input type="hidden" name="hcont_acess" id="hcont_acess">
	</form>
	</center>

	
	
	<?php
	/*-----------------------------------------------------------------------------                 GRAVAR DADOS               -------------------------------------------*/
	} else {
		mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
		mysql_select_db($DB_TABLE) or die ('Erro de ligacao a base de dados!');	
		/*query para registar as horas*/
		if($viat!=""){
                                                                    //obter precos hora
                                                                    $preco_hora_funcionario=mysql_query("select preco_hora_normal, preco_hora_extra, preco_sabado from funcionario where id_funcionario=".$_COOKIE['id_funcionario']);
                                                                    
                                                                    
                                                                    //preco da obra
                                                                    $precoObra = mysql_query("select preco_obra from obras_precos where id_viatura = ".$viat."  and id_obra = ".$_POST['selectObra']);
																	$nPrecoObra = mysql_num_rows($precoObra);
																	
																	//ultima contagem do combustivel
																	$ultimaContagem = mysql_query("select max(kms_viatura) from mov_combustivel where valor_movimento > 0 and id_viatura=".$viat);
																	
																	//se existir preco definido para o obra utiliza-o senao utiliza o preco base
																	if($nPrecoObra > 0)
																	{
																		$preco_viatura = mysql_result($precoObra,0,'preco_obra');
																	}else{
																		$rPrecoViatura = mysql_query("select preco_hora from viaturas where id_viatura=".$viat);
																		$preco_viatura = mysql_result($rPrecoViatura, 0,0);	
																	}


                                                                    
			/*REGISTAR HORAS*/
			$q_horas="insert into mov_viatura 
					(id_viatura,id_funcionario,horas_viatura,data,desc_movviatura,transporte,id_viatura_transporte,local,id_acessorio,horas_trab_acessorio,preco_hora_normal,preco_hora_extra,preco_hora_sabado,preco_viatura,id_obra, contador) 
					values 
						(".$viat.",".$_COOKIE['id_funcionario'].",".(($horas*60)+$minutos).",'".$data." ".date('H:i:s')."','".$desc."',".(($horas_transporte*60)+$minutos_transporte).",".$viatura_transporte[1].",".$local.",".$_POST['id_acesso'].",".((($_POST['hhoras_acess'])*60)+($_POST['hminutos_acess'])).",".mysql_result($preco_hora_funcionario,0,0).",".  mysql_result($preco_hora_funcionario, 0,1).",'".  mysql_result($preco_hora_funcionario, 0,2)."','".$preco_viatura."',".$_POST['selectObra'].",".$kms.")";
			
			/*REGISTAR COMBUSTIVEL*/
			$q_abast="insert into mov_combustivel (id_funcionario,id_viatura,id_combustivel,data,tipo_movimento,valor_movimento,kms_viatura) values (".$_COOKIE['id_funcionario'].",".$viat.",'0','".$data." ".date('H:i:s')."','S',".$litros.",".$kms.")";
				
            /*REGISTAR AVARIAS */ 
			$q_nova_avaria="INSERT INTO mov_avarias (id_viatura,id_funcionario,data,preco,categoria,desc_avaria,horas,estado) VALUES (".$viat.",".$_COOKIE['id_funcionario'].",'".$data." ".date('H:i:s')."','".$_POST['hcusto_avaria']."','".$_POST['htipo_avaria']."','".$_POST['hdesc_avaria']."',".(($_POST['hhoras_avaria']*60)+($_POST['hminutos_avaria'])).",'".$_POST['hestado_avaria']."')";

								//verifica se as horas sao 0 ou mais
                                                                 if(($_POST['hhoras_avaria']+$_POST['hminutos_avaria'])>=0)
                                                                     if(mysql_query($q_nova_avaria)){}else{ echo "<font style=\"color:red\">Erro ao guardar avaria!</font>";};
			if(!mysql_query($q_horas)) { //insere o movimento das horas
				echo $no_viat;
				echo $q_horas."<br>".$q_abast; //teste bd
				echo "<br><br><font style=\"color:red\">Erro de acesso a base de dados!</font>"; //em caso de erro ao inserir na bd
			}else{
				mysql_query($q_abast); //insere o movimento do combustivel
                //ecra das avarias DEPRECATED
				/*if($avarias=="C/Avarias"){
					require("avarias.php");//avarias
				}else{*/
					require("splash.php");//ecra inicial
				/*}*/
			}
	
                }else{
			//no caso de ser sem viatura
			//REGISTAR HORAS SEM VIATURA
			$q_horas="insert into mov_viatura(id_viatura,id_funcionario,data,horas_viatura,desc_movviatura) values (84,".$_COOKIE['id_funcionario'].",'".date('Y-m-d H:i:s')."',".(($horas*60)+$minutos).",'".$desc."')";
			if(!mysql_query($q_horas)){
				echo $q_horas."<br>".$noviat."<br><font style=\"color:red\">Erro de acesso � base de dados!</font>"; //em caso de erro ao inserir na bd
			}else{
				require("splash.php");//no caso de tudo ok
			}
		}
	}
?>
