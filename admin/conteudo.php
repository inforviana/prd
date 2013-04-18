<?php
@$pagina=$_GET['pagina'];

if(!isset($pagina)){ //abrir a pagina inicial
	require('splash.php');
}

switch($pagina){
	case 'extracto_combustivel':
		require('extracto_combustivel.php');
	break;
	case 'funcionarios':
		require('funcionarios.php');
	break;
	case 'editarfuncionario':
		require('editarfuncionario.php');
	break;
	case 'grupos':
		require('grupos.php');
	break;
	case 'editargrupos':
		require('editargrupos.php');
	break;
	case 'viaturas':
		require('viaturas.php');
	break;
	case 'editarviaturas':
		require('editarviaturas.php');
	break;
	case 'editarcomb':
		require('editarmovcombustivel.php');
	break;
	case 'editarhoras':
		require('editarhoras.php');
	break;
	case 'listagemhoras':
		require('listagem_horas.php');
	break;
	case 'listagemavarias':
		require ('listagem_avarias.php');
	break;
	case 'editaravarias':
		require ('editaravaria.php');
	break;
	case 'listagemcombustivel':
		require ('listagem_combustivel.php');
	break;
	case 'resumodia':
		require('resumo_dia.php');
	break;
	case 'opcoes':
		require('parametros.php');
		break;
	case 'utilizadores':
		require('utilizadores.php');
		break;
	case 'utilizadorestubos':
		require('utilizadores_tubos.php');
		break;	
	case 'tmc':
		require '';
		break;
	case 'tubos':
		require('tubos.php');
		break;
        case 'tecnico':
                require('tecnico.php');
                break;
        case 'avaliacao':
                require('avaliacao.php');
                break;
        case 'ponto':
                //ponto dos funcionario
                require 'mod_ponto_funcionarios.php';
                break;
        case 'globalviatura':
                require 'graficos/lucro_gasto.php';
                break;
}
?>