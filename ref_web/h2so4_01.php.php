<?php
	include("../principal/conectar_ref_web.php");
	
	$fecha=$ano1."-".$mes1."-".$dia1;
	if ($proceso == "G") //and ($opcion == "N"))
	{
		$consulta = "SELECT * FROM circulacion_electrolito.electrolito	WHERE fecha='".$fecha."' and turno='".$turno."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los Datos ya fueron Ingresados Anteriormente";
			header("Location:h2so4.php?activar=&mensaje=".$mensaje);
		}
		else 
		{
			$insertar = "INSERT INTO circulacion_electrolito.electrolito (fecha,turno,circuito_h2so4,volumen_h2so4)";
			$insertar = $insertar." VALUES ('".$fecha."','".$txt_turno."','".$txt_circuito_h2so4."','".$txt_volumen_h2so4."')";
			echo $insertar."<br>";		
			mysqli_query($link, $insertar);
			header("Location:h2so4.php?activar=");
		}
	}
	
	$fecha=$ano1."-".$mes1."-".$dia1;	
	if (($proceso == "G") and ($opcion == "M"))
	{ 
	     $busqueda = "SELECT * FROM ccirculacion_electrolito.electrolito WHERE fecha ='".$fecha."'";
		 //*echo $busqueda. "<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 if($row=mysqli_fetch_array($resultado))
		 {
		 $fecha = explode("-",$row["fecha"]);
		 $muestra = "fecha=".$row["fecha"]."&turno=".$row[txt_turno]."&circuito_h2so4=".$row[txt_circuito_h2so4]."&volumen_h2so4=".$row[txt_volumen_h2so4]."";
		 }
		 
		 $fecha=$ano1."-".$mes1."-".$dia1; 
		 $actualiza = "UPDATE circulacion_electrolito.electrolito set fecha ='".$fecha."', turno ='".$txt_turno."', circuito_h2so4 ='".$txt_circuito_h2so4."', volumen_h2o4 ='".$txt_volumen_h2so4."'";
		 $actualiza.= "where fecha= '".$fecha."'";
		 //*echo $actualiza."<br>";
		 mysqli_query($link, $actualiza);
		 header("Location:h2so4.php?".$muestra);
	 
	}
	
	
	if ($proceso == "B")
	{
		$consulta = "select * from circulacion_electrolito.electrolito where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
	    	$muestra = "mostrar=S&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row["fecha"]."&txt_turno=".$row[turno]."&txt_circuito_h2so4=".$row[circuito_h2so4]."&txt_volumen_h2so4=".$row[volumen_h2so4]."";
		}
		 header("Location:h2so4.php?".$muestra);
	}
?>		
