<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php
include("funciones.php");
$conexion=mysql_connect("localhost","practica","");

$query="select * from proveedor_access order by rut asc;";
$result=mysql_db_query("cia_web_access",$query,$conexion);
$total=$cant_ing=$cant_omi=$cant_rep=0;
$total=mysql_num_rows($result);

while($resp=mysql_fetch_array($result))
{
	$rut=FixRut($resp["rut"]);
	$razon_social=strtoupper($resp["razon_social"]);
	$nombre_fantasia=strtoupper($resp["nombre_fantasia"]);
	$contacto_1=strtoupper($resp["contacto_1"]);
	$contacto_2=strtoupper($resp["contacto_2"]);
	$fono_1=strtoupper($resp["fono_1"]);
	$fono_2=strtoupper($resp["fono_2"]);
	$fax=strtoupper($resp["fax"]);
	
	if($razon_social=="")
	{
		$cant_omi++;
		echo 'FALLO INGRESO: '.$rut."\t\tFaltan Datos";
		continue;
	}
	$query="INSERT INTO proveedor value('".$rut."','".$razon_social."','".$nombre_fantasia."'";
	$query.=",'".$contacto_1."','".$contacto_2."','".$fono_1."','".$fono_2."','".$fax."');";
	if(mysql_db_query("cia_web_access",$query,$conexion))
		echo 'Ingreso Exitoso: '.$rut;
	else
		echo '<strong>Fallo Ingreso: </strong>'.$rut;
	
	if(CheckDataProveedor($resp["rut"],$resp["razon_social"],$conexion)>1)
	{
		$cant_rep++;
		$resp=mysql_fetch_array($result);
		echo "\t\t<strong>Repetido</strong>";
	}
	$cant_ing++;
	echo '<br>';
}
mysqli_close($conexion);
echo "<br><br><strong>TOTAL:\t\t</strong>".$total;
echo "<br>Cant Ingresados:\t\t".$cant_ing;
echo "<br>Cant Omitidos:\t\t".$cant_omi;
echo "<br>Cant Repetidos:\t\t".$cant_rep;
?>
</body>
</html>
