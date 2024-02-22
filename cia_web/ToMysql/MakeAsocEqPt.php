<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");

$query="select t1.codigo,t2.ubi from hardware_access as t2,hardware as t1 ";
$query.="where t1.codigo=t2.codigo and t1.estado=1 and t1.tipo='PARTE';";
$result=mysql_db_query("cia_web_access",$query,$conexion);

while($resp=mysql_fetch_array($result))
{
	if(!CheckComputador($resp["codigo"],$conexion))
	{
		echo $resp["codigo"]."\tEquipo no registrado<br>";
		continue;
	}
	
	$tipo=substr($resp["ubi"],0,3);
	if($tipo!='CMP' && $tipo!='NBK')
	{
		//se cambia su estado a disponible
		$query="UPDATE hardware set estado=4 where codigo='".$resp["codigo"]."';";
		@mysql_db_query("cia_web_access",$query,$conexion);
		echo $resp["codigo"]."\t\t\t".$resp["ubi"]."\t\t\t<strong>NO Ingresado: Equipo no valido</strong><br>";
		continue;
	}
	
	//se recupera el nro de asociacion activa del equipo asociado
	$query="select nro_asociacion_activa,estado from hardware where codigo='".$resp["ubi"]."';";
	$result_tmp=mysql_db_query("cia_web_access",$query,$conexion);
	$resp_tmp=mysql_fetch_array($result_tmp);
	mysql_free_result($result_tmp);
	if($resp_tmp["estado"]!=1 && $resp_tmp["estado"]!=4)
	{
		//se cambia el estado de la parte a disponible
		$query="UPDATE hardware set estado=4 where codigo='".$resp["codigo"]."';";
		@mysql_db_query("cia_web_access",$query,$conexion);
		echo $resp["codigo"]."\t\t\t".$resp["ubi"]."\t\t\t<strong>NO Ingresado: Equipo no asignado (estado no valido)</strong><br>";
		continue;
	}
	$nro_asoc_eq=$resp_tmp["nro_asociacion_activa"];
	
	//se ingresan los datos de la nueva asociacion
	$query="INSERT INTO asoc_partes_equipos values(NULL,'".$resp["codigo"]."',CURRENT_DATE,NULL,".$nro_asoc_eq;
	$query.=",'".$resp["ubi"]."',1);";
	@mysql_db_query("cia_web_access",$query,$conexion);
	
	//se recupera el nro de asociacion generado
	$new_nro_asoc=mysql_insert_id($conexion);
	//se actualiza la informacion de la parte
	$query="UPDATE hardware set nro_asociacion_activa=".$new_nro_asoc." where codigo='".$resp["codigo"]."';";
	@mysql_db_query("cia_web_access",$query,$conexion);

	echo $resp["codigo"]."\t\t\t".$resp["ubi"]."\t\t\tIngreso Exitoso<br>";
}

?>
</body>
</html>
