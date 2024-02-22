<?php
include_once('config.inc.php');
//include_once('config.php');
//$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"pmn_web") or die ("Error al conectar con el servidor");

	//mysql_select_db("pmn_web", $link);
	//VARIABLES GLOBALES
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$DiaActual = date("j");
	$MesActual = date("n");
	$AnoActual = date("Y");
	$HoraActual = date("H");
	$MinutoActual = date("i");
	$ColorFondo1 = "#FFFFFF";
	$ColorTabla1 = "#CCCCCC";
	$ColorTabla2 = "#000099";
	$ColorTabla3 = "#000099";
	$ColorTabla4 = "#CCCCCC";
	
?>
