<?php
	include("../principal/conectar_ref_web.php");
	
	if ($proceso == "G")
	{
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		//Ingresa los detalles de los rechazos y recuperables. 
		$arreglo = explode("/",$parametros); //Separa los parametros en un array.
		reset($arreglo);					
		while (list($clave, $valor) = each($arreglo))
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