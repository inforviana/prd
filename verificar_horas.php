<?xml version="1.0" encoding="iso-8859-1"?>
<?php
        //verificar se há registo de horas
        $q_verificar_horas="select sum(horas_viatura) from mov_viatura where id_funcionario=".$_COOKIE['id_funcionario']." and month(data)=".date(m)." and year(data)=".date(Y)." group by day(data)";
        $r_verificar_horas=mysql_query($q_verificar_horas);
		$n_verificar_horas=mysql_num_rows($r_verificar_horas);
		
		
		for($i=0;$i<$n_verificar_horas-1;$i++){ //verifica cada dia o total de horas
			$total_dia = mysql_result($r_verificar_horas,$i,0);
			
			if($total_dia>480){ //verifica se há horas extra em cada dia 480min=8 horas
				$total_dia=480;
				$extra_dia=$total_dia-480;
			}
			
			$normais+=$total_dia;
			$extra+=$extra_dia;
		}
		
		
        echo "Total Horas Normais este mês: ".($normais/60).":".($normais % 60)."<br>Total Horas Extra este mês: ".($extra/60).":".($extra%60);
?>