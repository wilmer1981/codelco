<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");
$query="select t2.codigo,t2.cc,t2.ubi,t2.rut_usuario from hardware as t1, hardware_access as t2";
$query.=" where t1.tipo='EQUIPO' and t1.estado=1 and t2.codigo=t1.codigo;";
$result=mysql_db_query("cia_web_access",$query,$conexion);
$total=mysql_num_rows($result);
$cant_ing=$cant_omi=0;
while($resp=mysql_fetch_array($result))
{
	//se comprueba el existencia del usuario
	if(!CheckUser($resp["rut_usuario"],$conexion))
	{
		echo '<strong>Cod: '.$resp["codigo"]."\t\t\t".'Usuario no registrado: '.$resp["rut_usuario"].'</strong><br>';
		$cant_omi++;
		continue;
	}
	
	//se comprueba la ubicacion
	if(!CheckUbi($resp["ubi"],$conexion) || strlen($resp["ubi"])!=4)
	{
		echo '<strong>Cod: '.$resp["codigo"]."\t\t\t".'Ubicacion no existe: '.$resp["ubi"].'</strong><br>';
		$cant_omi++;
		continue;
	}
	
	$query="INSERT INTO asoc_equipos_usuarios values(NULL,'".$resp["codigo"]."','".$resp["ubi"]."',";
	$query.="'".$resp["rut_usuario"]."',CURRENT_DATE,NULL,1);";
	if(mysql_db_query("cia_web_access",$query,$conexion))
	{
		//se actualiza la informacion del equipo con el nro de asociacion activa
		$nro_asoc=mysql_insert_id($conexion);
		$query="UPDATE hardware set nro_asociacion_activa=".$nro_asoc." where codigo='".$resp["codigo"]."';";
		@mysql_db_query("cia_web_access",$query,$conexion);
	}
	else
		echo '<strong>Fallo ingreso: '.$resp["codigo"]."\t\t\t".$resp["rut_usuario"]."<br></strong>";
	$cant_ing++;
}
echo "<br><br><strong>TOTAL:\t\t</strong>".$total;
echo "<br>Cant Ingresados:\t\t".$cant_ing;
echo "<br>Cant Omitidos:\t\t".$cant_omi;
mysql_close($conexion);
?>
</body>
</html>
