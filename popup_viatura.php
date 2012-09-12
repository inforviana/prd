<script type='text/javascript'>

//abrir a popup calculando a sua posicao
function popup() {
  document.getElementById("mypopup").style.top = 150;
  document.getElementById("mypopup").style.left = (document.body.clientHeight/2);
  document.getElementById("mypopup").style.display = "block";
}

//funcao para fechar a popup
function fechar(){
	document.getElementById("mypopup").style.display="none";
}

//funcao para enviar a viatura seleccionada de volta ao form de transporte
function enviar(v){
	var texto=v;
	document.getElementById("litros").value=texto;
}

//procurar e mostrar as viaturas que correspondam aos criterios
function procurar(t){
	
}
</script> 


<!-- POP-UP -->
<div id='mypopup' name='mypopup' style='position: absolute; width: 500px; height: 600px; display: none; background: #5a5360; border: 1px solid #000; right: 0px; top: 500px'>
	<!--BEGIN CONTEUDO POP-UP -->
		<form>
			<center><font class="popup_texto">Seleccione a viatura de transporte</font></center>
			<br>
			<input type="text" onchange="procurar(this.value);"></input>
			<button onclick="fechar();">Fechar</button>
		</form>
	<!--END CONTEUDO POP-UP -->
</div> 
<!-- FIM POP-UP -->
<button value=' Fire! ' onClick='popup();'>