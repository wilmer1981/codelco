<?php
	$link = mysql_connect("localhost","adm_bd","672312");
	mysql_select_db("interfaces_sap", $link);
	$IP_SERV = $HTTP_HOST;
	$IP_USER = $REMOTE_ADDR;
	
	$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","Sábado");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
