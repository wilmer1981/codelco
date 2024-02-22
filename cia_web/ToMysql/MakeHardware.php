<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");

$query="select * from cia_web_access.hardware_access order by codigo;";
$result=mysql_query($query,$conexion);
$total=mysql_num_rows($result);
$cant_ing=$cant_rep=$cant_omi=0;

while($resp=mysql_fetch_array($result))
{
	//se llena la tabla hardware
	$marca=strtoupper($resp["marca"]);
	$modelo=strtoupper($resp["modelo"]);
	$fecha_compra=$resp["fecha_compra"];
	if($fecha_compra=="")
		$fecha_compra=NULL;
	$nro_factura=strtoupper($resp["nro_factura"]);
	$nro_guia=strtoupper($resp["nro_guia"]);
	$rut_proveedor=$resp["rut_proveedor"];
	$observaciones=strtoupper($resp["observaciones"]);
	$tipo=CheckTipo($resp["codigo"],$conexion);
	
	//si el tipo no esta registrado no se ingresan los datos
	if($tipo=='NONE')
	{	
		$cant_omi++;
		echo '<strong>FAllo ingreso: '.$resp["codigo"].'TIPO NO REGISTRADO</strong><br>';
		continue;
	}
	
	if($tipo=='EQUIPO')
		$estado=MakeEstadoEquipo($resp["cc"],$resp["ubi"],$resp["rut_usuario"]);
	else
		$estado=MakeEstadoParte($resp["ubi"],$resp["cc"]);
	
	//se verifica que exista el proveedor
	if($rut_proveedor!="")
	{
		if(!CheckProveedor($rut_proveedor,$conexion))
		{
			$cant_omi++;
			echo '<strong>FAllo ingreso: '.$resp["codigo"].'Proveedor no registrado</strong><br>';
			continue;
		}
	}
	
	$query="INSERT INTO cia_web_access.hardware values('".$resp["codigo"]."','".$marca."','".$modelo."','".$resp["nro_serie"]."'";
	if($fecha_compra==NULL)
		$query.=",NULL,";
	else
		$query.=",'".$fecha_compra."',";
	$query.=$resp["p_garantia"].",'".$nro_factura."','".$nro_guia."','".$rut_proveedor;
	$query.="',".$estado.",0,'".$observaciones."','".$tipo."','');";
	if(!mysql_query($query,$conexion))
		echo '<strong>fallo ingreso: '.$resp["codigo"]."</strong><br>";
	$cant_ing++;
}
mysql_close($conexion);
echo "<br><br><strong>TOTAL:\t\t</strong>".$total;
echo "<br>Cant Ingresados:\t\t".$cant_ing;
echo "<br>Cant Omitidos:\t\t".$cant_omi;
echo "<br>Cant Repetidos:\t\t".$cant_rep;
?>
</body>
</html>
