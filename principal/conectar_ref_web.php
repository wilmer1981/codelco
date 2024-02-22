<?php
//include_once('config.inc.php');
//$link = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
	//mysql_select_db("ref_web", $link);

$Server= $_SERVER['SERVER_NAME'];
if($Server=="localhost"){
	include_once('config.inc.php');
}else{
	include_once('config.php');
}

$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"ref_web");
?>
