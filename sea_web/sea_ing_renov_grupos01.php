<?php
include("../principal/conectar_raf_web.php");

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
$cmbturno = isset($_REQUEST["cmbturno"])?$_REQUEST["cmbturno"]:"";
$grupo1   = isset($_REQUEST["grupo1"])?$_REQUEST["grupo1"]:"";
$grupo2   = isset($_REQUEST["grupo2"])?$_REQUEST["grupo2"]:"";
$grupo3   = isset($_REQUEST["grupo3"])?$_REQUEST["grupo3"]:"";
$cmbproducto1 = isset($_REQUEST["cmbproducto1"])?$_REQUEST["cmbproducto1"]:"";
$cmbproducto2 = isset($_REQUEST["cmbproducto2"])?$_REQUEST["cmbproducto2"]:"";
$cmbproducto3 = isset($_REQUEST["cmbproducto3"])?$_REQUEST["cmbproducto3"]:"";

if($Proceso == "G")
{	

	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Elimina = "DELETE FROM sea_web.renovacion_grupos WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	mysqli_query($link, $Elimina);

	$Insertar = "INSERT INTO sea_web.renovacion_grupos (fecha,turno,grupo1,producto1,grupo2,producto2,grupo3,producto3)";
	$Insertar.= " VALUES('$Fecha','$cmbturno',$grupo1,'$cmbproducto1',$grupo2,'$cmbproducto2','$grupo3','$cmbproducto3')";
	mysqli_query($link, $Insertar);
	
	header("Location:sea_ing_renov_grupos.php");
}

?>