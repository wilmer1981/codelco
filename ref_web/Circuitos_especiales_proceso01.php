<?php
	include("../principal/conectar_sec_web.php");
	
	$proceso       = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$opcion        = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$txtcodigo     = isset($_REQUEST["txtcodigo"])?$_REQUEST["txtcodigo"]:"";
	$txtdescripcion     = isset($_REQUEST["txtdescripcion"])?$_REQUEST["txtdescripcion"]:"";
	$txtgrupos          = isset($_REQUEST["txtgrupos"])?$_REQUEST["txtgrupos"]:"";
	$txtceldas          = isset($_REQUEST["txtceldas"])?$_REQUEST["txtceldas"]:"";
	$txtcatodos         = isset($_REQUEST["txtcatodos"])?$_REQUEST["txtcatodos"]:"";
	$txtrectificador    = isset($_REQUEST["txtrectificador"])?$_REQUEST["txtrectificador"]:"";
	$txtnave            = isset($_REQUEST["txtnave"])?$_REQUEST["txtnave"]:"";
	$parametros         = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";

	$valido = 0;
	if( is_numeric($txtgrupos) )
	{
		$valido = 1;	
	}	
	
	if (($proceso == "G") and ($opcion == "N"))
	{	
		$consulta = "SELECT * FROM ref_web.circuitos_especiales WHERE cod_circuito = '".$txtcodigo."'";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Si Existe.
		{	
			$mensaje = "El Circuito Ya Existe";
			header("Location:Circuitos_especiales_proceso.php?activar=S&mensaje=".$mensaje);
		}
		else //No Existe.
		{
			//Inserta en Sec_Web.
			if($valido==1){
				$insertar = "INSERT INTO ref_web.circuitos_especiales (cod_circuito,descripcion_circuito,cantidad_grupos,num_celdas_grupos,num_catodos_celda,rectificador,nave)";
				$insertar = $insertar." VALUES ('".$txtcodigo."','".$txtdescripcion."','".$txtgrupos."','".$txtceldas."','".$txtcatodos."','".$txtrectificador;
				$insertar = $insertar."','".$txtnave."')";
				mysqli_query($link, $insertar);
				//echo $insertar."<br>";
				$mensaje = "Registro guardado exitosamente.";
				header("Location:Circuitos_especiales_proceso.php?activar=S&mensaje=".$mensaje);				
			}else{
				$mensaje = "Error";
				header("Location:Circuitos_especiales_proceso.php?opcion=N&activar=S&mensaje=".$mensaje);	
			}
		}		
	}
	
	if (($proceso == "G") and ($opcion == "M"))
	{
		$actualizar = "UPDATE ref_web.circuitos_especiales SET descripcion_circuito = '".$txtdescripcion."', cantidad_grupos = '".$txtgrupos."'";
		$actualizar.= ", num_celdas_grupos = '".$txtceldas."',num_catodos_celda = '".$txtcatodos."', rectificador = '".$txtrectificador."', nave = '".$txtnave."'";
		$actualizar.= " WHERE cod_circuito = '".$txtcodigo."'";
		mysqli_query($link, $actualizar);		
				
		header("Location:Circuitos_especiales_proceso.php?activar=S");		
	}
	
	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		foreach($valores as $c => $v)
		{	
			//Borra de Sec_Web.
			$eliminar = "DELETE FROM ref_web.circuitos_especiales WHERE cod_circuito = '".$v."'";
			mysqli_query($link, $eliminar);						
		}
		
		$mensaje = "Circuito(s) Eliminado(s) Correctamente";
		header("Location:Circuitos_especiales.php?mensaje=".$mensaje);				
	}
	
	include("../principal/cerrar_sec_web.php");
?>