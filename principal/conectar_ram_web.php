<?php
//include_once('config.inc.php');
//$link = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
//mysql_select_db("ram_web", $link);
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];

$Server= $_SERVER['SERVER_NAME'];
if($Server=="localhost"){
	include_once('config.inc.php');
}else{
	include_once('config.php');
}

$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"ram_web");
	
?>
