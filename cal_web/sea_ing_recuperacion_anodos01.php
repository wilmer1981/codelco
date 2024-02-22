<?php
	include("../principal/conectar_sea_web.php");
	
	$CookieRut= $_COOKIE["CookieRut"];

	$proceso        = $_REQUEST["proceso"];
	$producto       = $_REQUEST["producto"];
	$cmbsubprod     = $_REQUEST["cmbsubprod"];
	$txtrecuperados = $_REQUEST["txtrecuperados"];

	

	$dia = $_REQUEST["dia"];
	$mes = $_REQUEST["mes"];
	$ano = $_REQUEST["ano"];
	
	if ($proceso == "G")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia.' '.date("H:i:s");
					
		$insertar = "INSERT INTO rechazos VALUES (9,'".$fecha."','',".$producto.",".$cmbsubprod.",0,0,'";
		$insertar = $insertar.$CookieRut."',".$txtrecuperados.",0,0)";
		mysqli_query($link, $insertar);
		
		$mensaje = "Anodos Recuperados Correctamente";
		header("Location:sea_ing_recuperacion_anodos.php?mensaje=".$mensaje);
	}
	
	include("../principal/cerrar_sea_web.php");
?>