<?php
include_once('config.inc.php');
    $link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"imp_web");
	//mysql_select_db("imp_web", $link);

	//VARIABLES GLOBALES
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$ColorFondo1 = "#FFFFFF";
	$ColorTabla1 = "#CCCCCC";
	$ColorTabla2 = "#000099";
	$ColorTabla3 = "#000099";
	$ColorTabla4 = "#CCCCCC";
	
?>
