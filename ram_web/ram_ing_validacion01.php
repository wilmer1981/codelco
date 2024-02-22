<?php
include("../principal/conectar_ram_web.php"); 
if($Proceso == "G")
{
	//Traspaso
	$fecha_ini_recep = $ano1.'-'.$mes1.'-'.$dia1.' '.$hr1.':'.$min1.':00';
	$fecha_ter_recep = $ano2.'-'.$mes2.'-'.$dia2.' '.$hr2.':'.$min2.':00';
	
	//Recepción
	$fecha_ini_tra = $ano3.'-'.$mes3.'-'.$dia3.' '.$hr3.':'.$min3.':00';
	$fecha_ter_tra = $ano4.'-'.$mes4.'-'.$dia4.' '.$hr4.':'.$min4.':00';

	$Actualizar = "UPDATE parametros SET FECHA_INI_TRA = '$fecha_ini_tra', FECHA_TER_TRA = '$fecha_ter_tra', 
	                                     FECHA_INI_REC = '$fecha_ini_recep', FECHA_TER_REC = '$fecha_ter_recep'";
										 
    mysqli_query($link, $Actualizar);  
   
  header("Location:ram_ing_validacion.php");
}
?>