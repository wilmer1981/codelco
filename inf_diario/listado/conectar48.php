<?php
	include_once('../../principal/config.inc.php');
$link = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
     mysql_select_db("sea_web",$link);
?>
