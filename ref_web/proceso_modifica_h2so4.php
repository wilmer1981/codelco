<?php
	include("../principal/conectar_ref_web.php");

	$proceso       = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$mostrar       = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$txt_volumen_h2so4  = isset($_REQUEST["txt_volumen_h2so4"])?$_REQUEST["txt_volumen_h2so4"]:"";
	$txt_fecha       = isset($_REQUEST["txt_fecha"])?$_REQUEST["txt_fecha"]:"";
	$txt_circuito    = isset($_REQUEST["txt_circuito"])?$_REQUEST["txt_circuito"]:"";
      
	if ($proceso == "M")
		
	{   
	   	$actualizar = "UPDATE ref_web.electrolito SET volumen_h2so4 = '".$txt_volumen_h2so4."'";
		$actualizar.= " WHERE fecha = '".$txt_fecha."'";
		$actualizar.= " and circuito_h2so4= '".$txt_circuito."'";
		mysqli_query($link, $actualizar);		
    	header("Location:traspasos.php?fecha=$txt_fecha");		
	}

?>