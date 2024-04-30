<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");
$query="select * from asoc_sw_equipo_access order by cod_sw;";
$result=mysql_db_query("cia_web_access",$query,$conexion);

while($resp=mysql_fetch_array($result))
{
	$cod_sw=CheckSoftware($resp["cod_sw"],$conexion);
	if($cod_sw=='NONE')
	{
		echo '<strong>Software no registrado: '.$resp["cod_sw"].'</strong><br>';
		continue;
	}
	if(!CheckComputador($resp["cod_equipo"],$conexion))
	{
		echo '<strong>Computador no registrado: '.$resp["cod_equipo"].'</strong><br>';
		continue;
	}
	
	$query="INSERT INTO asoc_sw_equipo values('".$cod_sw."','".$resp["cod_equipo"]."',CURRENT_DATE);";
	if(!mysql_db_query("cia_web_access",$query,$conexion))
		echo '<strong>ingreso fallido: '.$cod_sw.'/'.$resp["cod_equipo"].'<br></strong>';
}
mysqli_close($conexion);
?>
</body>
</html>
