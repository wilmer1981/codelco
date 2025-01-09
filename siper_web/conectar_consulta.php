<?php
   // $link = mysqli_connect("vevmmysqlp01","adm_web","codweb2015");
	//mysql_select_db("sgrv", $link);
	 include_once('../principal/config.inc.php');
	$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"sgrv") or die ("Error al conectar con el servidor");
?>
