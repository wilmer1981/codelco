<?php
	include("../principal/conectar_ref_web.php");
	$dia1     = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:""; 
	$mes1     = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";  
	$ano1     = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";  

	$proceso     = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$opcion      = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$turno       = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
	$txt_turno       = isset($_REQUEST["txt_turno"])?$_REQUEST["txt_turno"]:"";
	$txt_circuito_dp = isset($_REQUEST["txt_circuito_dp"])?$_REQUEST["txt_circuito_dp"]:"";
	$txt_volumen_dp  = isset($_REQUEST["txt_volumen_dp"])?$_REQUEST["txt_volumen_dp"]:"";
	
	$fecha=$ano1."-".$mes1."-".$dia1;
	if (($proceso == "G") and ($opcion == "N"))
	{
		$consulta = "SELECT * FROM circulacion_electrolito.desc_parcial WHERE fecha='".$fecha."' and turno='".$turno."'"; 
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los datos ya fueron ingresados anteriormente";
			header("Location:desc_par.php?activar=&mensaje=".$mensaje);
		}
		else 
		{
			$insertar = "INSERT INTO circulacion_electrolito.desc_parcial (fecha,turno,circuito_dp,volumen_dp)";
			$insertar = $insertar." VALUES ('".$fecha."','".$txt_turno."','".$txt_circuito_dp."','".$txt_volumen_dp."')";		
			mysqli_query($link, $insertar);
		
			header("Location:desc_par.php?activar=");
		}
	}
	
	$fecha=$ano1."-".$mes1."-".$dia1;	
	if (($proceso == "G") and ($opcion == "M"))
	{ 
	  	 $busqueda = "SELECT * FROM circulacion_electrolito.desc_parcial WHERE fecha ='".$fecha."'";
		 //*echo $busqueda. "<br>";
		 $resultado = mysqli_query($link, $busqueda);
		 if($row=mysqli_fetch_array($resultado))
		 {
		 $fecha = explode("-",$row["fecha"]);
		 $muestra = "fecha=".$row["fecha"]."&turno=".$row["txt_turno"]."&circuito_dp=".$row["txt_circuito_dp"]."&volumen_dp=".$row["txt_volumen_dp"]."";
		 }
		 
		 $fecha=$ano1."-".$mes1."-".$dia1; 
		 $actualiza = "UPDATE circulacion_electrolito.desc_parcial set fecha ='".$fecha."', turno ='".$txt_turno."', circuito_dp ='".$txt_circuito_dp."', volumen_dp ='".$txt_volumen_dp."'";
		 $actualiza.= "where fecha= '".$fecha."'";
		 //*echo $actualiza."<br>";
		 mysqli_query($link, $actualiza);
		 header("Location:desc_par.php?".$muestra);
	}
	
	
	if ($proceso == "B")
	{
		$consulta = "select * from circulacion electrolito.desc_parcial where fecha = '".$fecha."'";
		//*echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs)
		{
	    	$linea = "mostrar=S&dia1=".$dia1."&mes1=".$mes1."&ano1=".$ano1."&fecha=".$row["fecha"]."&txt_turno=".$row["turno"]."&txt_circuito_dp=".$row["circuito_dp"]."&txt_volumen_dp".$row["volumen_dp"]."";
		}
		header("Location:desc_par.php?".$linea);
		//header("Location:desc_par.php?activar=");
	}
?>