<?php
	include("../principal/conectar_sea_web.php");
	$CookieRut = $_COOKIE["CookieRut"];

	$proceso        = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$producto       = isset($_REQUEST["producto"])?$_REQUEST["producto"]:"";
	$cmbsubprod     = isset($_REQUEST["cmbsubprod"])?$_REQUEST["cmbsubprod"]:"";
	$txtrecuperados = isset($_REQUEST["txtrecuperados"])?$_REQUEST["txtrecuperados"]:"";
	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
	$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	
	if ($proceso == "G")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia.' '.date("H:i:s");
					
		$insertar = "INSERT INTO rechazos VALUES (9,'".$fecha."','0000-00-00 00:00:00',".$producto.",".$cmbsubprod.",0,0,'";
		$insertar = $insertar.$CookieRut."',".$txtrecuperados.",0,0)";
		mysqli_query($link, $insertar);
		
		$mensaje = "Anodos Recuperados Correctamente";
		header("Location:sea_ing_recuperacion_anodos.php?mensaje=".$mensaje);
	}
	
	include("../principal/cerrar_sea_web.php");
?>