<?php
//include_once('config.php');
$Server= $_SERVER['SERVER_NAME'];
if($Server=="localhost"){
	include_once('config.inc.php');
}else{
	include_once('config.php');
}

$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"sec_web");

$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S�bado");
$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>
