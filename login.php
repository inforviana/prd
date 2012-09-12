	<table width=100% height=100% border=0>
			<tr>
				<td align="center" valign="top">
					<?php
					//echo '<img height="100" src="'.$IMG_FOOTER.'">';
					?>
					<form method="POST" action="index.php" name="frmlogin">
						<br>
						<!-- REPETIR 2 VEZES PARA CONFIRMAÇÃO -->
						<input class="input_login" type="password" name="pin" maxlength="" size="3"/>
						<!--<button type="button" style="height: 55px; width: 300px" ONCLICK="document.frmlogin.pin.value=''">Limpar</button>-->
				</td>
			</tr>
			<tr align="center" valign="top">
				<td align="center" >
				<?php
				//desenhar os botoes do login
				for($i=1;$i<=10;$i++)
					{
						$j=$i;
						if($j==10)
						{
							$j=0;
							echo '<button width="500" class="form_btn_0" type="button" ONCLICK="document.frmlogin.pin.value = document.frmlogin.pin.value + '.$j.'">'.$j.'</button>';
						} else {
							echo '<button class="form_btn" type="button" ONCLICK="document.frmlogin.pin.value = document.frmlogin.pin.value + '.$j.'">'.$j.'</button>';
						}
						
						if($i%3==0)
						{
							echo '<br>';
						}
					}
				?>
					<br>
					<button class="form_btn" type="submit" style="height: 100px; width: 300px">Entrar</button>
					</form>
				</td>
			</tr>
		</table>