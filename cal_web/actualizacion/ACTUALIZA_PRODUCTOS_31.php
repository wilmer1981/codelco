<?php
	include ("../Principal/conectar_cal_web.php");
	
	$Consulta="select rut_funcionario,fecha_hora,nro_solicitud,cod_producto,cod_subproducto,id_muestra from cal_web.solicitud_analisis";
	$Consulta=$Consulta." where fecha_hora between '2003-10-20 00:00:01' and '2003-10-31 23:59:59' and not isnull(nro_solicitud)";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$Actualizar="UPDATE cal_web.leyes_por_solicitud set cod_producto='".$Fila["cod_producto"]."',cod_subproducto='".$Fila[cod_subproducto]."',id_muestra='".$Fila["id_muestra"]."'";
		$Actualizar=$Actualizar." where rut_funcionario='".$Fila["rut_funcionario"]."' and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"];
		mysqli_query($link, $Actualizar);
	}
	echo "datos actualizados";


?>