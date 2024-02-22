<?php
	include("../principal/conectar_sec_web.php");
	
	$fecha_des = $ano1."-".$mes1."-".$dia1." ".$hr1.":".$mm1;
	$fecha_con = $ano2."-".$mes2."-".$dia2." ".$hr2.":".$mm2;
	
	if (($proceso == "G") and ($opcion == "N"))
	{
		$consulta = "SELECT * FROM sec_web.cortes_refineria WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Ya Exite la Fecha de Desconexion para Este Grupo";
			header("Location:sec_ing_estadistica_cortes_proceso.php?activar=&mensaje=".$mensaje);
		}
		else 
		{
			$insertar = "INSERT INTO sec_web.cortes_refineria (tipo_desconexion,cod_grupo,fecha_desconexion,fecha_conexion,kahdird,kahdirc)";
			$insertar = $insertar." VALUES ('".$cmbtipo."','".$cmbgrupo."','".$fecha_des."','".$fecha_con."',".$txtkah1.",'".$txtkah2."')";		
			mysqli_query($link, $insertar);
		
			header("Location:sec_ing_estadistica_cortes_proceso.php?activar=");
		}
	}
		
	if (($proceso == "G") and ($opcion == "M"))
	{		
		$actualizar = "UPDATE sec_web.cortes_refineria SET tipo_desconexion = '".$cmbtipo."',fecha_conexion = '".$fecha_con."'";
		$actualizar = $actualizar.",kahdird = ".$txtkah1.",kahdirc = ".$txtkah2;
		$actualizar = $actualizar." WHERE cod_grupo = '".$cmbgrupo."' AND fecha_desconexion = '".$fecha_des."'";
		mysqli_query($link, $actualizar);
		
		header("Location:sec_ing_estadistica_cortes_proceso.php?activar=");
	}
	
	if ($proceso == "E")
	{
		$valores = explode("~",$parametros);
		while(list($c,$v) = each($valores))
		{	
			$arreglo = explode("/", $v); //0: grupo, 1: fecha_desconexion.
		
			//Borra de Sec_Web.
			$eliminar = "DELETE FROM sec_web.cortes_refineria WHERE cod_grupo = '".$arreglo[0]."' AND fecha_desconexion = '".$arreglo[1]."'";
			mysqli_query($link, $eliminar);
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:sec_ing_estadistica_cortes.php?mensaje=".$mensaje);	
	}
	
	include("../principal/cerrar_sec_web.php");
?>