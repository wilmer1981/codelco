<?php
	include("../principal/conectar_sec_web.php");

	$opcion   = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$proceso  = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$mes   = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$ano   = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$txtrevision   = isset($_REQUEST["txtrevision"])?$_REQUEST["txtrevision"]:"";
	$txtdescobrizacion = isset($_REQUEST["txtdescobrizacion"])?$_REQUEST["txtdescobrizacion"]:"";
	$txtdespuntes      = isset($_REQUEST["txtdespuntes"])?$_REQUEST["txtdespuntes"]:"";
	$txtcatodos     = isset($_REQUEST["txtcatodos"])?$_REQUEST["txtcatodos"]:"";
	$parametros     = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";

	if (($proceso == "G") and ($opcion == "N"))	
	{
		$fecha = $ano."-";
		if (strlen($mes) == 1)
			$fecha = $fecha."0";
		$fecha = $fecha.$mes;

		$consulta = "SELECT * FROM sec_web.totales_prog_prod WHERE fecha_total LIKE '".$fecha."%' AND cod_revision = ".$txtrevision;
        //echo $consulta;
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Existe.
		{
			$mensaje = "Ya Existe la Fecha y Revision";
			header("Location:sec_ing_totales_produccion_proceso.php?activar=&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			/*if ($estado == 1)
			{	
				$actualizar = "UPDATE sec_web.totales_prog_prod SET estado = 0 WHERE estado = 1";
				mysqli_query($link, $actualizar);
				echo $actualizar;
			}*/
		
			$fecha = $fecha.'-'.date("j");
			$insertar = "INSERT INTO sec_web.totales_prog_prod(fecha_total,cod_revision,total_catodo_comercial,total_desc_normal,total_desp_lamina)";
			$insertar = $insertar." VALUES ('".$fecha."','".$txtrevision."','".$txtcatodos."','".$txtdescobrizacion."','".$txtdespuntes."')";
			mysqli_query($link, $insertar);
			//echo $insertar."<br>";
			
			header("Location:sec_ing_totales_produccion_proceso.php?activar=");
		}
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
		/*if ($estado == 1)
		{*/
			/*$actualizar = "UPDATE sec_web.totales_prog_prod SET estado = 0 WHERE estado = 1";
			mysqli_query($link, $actualizar);*/
		/*}*/
		
		$fecha = $ano."-";
		if (strlen($mes) == 1)
			$fecha = $fecha."0";
		$fecha = $fecha.$mes;
			
			
		$actualizar = "UPDATE sec_web.totales_prog_prod SET total_catodo_comercial = '".$txtcatodos."'";
		$actualizar = $actualizar.",total_desc_normal = '".$txtdescobrizacion."',total_desp_lamina = '".$txtdespuntes."'";
		$actualizar = $actualizar." WHERE fecha_total LIKE '".$fecha."%' AND cod_revision = '".$txtrevision."'";
		mysqli_query($link, $actualizar);		
		
		header("Location:sec_ing_totales_produccion_proceso.php?activar=");
	}
	
	if ($proceso == "E")
	{
		$valores = explode("~",$parametros);
		foreach($valores as $c => $v)
		{	
			$arreglo = explode("/", $v); //Fecha - revision.
			$fecha = substr($arreglo[0],0,7);
			
			//Borra de Sec_Web.
			$eliminar = "DELETE FROM sec_web.totales_prog_prod";
			$eliminar = $eliminar." WHERE fecha_total LIKE '".$fecha."%' AND cod_revision = ".$arreglo[1];
		
			mysqli_query($link, $eliminar);
		}
		
		$mensaje = "Registro(s) Eliminado(s) Correctamente";
		header("Location:sec_ing_totales_produccion.php?mensaje=".$mensaje);		
	}

	include("../principal/cerrar_sec_web.php");
?>
