<?php
include_once('config.inc.php');
$link = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
	mysql_select_db("sef", $link);
?>