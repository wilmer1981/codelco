<?php
	include("../principal/conectar_sec_web.php");
	
	if (($proceso == "G") and ($opcion == "N"))	
	{
		$fecha = $ano."-";
		if (strlen($mes) == 1)
			$fecha = $fecha."0";
		$fecha = $fecha.$mes;
	
		$consulta = "SELECT * FROM sec_web.totales_produccion WHERE fecha LIKE '".$fecha."%' AND revision = ".$txtrevision;
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Existe.
		{
			$mensaje = "Ya Existe la Fecha y Revision";
			header("Location:sec_ing_totales_produccion_proceso.php?activar=&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			if ($estado == 1)
			{	
				$actualizar = "UPDATE sec_web.totales_produccion SET estado = 0 WHERE estado = 1";
				mysqli_query($link, $actualizar);
				echo $actualizar;
			}
		
			$fecha = $fecha.date("j");
			
			$insertar = "INSERT INTO sec_web.totales_produccion (fecha,revision,estado,cant_catodos_comerciales,cant_descobrizacion_normal,cant_despuntes_laminas)";
			$insertar = $insertar." VALUES ('".$fecha."',".$txtrevision.",".$estado.",".$txtcatodos.",".$txtdescobrizacion.",".$txtdespuntes.")";
			mysqli_query($link, $insertar);
			
			header("Location:sec_ing_totales_produccion_proceso.php?activar=");
		}
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
		if ($estado == 1)
		{	
			$actualizar = "UPDATE sec_web.totales_produccion SET estado = 0 WHERE estado = 1";
			mysqli_query($link, $actualizar);
		}		
		
		$fecha = $ano."-";
		if (strlen($mes) == 1)
			$fecha = $fecha."0";
		$fecha = $fecha.$mes;
			
			
		$actualizar = "UPDATE sec_web.totales_produccion SET cant_catodos_comerciales = ".$txtcatodos.",estado = ".$estado;
		$actualizar = $actualizar.",cant_descobrizacion_normal = ".$txtdescobrizacion.",cant_despuntes_laminas = ".$txtdespuntes;
		$actualizar = $actualizar." WHERE fecha LIKE '".$fecha."%' AND revision = ".$txtrevision;
		mysqli_query($link, $actualizar);		
		
		header("Location:sec_ing_totales_produccion_proceso.php?activar=");
	}
	
	if ($proceso == "E")
	{
		$valores = explode("~",$parametros);
		while(list($c,$v) = each($valores))
		{	
			$arreglo = explode("/", $v); //Fecha - revision.
			$fecha = substr($arreglo[0],0,7);
			
			//Borra de Sec_Web.
			$eliminar = "DELETE FROM sec_web.totales_produccion";
			$eliminar = $eliminar." WHERE fecha LIKE '".$fecha."%' AND revision = ".$arreglo[1];
			mysqli_query($link, $eliminar);
		}
		
		$mensaje = "Registro(s) Eliminado(s) Correctamente";
		header("Location:sec_ing_totales_produccion.php?mensaje=".$mensaje);		
	}

	include("../principal/cerrar_sec_web.php");
?>