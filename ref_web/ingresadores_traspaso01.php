<?php
	include("../principal/conectar_ref_web.php");
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$turno   = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
	$Valor1  = isset($_REQUEST["Valor1"])?$_REQUEST["Valor1"]:"";
	$Valor2  = isset($_REQUEST["Valor2"])?$_REQUEST["Valor2"]:"";
	$Valor3  = isset($_REQUEST["Valor3"])?$_REQUEST["Valor3"]:"";
	$Valor4  = isset($_REQUEST["Valor4"])?$_REQUEST["Valor4"]:"";
	
	if ($Proceso == "G")
	{
		$fecha = $ano1.'-'.$mes1.'-'.$dia1;
		$Turno=$turno;
		//TRASPASOS H2SO4
		//Ingresa los detalles de los rechazos y recuperables. 
		$Col=1;
		$arreglo = explode("~",$Valor1); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$VolM3 = $valor;
			if($VolM3!='')
			{
				if($Col==7)
					$Nombre="HM";
				else
					$Nombre="Circuito".$Col;
				$insertar = "INSERT INTO ref_web.electrolito (fecha,turno,circuito_h2so4,volumen_h2so4)"; 
				$insertar = $insertar."VALUES ('".$fecha."','".$Turno."','".$Nombre."','".$VolM3."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}	
			$Col++;
		}
		//TRASPASOS DESC.PARCIAL			
		$Col=1;
		$arreglo = explode("~",$Valor2); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$VolM3 = $valor;
			if($VolM3!='')
			{
				if($Col==7)
					$Nombre="HM";
				else
					$Nombre="Circuito".$Col;
				$insertar = "INSERT INTO ref_web.desc_parcial (fecha,turno,circuito_dp,volumen_dp)"; 
			    $insertar = $insertar."VALUES ('".$fecha."','".$Turno."','".$Nombre."','".$VolM3."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}	
			$Col++;
		}			
		//TRASPASOS ELECTROLITO PROCESO			
		$Col=1;
		$arreglo = explode("~",$Valor3); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$VolM3 = $valor;
			if($VolM3!='')
			{
				if($Col==7)
					$Nombre="HM";
				else
					$Nombre="Circuito".$Col;
				$insertar = "INSERT INTO ref_web.tratamiento_electrolito (fecha,turno,circuito_pte,destino_pte,volumen_pte)"; 
				$insertar = $insertar."VALUES ('".$fecha."','".$Turno."','".$Nombre."','Proceso','".$VolM3."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}	
			$Col++;
		}			
		//TRASPASOS ELECTROLITO VENTAS			
		$Col=1;
		$arreglo = explode("~",$Valor4); //Separa los parametros en un array.
		reset($arreglo);					
		foreach($arreglo as $clave => $valor)
		{		
			$VolM3 = $valor;
			if($VolM3!='')
			{
				if($Col==7)
					$Nombre="HM";
				else
					$Nombre="Circuito".$Col;
				$insertar = "INSERT INTO ref_web.tratamiento_electrolito (fecha,turno,circuito_pte,destino_pte,volumen_pte)"; 
				$insertar = $insertar."VALUES ('".$fecha."','".$Turno."','".$Nombre."','Venta','".$VolM3."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}	
			$Col++;
		}			
		$mensaje = "Detalles Actualizados Correctamente";						
		header("Location:traspasos.php?fecha=".$fecha);		
		include("../principal/conectar_ref_web.php");
	}

?>