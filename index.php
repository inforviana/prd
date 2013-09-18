<?php
require('config.php'); //carregar variaveis globais
	//ligar � base de dados
	if(mysql_connect($DB_HOST,$DB_USER,$DB_PASS))
	//seleccionar a tabela a utilizar
	mysql_select_db($DB_TABLE) or die('Erro de liga��o � base de dados!');
	
if(isset($_GET['accao'])) $accao=$_GET['accao']; //opera��o a executar
if(isset($_POST['pin'])) $pin_l=$_POST['pin']; //pin obtido a partir do form de login

if (isset($accao)) { //logout do funcionario
	if($accao="sair") {
		setcookie("id_funcionario","",time()-3600); //eliminar as cookies
		setcookie("nome_funcionario","",time()-3600);
		header("Location:./index.php");
	}
}

if(isset($pin_l)){ //criar cookie
	//query sql para verficiar o utilizador a partir do pin
	$arr_login = str_split($pin_l,2);
	if($arr_login[0]==$arr_login[1]){
	$query_login="select * from funcionario where pin_funcionario=".$arr_login[0];
	//executar a query
	$dados=mysql_query($query_login);
	
	
	$num=mysql_numrows($dados);
	//fechar o acesso � base de dados
	mysql_close();
		
	if ($num>0) { //preencher variaveis nas cookies
		setcookie("id_funcionario",mysql_result($dados,0,'id_funcionario'));
		setcookie("nome_funcionario",mysql_result($dados,0,'nome_funcionario'));
		header("Location:index.php");
	}
	}
}

	//AVARIAS
	if(!isset($viat)){
		/*http://localhost/index.php?pagina=registo*/
		if(isset($_GET['viatura'])) $viat=$_GET['viatura'];
	}
	
    if(isset($_GET['guardar']))
    {
    	$guardar=$_GET['guardar'];
    	$cat_avaria=$_POST['categorias'];
    	$obs_avaria=$_POST['obs'];
    	$p_avaria=$_POST['valor'];
    	$c_avaria=$_POST['concluida'];
    	$h_avaria=$_POST['horas_avaria'];
    	$m_avaria=$_POST['minutos_avaria'];
		$q_avaria="insert into mov_avarias (id_viatura,id_funcionario,data,categoria,desc_avaria,preco,estado,horas) values (".$viat.",".$_COOKIE['id_funcionario'].",'".date('Y-m-d H:i:s')."','".$cat_avaria."','".$obs_avaria."',".$p_avaria.",'".$c_avaria."',".(($h_avaria*60)+$m_avaria).")";
		mysql_query($q_avaria);
		/*header("Location:index.php");*/
	}
    if(isset($_GET['conteudo'])) $conteudo=$_GET['conteudo'];



//*********************************** FUNCOES PHP / SQL ***************************************************
function categoria_veiculo($id_categoria) //devlolve a categoria do veiculo
{
    $q_categoria_veiculo = "select categoria  from categorias_viatura where id_categoria=".$id_categoria;
    $r_categoria_veiculo=mysql_query($q_categoria_veiculo);
    return mysql_result($r_categoria_veiculo,0,0);
}

//************************************* HTML *************************************************************
?>
<html>
<!DOCTYPE HTML>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<title><?php echo $NOME_APP; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"> 
		<link rel="stylesheet" href="css/dark-hive/jquery-ui-1.8.16.custom.css" type="text/css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/jquery.capty.css" media="all" />
		<!-- carrega a stylesheet -->
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<!--<script type="text/javascript" src="keyboard.js" charset="UTF-8"></script>-->
		<script type="text/javascript" src="js/jquery.capty.min.js"></script>
	
		<!-- script para trocar de pagina -->
                      <script type="text/javascript">
		function abrir_url(url){
			if(url=='Sem Servi�o'){
					window.location='index.php?pagina=horas&serv='+url;
				}else if(url=='Servi�o Externo'){
					window.location='index.php?pagina=horas&serv='+url;
				}else if(url=='Ajudante'){
					window.location='index.php?pagina=horas&serv='+url;
				}
		}
		
		//viaturas para serem usadas no autocomplete
		$(document).ready(function(){
			$("#header").toggle();
		});
		
		function sel_acess(idacess,descricao_acessorio) //seleccionar acessorio
			{
				document.getElementById('id_acess').value=idacess; //aplicar o valor do acessorio ao form
                                                                        document.getElementById('id_acesso').value=idacess;
                                                                        document.getElementById('inp_descricao_acessorio').value=descricao_acessorio;
				$("#dlg_acess").dialog('close'); //fechar seleccao dos acessorios
				$("#dlg_det_acess").dialog('open');
				//alert(document.getElementById('id_acess').value); //debug
			}
                                    
                                    //fechar dialogo dos acessorios
                                    function fechar_acessorio()
                                    {
                                        $("#dlg_det_acess").dialog('close');
                                    }
                                    
                                    //fechar dialogo das avarias
                                    function fechar_avaria()
                                    {
                                        //fechar o dialogo das avarias
                                        $("#dlg_avarias").dialog('close');
                                    }
	
		$(function(){
		
			//cabecalho
				$("#but_header").click(function(){
					$("#header").toggle("drop");
				});
				

			
			//arrays
			var viaturas = [
				<?php
					$q_viaturas="select * from viaturas";
					$r_viaturas=mysql_query($q_viaturas);
					$n_viaturas=mysql_num_rows($r_viaturas);
					
					for($i=0;$i<$n_viaturas;$i++){
						echo '"'.mysql_result($r_viaturas,$i,'desc_viatura').'"';
						if($i<($n_viaturas-1)){echo ',';}
					}
				?>
			];
			
			var viaturas_transporte = [
				<?php
					$q_viaturas="select * from viaturas";
					$r_viaturas=mysql_query($q_viaturas);
					$n_viaturas=mysql_num_rows($r_viaturas);
					
					for($i=0;$i<$n_viaturas;$i++){
						echo ' " '.mysql_result($r_viaturas,$i,'desc_viatura').' | '.mysql_result($r_viaturas,$i,'id_viatura').'" ';
						if($i<($n_viaturas-1)){echo ',';}
					}
				?>
			];		
			
			//data para registo
			$("#data").datepicker({
				dateFormat:'yy-mm-dd',
				dayNamesMin:['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
				monthNames:['Janeiro', 'Fevereiro', 'Marco', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'] 
			});
			
			$("#dlg_data").dialog({ //dialogo para seleccionar a data a usar nos registos
				autoOpen: false,
				resizable: false,
				modal:true,
				width:450,
				height: 200
			});
			
			$("#but_ok_data").click(function(){
				$("#dlg_data").dialog("close");
			});

			$("#but_acess").click(function(){ //butao dos acessorios
				$("#dlg_acess").dialog("open");
			});
                        
            $("#but_avarias").click(function(){
                 $("#dlg_avarias").dialog("open");
            });
			
			$("#dlg_transp").dialog({ //dialogo para escolher a viatura de transporte
				autoOpen: false,
				resizable: false,
				modal: true,
				width: 450,
				height: 400
			});

			//janela para seleccionar o acessorio
			$("#dlg_acess").dialog({
				autoOpen:false,
				resizable: false,
				modal: true,
				width: 850,
				height: 650 
			});
			
			$("#dlg_det_acess").dialog({ //dialog detalhes do acessorio
				autoOpen:false,
				resizable: false,
				modal: true,
				width: 650,
				height: 480 
			});

			//janela para preenchimento das avarias
            $("#dlg_avarias").dialog({
                autoOpen: false,
                resizable: false,
                modal: true,
                width:600,
                height:470
            });

			//janela de aviso do contador
            $("#dlg_aviso").dialog({
				autoOpen:false,
				resizable: false,
				modal: true,
				width:400,
				height:360
                });

            //janela de aviso de falta de local
            $("#dlg_sem_local").dialog({
            	autoOpen:false,
            	resizable: false,
            	modal: true,
            	width:400,
            	height:320
            });

			
			
			/*$("#p_viatura").autocomplete({ //autocomplete para as combo boxes em JS
				source: viaturas //viaturas
                                                                        
			});*/
			
			$("#transporte").autocomplete({
				source:viaturas_transporte //viaturas de transporte
			});
			
			//array em portugues para o calendario
			$("#data_registo").datepicker({
				dateFormat:'dd/mm/yy',
				dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
				monthNames: ['Janeiro','Fevereiro','Marco','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro']
			});
			
					//estado dos botoes
			$("#but_fecharRegisto, #but_registodiario, #but_avaria, #but_acess, #but_oficina, #but_defs, #but_transp, #but_fechar_trans, #but_det_acess, #but_avarias, #but_fechar_avaria, #but_limpar_trans").hover(
				function() {$(this).addClass("ui-state-hover");},
				function() {$(this).removeClass("ui-state-hover");}
			);
			
			$("#but_registodiario").click(function(){
				window.location="./index.php?pagina=registo";
			});
			
			$("#but_oficina").click(function(){
				window.location="./index.php?pagina=oficina";
			});
			
			
			$("#but_defs").click(function(){
				window.location="./index.php?pagina=opcoes";
			});	

			$("#but_transp").click(function(){
				$("#dlg_transp").dialog("open");
			});

			//botao para seleccionar o transporte
			$("#but_fechar_trans").click(function(){
				document.getElementById("viat_t").value=document.getElementById("transporte").value;
				
				if(document.getElementById("transporte").value!=""){
					document.getElementById("icon_transporte").src="./img/icon_ok.png";
				}else{
					document.getElementById("icon_transporte").src="./img/icon_fail.png";
				}
				
				$("#dlg_transp").dialog("close");
				
			});
		});
	</script>
	<!--<link rel="stylesheet" type="text/css" href="keyboard.css">-->
	</head>
	<body>
		<?php
			if(isset($_COOKIE["id_funcionario"])) {
				require("inicio.php");
			} else {
				//ECRA DE LOGIN
				require("login.php");
			}
		?>
	</body>
</html>