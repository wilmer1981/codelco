<?php
	include("../principal/conectar_sec_web.php");
	$proceso       = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$opcion        = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$txtcodigo     = isset($_REQUEST["txtcodigo"])?$_REQUEST["txtcodigo"]:"";
	$txtdescripcion     = isset($_REQUEST["txtdescripcion"])?$_REQUEST["txtdescripcion"]:"";
	$txtgrupos          = isset($_REQUEST["txtgrupos"])?$_REQUEST["txtgrupos"]:"";
	$txtceldas          = isset($_REQUEST["txtceldas"])?$_REQUEST["txtceldas"]:"";
	$txtrectificador    = isset($_REQUEST["txtrectificador"])?$_REQUEST["txtrectificador"]:"";
	$txtnave            = isset($_REQUEST["txtnave"])?$_REQUEST["txtnave"]:"";
	$parametros         = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		$consulta = "SELECT * FROM sec_web.circuitos WHERE cod_circuito = '".$txtcodigo."'";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "El Circuito Ya Existe";
			header("Location:sec_ingreso_circuito_proceso.php?activar=&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			//Inserta en Sec_Web.
			$insertar = "INSERT INTO sec_web.circuitos (cod_circuito,descripcion_circuito,cantidad_grupos,num_celdas_grupos,rectificador,nave)";
			$insertar = $insertar." VALUES ('".$txtcodigo."','".$txtdescripcion."','".$txtgrupos."','".$txtceldas."','".$txtrectificador;
			$insertar = $insertar."','".$txtnave."')";
			mysqli_query($link, $insertar);
			//echo $insertar."<br>";					
								
			header("Location:sec_ingreso_circuito_proceso.php?activar=");
		}				
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
		$actualizar = "UPDATE sec_web.circuitos SET descripcion_circuito = '".$txtdescripcion."', cantidad_grupos = '".$txtgrupos."'";
		$actualizar.= ", num_celdas_grupos = '".$txtceldas."', rectificador = '".$txtrectificador."', nave = '".$txtnave."'";
		$actualizar.= " WHERE cod_circuito = '".$txtcodigo."'";
		mysqli_query($link, $actualizar);		
				
		header("Location:sec_ingreso_circuito_proceso.php?activar=");		
	}
	
	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		foreach($valores as $c => $v)
		{	
			//Borra de Sec_Web.
			$eliminar = "DELETE FROM sec_web.circuitos WHERE cod_circuito = '".$v."'";
			mysqli_query($link, $eliminar);						
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:sec_ingreso_circuito.php?mensaje=".$mensaje);				
	}
	
	include("../principal/cerrar_sec_web.php");
?>