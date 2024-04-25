<?php
	include("../principal/conectar_ref_web.php");
	$proceso       = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$Circuito       = isset($_REQUEST["Circuito"])?$_REQUEST["Circuito"]:"";
	$Turno       = isset($_REQUEST["Turno"])?$_REQUEST["Turno"]:"";
	$parametros       = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$txt_fecha       = isset($_REQUEST["txt_fecha"])?$_REQUEST["txt_fecha"]:"";
	$dia1       = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
	$mes1       = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1       = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
	
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
				$insertar = "INSERT INTO ref_web.desc_parcial (fecha,turno,circuito_dp,volumen_dp)"; 
			    $insertar = $insertar."VALUES ('".$fecha."','".$detalle[1]."','".$row["nombre_subclase"]."','".$detalle[3]."')";
				mysqli_query($link, $insertar);				
			}			
			
			$mensaje = "Detalles Actualizados Correctamente";
			header("Location:traspasos.php?fecha=".$fecha);
			include("../principal/cerrar_ref_web.php");						
		}

	
	if ($proceso == "E")
	{
			$eliminar = "DELETE FROM ref_web.desc_parcial ";
			$eliminar.= " WHERE  fecha= '".$txt_fecha."'";
			$eliminar.= " and turno='".$Turno."'";
			$eliminar.= " and trim(circuito_dp)=trim('".$Circuito."')";
			//echo $eliminar."<br>";
			mysqli_query($link, $eliminar);						
		header("Location:traspasos.php?fecha=$txt_fecha");				
		include("../principal/cerrar_ref_web.php");
	}
?>