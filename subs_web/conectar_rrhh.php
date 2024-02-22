<?
	//$link_rrhh = mysql_connect("10.56.11.7","user_gasto","123ve62tu");
	$link_rrhh = mysql_connect("localhost","adm_bd","672312");
	mysql_SELECT_db("bd_rrhh", $link_rrhh);
	$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S�bado");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
