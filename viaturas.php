		<?php
			require("config.php");
			mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
			mysql_select_db($DB_TABLE) or die('Erro de ligação á base de dados!');
			$q_relatorio=$_GET['query'];
			$titulo=$_GET['titulo'];
			$r_relatorio=mysql_query($q_relatorio);
			$n_relatorio=mysql_numrows($r_relatorio);
			$f_relatorio=mysql_num_fields($r_relatorio);
		?>
<html>
	<head>
		<title><?php echo $titulo;?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet_relatorios.css"> 
	</head>
	<body>
	<center>
		<table id="hor-minimalist-b" summary="motd">
			<thead>
				<tr>
					<th scope="col" colspan="<?php echo $f_relatorio-1;?>"><?php echo $titulo;?></th>
				</tr>
				<tr>
					<?php
						for($j=0;$j<$f_relatorio;$j++){
							echo "<th>".mysql_field_name($r_relatorio,$j)."</th>";
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					for($i=0;$i<$n_relatorio;$i++){
						echo '<tr>';
							for($h=0;$h<$f_relatorio;$h++){
								echo "<td>".mysql_result($r_relatorio,$i,$h)."</td>";
							}
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</center>
	</body>
</html>