<?php 
include("../principal/conectar_ref_web.php"); 

$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$iso       = isset($_REQUEST["iso"])?$_REQUEST["iso"]:"";
$hora      = isset($_REQUEST["hora"])?$_REQUEST["hora"]:"";
$minuto    = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:"";
$bomba     = isset($_REQUEST["bomba"])?$_REQUEST["bomba"]:"";
$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$situ      = isset($_REQUEST["situ"])?$_REQUEST["situ"]:"";
$observacion = isset($_REQUEST["observacion"])?$_REQUEST["observacion"]:"";
$cod_bomba   = isset($_REQUEST["cod_bomba"])?$_REQUEST["cod_bomba"]:"";

$consulta_fecha_actual="select left(SYSDATE(),10) as fecha2";
$resultado = mysqli_query($link, $consulta_fecha_actual);
$row1   = mysqli_fetch_array($resultado);
$fecha2 = $row1["fecha2"];

if ($Proceso == "G")
{
	$time = $hora.':'.$minuto.':'.date("s");
	$Insertar = "INSERT INTO ref_web.historia_bombas (cod_bomba, hora, situacion, observacion, fecha,iso)";
	$Insertar.= " VALUES ('".$bomba."','".$time."', '".$situ."', '".$observacion."', '".$fecha."','".$iso."')";
	//echo $Insertar;
	mysqli_query($link, $Insertar);
	header ("location:ing_bombas.php?fecha=$fecha");
}
if ($Proceso == "E")
{
	$Eliminar = "DELETE FROM ref_web.historia_bombas WHERE cod_bomba = '".$cod_bomba."' and fecha='".$fecha."' and hora='".$hora."' and iso='".$iso."'";
	//echo $Eliminar;
	mysqli_query($link, $Eliminar);
	header ("location:Bombas.php?fecha=$fecha2");
}	   


?> 
