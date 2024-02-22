<?php
   include_once('config.inc.php');
   //include_once('config.php');

	$HTTP_HOST = $_SERVER['HTTP_HOST'];

	//echo "HTTP_HOST: ".$HTTP_HOST;

	//$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,DATABASE_NAME);
	$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"proyecto_modernizacion") or die ("Error al conectar con el servidor");
	/*
	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}else{
		echo "<br>Conexion Exitosa";
	}
	*/

	//mysqli_select_db("proyecto_modernizacion", $link);
	//define("link",$link);

	//var_dump($link);

	$IP_SERV = $HTTP_HOST;
	//$IP_USER = $REMOTE_ADDR;
    $IP_USER =$_SERVER['REMOTE_ADDR'];
	$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S�bado");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
