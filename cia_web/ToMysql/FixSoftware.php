<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");
$query="select cod_antiguo from software_access order by cod_antiguo;";
$result=mysql_db_query("cia_web_access",$query,$conexion);
while($resp=mysql_fetch_array($result))
{
	$cod_antiguo=FixCodigo($resp["cod_antiguo"]);
	$query="UPDATE software_access set cod_antiguo='".$cod_antiguo."' where cod_antiguo='".$resp["cod_antiguo"]."';";
	if(!mysql_db_query("cia_web_access",$query,$conexion))
		echo '<strong>NO FIX: '.$resp["cod_antiguo"].'</strong><br>';
}

echo '<br><br><br>';
mysql_free_result($result);
$query="select cod_sw,cod_equipo from asoc_sw_equipo_access order by cod_sw;";
$result=mysql_db_query("cia_web_access",$query,$conexion);
while($resp=mysql_fetch_array($result))
{
	$cod_sw=FixCodigo($resp["cod_sw"]);
	$cod_equipo=FixCodigo($resp["cod_equipo"]);
	$query="UPDATE asoc_sw_equipo_access set cod_sw='".$cod_sw."',cod_equipo='".$cod_equipo."' ";
	$query.="where cod_sw='".$resp["cod_sw"]."' and cod_equipo='".$resp["cod_equipo"]."';";
	if(!mysql_db_query("cia_web_access",$query,$conexion))
		echo '<strong>NO FIX: '.$resp["cod_sw"].'</strong><br>';
}

mysqli_close($conexion);
?>
</body>
</html>
