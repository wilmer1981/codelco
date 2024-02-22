<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");

$query="select * from cia_web_access.software_access order by cod_antiguo;";
$result=mysql_query($query,$conexion);
$total=mysql_num_rows($result);

while($resp=mysql_fetch_array($result))
{
	//se genera el codigo para el nuevo software
	$codigo=MakeCodigo("SWF",$conexion);
	$marca=strtoupper($resp["marca"]);
	$nombre=strtoupper($resp["nombre"]);
	$version_sw=strtoupper($resp["version_sw"]);
	$fecha_compra=$resp["fecha_compra"];
	$nro_factura=strtoupper($resp["nro_factura"]);
	$descripcion=strtoupper($resp["descripcion"]);
	$rut_proveedor=FixRut($resp["rut_proveedor"]);
	
	if($rut_proveedor!="")
	{
		if(!CheckProveedor($rut_proveedor,$conexion))
		{
			echo '<strong>FAllo ingreso: '.$codigo.'Proveedor no registrado</strong><br>';
			continue;
		}
	}
	
	$query="INSERT INTO software values('".$codigo."','".$marca."','".$nombre."','".$version_sw."','".$resp["tipo"]."'";
	if($fecha_compra=="")
		$query.=",NULL,";
	else
		$query.=",'".$fecha_compra."',";
	$query.="'".$nro_factura."','".$rut_proveedor."','".$descripcion."');";
	if(mysql_db_query("cia_web_access",$query,$conexion))
	{
		echo 'Ingresado con exito : '.$codigo;
		$query="UPDATE software_access set codigo='".$codigo."' where cod_antiguo='".$resp["cod_antiguo"]."';";
		@mysql_db_query("cia_web_access",$query,$conexion);
	}
	else
		echo '<strong>Fallo Ingreso:</strong> '.$codigo;
	echo '<br>';
}
mysql_close($conexion);
echo '<br><br><strong>Total:</strong>'.$total;
?>
</body>
</html>
