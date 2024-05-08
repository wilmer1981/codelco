<?php
	include("../principal/conectar_principal.php");

	$TxtIVA     = isset($_REQUEST["TxtIVA"])?$_REQUEST["TxtIVA"]:"";
	$TxtDolar   = isset($_REQUEST["TxtDolar"])?$_REQUEST["TxtDolar"]:"";
	
	$Modificar="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='$TxtIVA' where cod_clase='15004' and cod_subclase='1'";
	mysqli_query($link, $Modificar);
	$Modificar="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='$TxtDolar' where cod_clase='15005' and cod_subclase='1'";
	mysqli_query($link, $Modificar);
	header("location:age_parametros.php");
?>