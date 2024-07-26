<?php
include("../principal/conectar_sea_web.php");

$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");

$Vent      = isset($_REQUEST["Vent"])?$_REQUEST["Vent"]:"";
$HMadres   = isset($_REQUEST["HMadres"])?$_REQUEST["HMadres"]:"";
$Teniente  = isset($_REQUEST["Teniente"])?$_REQUEST["Teniente"]:"";
$FHVL      = isset($_REQUEST["FHVL"])?$_REQUEST["FHVL"]:"";
$Disputada = isset($_REQUEST["Disputada"])?$_REQUEST["Disputada"]:"";
$Restos    = isset($_REQUEST["Restos"])?$_REQUEST["Restos"]:"";

if($Proceso == "G")
{
	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;

	if($Vent == '')
		$Vent = 0;		

	if($HMadres == '')
		$HMadres = 0;		

	if($Teniente == '')
		$Teniente = 0;		

	if($FHVL == 0)
		$FHVL = 0;		

	if($Disputada == '')
		$Disputada = 0;		

	if($Restos == '')
		$Restos = 0;		

	$Fecha = $Ano.'-'.$Mes.'-01';
	
	$Elimina = "DELETE FROM sea_web.inf_prod_inter WHERE fecha = '$Fecha' AND tipo = 'P'";
	$rs = mysqli_query($link, $Elimina);

	$Inserta = "INSERT INTO sea_web.inf_prod_inter (Fecha,Tipo,Vent,HMadres,Teniente,FHVL,Disputada,Restos)";
	$Inserta = $Inserta." VALUES('$Fecha','P', $Vent,$HMadres,$Teniente,$FHVL,$Disputada,$Restos)";
	mysqli_query($link, $Inserta);

	
	$linea = "Proceso=B&Ano=".$Ano."&Mes=".$Mes;
	header("Location:sea_ing_proyecciones.php?".$linea);
	
}
?>