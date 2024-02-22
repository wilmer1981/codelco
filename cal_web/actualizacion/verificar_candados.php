<?php
	include ("conectar_cal_web.php");
	
	
	$Consulta="select * from cal_web.solicitud_analisis where estado_actual='5'";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
		{
			$Consulta="select count(*) as total from leyes_por_solicitud ";
			$Consulta=$Consulta." where rut_funcionario='".$Fila["rut_funcionario"]."'";
			$Consulta=$Consulta." and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"];
			$Consulta=$Consulta." and candado <> '1'";
		}
		else
		{
			$Consulta="select count(*) as total from leyes_por_solicitud ";
			$Consulta=$Consulta." where rut_funcionario='".$Fila["rut_funcionario"]."'";
			$Consulta=$Consulta." and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"]." and recargo='".$Fila["recargo"]."'";
			$Consulta=$Consulta." and candado <> '1'";
		}
		$Respuesta2=mysqli_query($link, $Consulta);
		$Fila2=mysqli_fetch_array($Respuesta2);
		if ($Fila2[total]==0)
		{
			echo "NRO.SA:".$Fila["nro_solicitud"];
			echo " NRO.RECARGO:".$Fila["recargo"];
			echo " NRO.ID_MUESTRA:".$Fila["id_muestra"];
			$i++;
			echo "<br>";		
		}	
	}
	echo "datos veridicados:".$i;


?>
