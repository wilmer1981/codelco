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
	
	$valido = 0;
	if( is_numeric($txtgrupos) && is_numeric($txtceldas) && is_numeric($txtrectificador) && is_numeric($txtnave))
	{
		$valido = 1;	
	}
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		$consulta = "SELECT * FROM sec_web.circuitos WHERE cod_circuito = '".$txtcodigo."'";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "El Circuito Ya Existe";
			header("Location:sec_ingreso_circuito_proceso.php?activar=S&mensaje=".$mensaje);
		}
		else //No Existe.
		{   
			if($valido == 1)
			{
				//Inserta en Sec_Web.
				$insertar = "INSERT INTO sec_web.circuitos (cod_circuito,descripcion_circuito,cantidad_grupos,num_celdas_grupos,rectificador,nave)";
				$insertar = $insertar." VALUES ('".$txtcodigo."','".$txtdescripcion."','".$txtgrupos."','".$txtceldas."','".$txtrectificador;
				$insertar = $insertar."','".$txtnave."')";
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";				
				$mensaje = "Circuito registrado Correctamente.";					
				header("Location:sec_ingreso_circuito_proceso.php?activar=S&mensaje=".$mensaje);
			}else{
				$mensaje = "Error";					
				header("Location:sec_ingreso_circuito_proceso.php?activar=S&mensaje=".$mensaje."&opcion=N&circuito=".$txtcodigo);
				//header("Location:sec_ingreso_circuito_proceso.php?activar=S&mensaje=".$mensaje);
			}
		}
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
		$actualizar = "UPDATE sec_web.circuitos SET descripcion_circuito = '".$txtdescripcion."', cantidad_grupos = '".$txtgrupos."'";
		$actualizar.= ", num_celdas_grupos = '".$txtceldas."', rectificador = '".$txtrectificador."', nave = '".$txtnave."'";
		$actualizar.= " WHERE cod_circuito = '".$txtcodigo."'";
		mysqli_query($link, $actualizar);		
		$mensaje = "Circuito actualizado Correctamente.";			
		header("Location:sec_ingreso_circuito_proceso.php?activar=S&mensaje=".$mensaje);		
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
		header("Location:sec_ingreso_circuito.php?activar=S&mensaje=".$mensaje);				
	}
	
	include("../principal/cerrar_sec_web.php");
?>