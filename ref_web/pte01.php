<?php
	include("../principal/conectar_ref_web.php");
	
	$fecha=$ano1."-".$mes1."-".$dia1;
	if ($proceso == "G") and ($opcion == "N"))
	{
		$consulta = "SELECT * FROM circulacion_electrolito.tratamiento_electrolito WHERE fecha = '".$fecha."' AND turno = '".$turno."'";
	    $rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los Datos ya Fueron ingresados Anteriormente";
			header("Location:pte.php?activar=&mensaje=".$mensaje);
		}
		else 
		{
			$insertar = "INSERT INTO circulacion_electrolito.tratamiento_electrolito (fecha,turno,destino_pte,circuito_pte,volumen_pte)";
			$insertar = $insertar." VALUES ('".$fecha."','".$txt_turno."','".$txt_destino_pte."','".$txt_circuito_pte."','".$txt_volumen_pte."')";
			echo $insertar."<br>";		
			mysqli_query($link, $insertar);
		
			header("Location:pte.php?activar=");
		}
	}
	
	$fecha=$ano1."-".$mes1."-".$dia1;	
	if (($proceso == "G") and ($opcion == "M"))
	{ 
	  	 $busqueda = "SELECT * FROM circulacion_electrolito.tratamiento electrolito WHERE fecha ='".$fecha."'";
		 //*echo $busqueda. "<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 if($row=mysqli_fetch_array($resultado))
		 {
		 $fecha = explode("-",$row["fecha"]);
		 $muestra = "fecha=".$row["fecha"]."&turno=".$row[txt_turno]."&destino_pte=".$row[txt_destino_pte]."&circuito_pte=".$row[txt_circuito_pte]."&volumen_pte=".$row[txt_volumen_pte]."";
		 }
		 
		 $fecha=$ano1."-".$mes1."-".$dia1; 
		 $actualiza = "UPDATE circulacion_electrolito.tratamiento_electrolito set fecha ='".$fecha."', turno ='".$txt_turno."', destino_pte ='".$txt_destino_pte."', circuito_pte ='".$txt_circuito_pte."', volumen_pte ='".$txt_volumen_pte."'";
		 $actualiza.= "where fecha= '".$fecha."'";
		 //*echo $actualiza."<br>";
		 mysqli_query($link, $actualiza);
		 header("Location:pte.php?".$muestra);
	 
	}
	
	
	if ($proceso == "B")
	{
		$consulta = "select * from circulacion electrolito.tratamiento_electrolito where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
	    	$linea = "mostrar=S&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row["fecha"]."&txt_turno=".$row[turno]."&txt_destino_pte=".$row[destino_pte]."&txt_circuito_pte=".$row[circuito_pte]."&txt_volumen_pte".$row[volumen_pte]."";
		}
		 header("Location:pte.php?activar=");
	}
?>