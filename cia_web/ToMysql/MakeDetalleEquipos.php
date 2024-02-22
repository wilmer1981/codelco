<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");

$query="select codigo from cia_web_access.hardware where ";
$query.="codigo like 'CMP%' OR codigo like 'NBK%' order by codigo;";
$result=mysql_query($query,$conexion);
$total=mysql_num_rows($result);

while($resp=mysql_fetch_array($result))
{
	$query="select codigo,procesador,mhz,ram,disco_duro,cant_seriales,cant_paralelos from hardware_access ";
	$query.="where codigo='".$resp["codigo"]."' order by codigo;";
	$result_tmp=mysql_db_query("cia_web_access",$query,$conexion);
	$resp_tmp=mysql_fetch_array($result_tmp);
	mysql_free_result($result_tmp);
	$procesador=strtoupper($resp_tmp["procesador"]." ".$resp_tmp["mhz"]);
	
	$query="INSERT INTO detalle_equipos values('".$resp["codigo"]."','".$procesador."',".$resp_tmp["ram"];
	$query.=",".$resp_tmp["disco_duro"].",".$resp_tmp["cant_seriales"].",".$resp_tmp["cant_paralelos"].");";
	@mysql_db_query("cia_web_access",$query,$conexion);
}
mysql_close($conexion);
echo '<br><strong>TOTAL:</strong>'.$total;
?>
</body>
</html>
