<?php
include_once('config.inc.php');
$link = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
mysql_select_db("bdcontratos",$link);
$Dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
$Meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
