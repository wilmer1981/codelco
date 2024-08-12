<?php
include("../principal/conectar_ram_web.php"); 

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$ano1  = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
$mes1  = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
$dia1  = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
$hr1   = isset($_REQUEST["hr1"])?$_REQUEST["hr1"]:"";
$min1  = isset($_REQUEST["min1"])?$_REQUEST["min1"]:"";

$ano2  = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:"";
$mes2  = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:"";
$dia2  = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:"";
$hr2   = isset($_REQUEST["hr2"])?$_REQUEST["hr2"]:"";
$min2  = isset($_REQUEST["min2"])?$_REQUEST["min2"]:"";

$ano3  = isset($_REQUEST["ano3"])?$_REQUEST["ano3"]:"";
$mes3  = isset($_REQUEST["mes3"])?$_REQUEST["mes3"]:"";
$dia3  = isset($_REQUEST["dia2"])?$_REQUEST["dia3"]:"";
$hr3   = isset($_REQUEST["hr3"])?$_REQUEST["hr3"]:"";
$min3  = isset($_REQUEST["min3"])?$_REQUEST["min3"]:"";

$ano4  = isset($_REQUEST["ano4"])?$_REQUEST["ano4"]:"";
$mes4  = isset($_REQUEST["mes4"])?$_REQUEST["mes4"]:"";
$dia4  = isset($_REQUEST["dia4"])?$_REQUEST["dia4"]:"";
$hr4   = isset($_REQUEST["hr4"])?$_REQUEST["hr4"]:"";
$min4  = isset($_REQUEST["min4"])?$_REQUEST["min4"]:"";



if($Proceso == "G")
{
	//Traspaso
	$fecha_ini_recep = $ano1.'-'.$mes1.'-'.$dia1.' '.$hr1.':'.$min1.':00';
	$fecha_ter_recep = $ano2.'-'.$mes2.'-'.$dia2.' '.$hr2.':'.$min2.':00';
	
	//Recepci�n
	$fecha_ini_tra = $ano3.'-'.$mes3.'-'.$dia3.' '.$hr3.':'.$min3.':00';
	$fecha_ter_tra = $ano4.'-'.$mes4.'-'.$dia4.' '.$hr4.':'.$min4.':00';

	$Actualizar = "UPDATE parametros SET FECHA_INI_TRA = '$fecha_ini_tra', FECHA_TER_TRA = '$fecha_ter_tra', 
	                                     FECHA_INI_REC = '$fecha_ini_recep', FECHA_TER_REC = '$fecha_ter_recep'";
										 
    mysqli_query($link, $Actualizar);  
   
  header("Location:ram_ing_validacion.php");
}
?>