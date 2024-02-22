<?php
include_once('../principal/config.inc.php');
$conexion = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
	if (! @mysql_select_db("MET_WEB",$conexion)){
   		echo "No se pudo conectar correctamente con la Base de datos";
   		exit();
	}  
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>