<?php
 include("../principal/conectar_ram_web.php"); 

//tranforma a mayúscula el nomrbre del conjunto
$nombre_conjunto = strtoupper($nombre_conjunto);

$cod_conjunto = $cmbconjunto;

if($cmbconjunto == 42)
	$cod_conjunto = "03";

/*if(strlen($cmbconjunto) == 1)
	$cmbconjunto = "0".$cmbconjunto;*/

/*if(strlen($cmbproducto) == 1)
	$cmbproducto = "0".$cmbproducto;*/

if(strlen($num_conjunto) == 1)
	$num_conjunto = "0".$num_conjunto;

if(strlen($cmbtipo) == 1)
	$cmbtipo = "0".$cmbtipo;

if(strlen($cmblugar) == 1)
	$cmblugar = "0".$cmblugar;

if(strlen($cod_conjunto) == 1)
	$cod_conjunto = "0".$cod_conjunto;

//Guardar Datos
if($Proceso == "G")
{
		$Insertar = "INSERT INTO conjunto_ram_bd (COD_CONJUNTO,NUM_CONJUNTO,DESCRIPCION,COD_PRODUCTO,COD_SUBPRODUCTO)";
		$Insertar = "$Insertar values('$cod_conjunto','$num_conjunto','$nombre_conjunto', '$cmbconjunto', '$cmbproducto')";
		mysqli_query($link, $Insertar);
	
	
		$Insertar2 = "INSERT INTO conjunto_ram (cod_conjunto,num_conjunto,cod_lugar,num_lugar,descripcion,fecha_creacion,estado,cod_producto,cod_subproducto)";
		$Insertar2 = "$Insertar2 values('$cod_conjunto','$num_conjunto','$cmbtipo','$cmblugar','$nombre_conjunto','$fecha','$cmbestado','$cmbconjunto','$cmbproducto')";
		mysqli_query($link, $Insertar2);
					
}

//Modificar Datos
if($Proceso == "M")
{
	$Modificar = "UPDATE conjunto_ram_bd SET COD_CONJUNTO = '$cod_conjunto', NUM_CONJUNTO = '$num_conjunto',
	              DESCRIPCION = '$nombre_conjunto', COD_PRODUCTO = '$cmbconjunto', COD_SUBPRODUCTO = '$cmbproducto'
	              WHERE COD_CONJUNTO = '$cod_conjunto' AND NUM_CONJUNTO = '$num_conjunto'";
	mysqli_query($link, $Modificar);
	
	$Modificar2 = "UPDATE conjunto_ram SET cod_conjunto = '$cod_conjunto', num_conjunto = '$num_conjunto', descripcion = '$nombre_conjunto', 
	              fecha_creacion = '$fecha',estado = '$cmbestado', cod_subproducto = '$cmbproducto', cod_lugar = '$cmbtipo', num_lugar = '$cmblugar'
	              WHERE cod_conjunto = '$cod_conjunto' AND num_conjunto = '$num_conjunto' AND fecha_creacion = '$fecha'";
	mysqli_query($link, $Modificar2);

	
}

//Eliminar Datos
if($Proceso == "E")
{
	$Eliminar = "DELETE FROM conjunto_ram_bd WHERE COD_CONJUNTO = $cod_conjunto AND COD_PRODUCTO = $cmbconjunto AND COD_SUBPRODUCTO = $cmbproducto AND NUM_CONJUNTO = $num_conjunto";
	mysqli_query($link, $Eliminar);

	$Eliminar2 = "DELETE FROM conjunto_ram WHERE cod_conjunto = $cod_conjunto AND cod_subproducto = $cmbproducto AND num_conjunto = $num_conjunto AND fecha_creacion = '$fecha'";
	mysqli_query($link, $Eliminar2);

}

	$valores = "Proceso=V"."&cmbconjunto=".$cmbconjunto."&cmbproducto=".$cmbproducto."&fecha=".$fecha;  
    header("Location:ram_ing_conjuntos.php?".$valores); 

?>