<?php
include("../principal/conectar_sea_web.php");
	$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 10 AND cod_producto = 19";
	$consulta = $consulta." AND cod_subproducto = '2'";
	//echo $consulta."<br>";
	$rs1 = mysqli_query($link, $consulta);
	if ($row1 = mysqli_fetch_array($rs1))
		$flujo = $row1["flujo"];
	else 
		$flujo = 0;
	$Hora = "2007-11-22 15:00:00";

	$cuantos = 0;
	$seleccion="select * from sea_web.tmp_jcf2";
	$respuesta = mysqli_query($link, $seleccion);
	while ($Row = mysqli_fetch_array($respuesta))
	{
		$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,";
		$insertar.=" campo1,campo2,unidades,flujo,fecha_benef,peso,hora)";
		$insertar.=" VALUES(10,19,'2','".$Row[hornada]."',0,'2007-11-22','','".$Row["grupo"]."',";
		$insertar.=" '".$Row["unidades"]."','".$flujo."','".$Row[fecha_beneficio]."','".$Row["peso"]."','".$Hora."')";
		mysqli_query($link, $insertar);
		$cuantos = $cuantos + 1;
	}	
		echo "------".$cuantos;	
?>
