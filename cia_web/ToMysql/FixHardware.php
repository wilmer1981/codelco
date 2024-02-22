<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");

//primero se arreglan los codigos y los nros de serie
$query="select * from cia_web_access.hardware_access order by codigo;";
$result=mysql_query($query,$conexion);

while($resp=mysql_fetch_array($result))
{
	$codigo=FixCodigo($resp["codigo"]);
	$nro_serie=strtoupper($resp["nro_serie"]);
	$rut_proveedor=FixRut($resp["rut_proveedor"]);
	$rut_usuario=FixRut($resp["rut_usuario"]);
	$tipo=CheckTipo($resp["codigo"],$conexion);
	
	//se verifica si hay elementos repetidos; si los hay, se borran
	$ubi=$resp["ubi"];
	$var=CheckDataHardware($resp["codigo"],$conexion);
	echo $codigo."\t\t\t".$tipo."\t\t\t".$var;
	
	if($var>1)
	{
		echo "\t\t<strong>Repetido</strong>";
		$resp_tmp=mysql_fetch_array($result);
		$query="delete from hardware_access where nro=".$resp_tmp["nro"].";";
		if(mysql_db_query("cia_web_access",$query,$conexion))
			echo 'BORRADO';
		if($tipo=="PARTE")
			$ubi=$resp_tmp["ubi"];
	}
	echo '<br>';
	$cant=strlen($ubi);
	if($tipo=='PARTE' && $cant > 4)
		$ubi=FixCodigo($ubi);
	
	$query="UPDATE cia_web_access.hardware_access set codigo='".$codigo."',nro_serie='".$nro_serie."',";
	$query.="rut_usuario='".$rut_usuario."', rut_proveedor='".$rut_proveedor."',ubi='".$ubi."' ";
	$query.="where codigo='".$resp["codigo"]."';";
	@mysql_query($query,$conexion);
}

mysql_free_result($result);
mysql_close($conexion);
?>
</body>
</html>
