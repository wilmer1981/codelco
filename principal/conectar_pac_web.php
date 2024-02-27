<?php
//include_once('config.inc.php');
$Server= $_SERVER['SERVER_NAME'];
if($Server=="localhost"){
	include_once('config.inc.php');
}else{
	include_once('config.php');
}
$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"pac_web");
	//mysql_select_db("pac_web", $link);
?>
