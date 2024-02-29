<?php 	
 	include("../principal/conectar_sec_web.php");

	$Grabar    = $_REQUEST["Grabar"];

	$TxtGrupo   = $_REQUEST["TxtGrupo"];
	$TxtFecha   = $_REQUEST["TxtFecha"];
	$TxtFechaNueva = $_REQUEST["TxtFechaNueva"];
	$TxtHora   = $_REQUEST["TxtHora"];
	$TxtMinuto = $_REQUEST["TxtMinuto"];

	$Hora=str_pad($TxtHora,2,"0",STR_PAD_LEFT).":".str_pad($TxtMinuto,2,"0",STR_PAD_LEFT);

	$Actualizar="UPDATE sec_web.produccion_catodo set fecha_produccion='".$TxtFechaNueva."',hora='".$Hora."'";
	$Actualizar.="where cod_grupo= '".$TxtGrupo."' and fecha_produccion='".$TxtFecha."'";
	//echo $Actualizar;
	mysqli_query($link, $Actualizar);
	header("location:sec_modifica_fecha_hora_prod.php?Mensaje=S");
?>
