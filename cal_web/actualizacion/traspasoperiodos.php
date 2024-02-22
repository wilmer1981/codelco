<?php
	include ("../Principal/conectar_cal_web.php");
	
	$Consulta="select rut_funcionario,fecha_hora,id_muestra,recargo,fecha_muestra,cod_periodo";
	$Consulta=$Consulta." from cal_web.periodos_solicitud_analisis where fecha_hora between '2003-08-01 00:00:00' and '2003-10-03 23:59:59'";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		switch ($Fila[cod_periodo])
		{
			case "1":
				$Periodo=1;
				break;
			case "2":
				$Periodo=1;			
				break;
			case "3":
				$Periodo=1;			
				break;
			case "4":
				$Periodo=2;			
				break;
			case "5":
				$Periodo=3;			
				break;
		}
		if ((is_null($Fila["recargo"])) || ($Fila["recargo"]==''))
		{
			$Actualizar="UPDATE cal_web.solicitud_analisis set cod_periodo='$Periodo',fecha_muestra='".$Fila[fecha_muestra]."'"; 
			$Actualizar=$Actualizar." where rut_funcionario='".$Fila["rut_funcionario"]."' and fecha_hora='".$Fila["fecha_hora"]."' and id_muestra='".$Fila["id_muestra"]."'";
		}	
		else
		{
			$Actualizar="UPDATE cal_web.solicitud_analisis set cod_periodo='$Periodo',fecha_muestra='".$Fila[fecha_muestra]."'"; 
			$Actualizar=$Actualizar." where rut_funcionario='".$Fila["rut_funcionario"]."' and fecha_hora='".$Fila["fecha_hora"]."' and id_muestra='".$Fila["id_muestra"]."' and recargo='".$Fila["recargo"]."'";
		}
		mysqli_query($link, $Actualizar);
	}

?>