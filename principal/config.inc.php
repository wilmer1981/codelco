<?php
//ini_set('default_charset','iso-8859-1');

//VARIABLES DE CONEXION A BASE DE DATOS
define("CONEXION_HOST_BD",'localhost');
define("CONEXION_HOST_USER",'root');
define("CONEXION_HOST_PWD",'');
//VARIABLES DE SERVIDOR WEB
define("HTTP_SERVER",strtoupper($_SERVER['HTTP_HOST']));

//$link=mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
//mysqli_query($link, "SET character_set_results='iso-8859-1',character_set_client='iso-8859-1',character_set_connection='iso-8859-1',character_set_database='iso-8859-1'",$link);