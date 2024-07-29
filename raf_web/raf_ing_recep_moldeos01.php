<?php
include("../principal/conectar_raf_web.php");

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
$cmbturno = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";

$ton_proy1 = isset($_REQUEST["ton_proy1"])?$_REQUEST["ton_proy1"]:"";
$ton_proy2 = isset($_REQUEST["ton_proy2"])?$_REQUEST["ton_proy2"]:"";
$ton_proy3 = isset($_REQUEST["ton_proy3"])?$_REQUEST["ton_proy3"]:"";
$hornada1  = isset($_REQUEST["hornada1"])?$_REQUEST["hornada1"]:"";
$hornada2  = isset($_REQUEST["hornada2"])?$_REQUEST["hornada2"]:"";
$hornada3  = isset($_REQUEST["hornada3"])?$_REQUEST["hornada3"]:"";
$observacion = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";

if($Proceso == "G")
{	
	if($hornada1 == '')
	   $hornada1 = 0;		

	if($ton_proy1 == '')
		$ton_proy1 = 0;

	if($hornada2 == '')
	   $hornada2 = 0;		

	if($ton_proy2 == '')
		$ton_proy2 = 0;

	if($hornada3 == '')
	   $hornada3 = 0;		

	if($ton_proy3 == '')
		$ton_proy3 = 0;

	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Elimina = "DELETE FROM raf_web.proyeccion_moldeo WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	mysqli_query($link, $Elimina);

	$Insertar = "INSERT INTO raf_web.proyeccion_moldeo (fecha,turno,hornada1,ton_proy1,hornada2,ton_proy2,hornada3,ton_proy3,observacion)";
	$Insertar.= " VALUES('$Fecha','$cmbturno',$hornada1,$ton_proy1,$hornada2,$ton_proy2,$hornada3,$ton_proy3,'$observacion')";
	mysqli_query($link, $Insertar);
		
	$Actualiza = "UPDATE raf_web.proyeccion_moldeo set observacion = '$observacion'";
	$Actualiza.= " WHERE fecha = '$Fecha'";	
	mysqli_query($link,$Actualiza);	
    header("Location:raf_ing_recep_moldeos.php");
}

?>