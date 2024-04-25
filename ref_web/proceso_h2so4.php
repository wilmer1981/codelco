<?php
	include("../principal/conectar_ref_web.php");

	$proceso     = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$txt_fecha   = isset($_REQUEST["txt_fecha"])?$_REQUEST["txt_fecha"]:"";
	$Turno       = isset($_REQUEST["Turno"])?$_REQUEST["Turno"]:"";
	$Circuito    = isset($_REQUEST["Circuito"])?$_REQUEST["Circuito"]:"";
	$parametros  = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$dia1       = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
	$mes1       = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1       = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";

	$buscar       = isset($_REQUEST["buscar"])?$_REQUEST["buscar"]:"";
	$txtbuscar       = isset($_REQUEST["txtbuscar"])?$_REQUEST["txtbuscar"]:"";
	
	if ($proceso == "G")
	{
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		//Ingresa los detalles de los rechazos y recuperables. 
		$arreglo = explode("/",$parametros); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$detalle = explode("~",$valor); //check - turno - circuito - volumen. 
			
			$consulta = "SELECT nombre_subclase FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3100 and cod_subclase='".$detalle[2]."' ORDER BY cod_clase";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			
			$insertar = "INSERT INTO ref_web.electrolito (fecha,turno,circuito_h2so4,volumen_h2so4)"; 
			$insertar = $insertar."VALUES ('".$fecha."','".$detalle[1]."','".$row["nombre_subclase"]."','".$detalle[3]."')";
			//echo $insertar;			
			mysqli_query($link, $insertar);
		}			
		
		$mensaje = "Detalles Actualizados Correctamente";						
		header("Location:traspasos.php?fecha=".$fecha);		
		include("../principal/conectar_ref_web.php");
	}
		  
	if ($proceso == "E")
	{
		
		$eliminar = "DELETE FROM ref_web.electrolito ";
		$eliminar.= " WHERE  fecha= '".$txt_fecha."'";
		$eliminar.= " and turno='".$Turno."'";
		$eliminar.= " and trim(circuito_h2so4)=trim('".$Circuito."')";
		mysqli_query($link, $eliminar);						
			
		header("Location:traspasos.php?fecha=$txt_fecha");				
		include("../principal/cerrar_ref_web.php");
	}

?>