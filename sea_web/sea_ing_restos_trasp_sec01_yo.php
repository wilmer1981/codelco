<?php
include("../principal/conectar_sea_web.php");
$Hora=date("Y-m-d H:i:s");

	$contador= 0;
	$consulta ="SELECT * from sea_web.tmp_jcf2";
	$resp = mysqli_query($link, $consulta);
	while ($Row = mysqli_fetch_array($resp))
	{
		$insertar = "insert into sea_web.movimientos (tipo_movimiento,cod_producto, cod_subproducto, hornada,";
		$insertar.="numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,estado,lote_ventana,peso_origen,";
		$insertar.="zuncho,hora) values ('10','19','2','".$Row[hornada]."','0','".$Row[fecha_movimiento]."','".$Row[campo1]."'";
		$insertar.=",'".$Row[campo2]."','".$Row["unidades"]."','".$Row["flujo"]."','".$Row[fecha_benef]."','".$Row["peso"]."'";
		$insertar.=",'".$Row["estado"]."','".$Row[lote_ventana]."','".$Row[peso_origen]."','".$Row[zuncho]."','".$Row[hora]."')";
		mysqli_query($link, $insertar);
		$contador = $contador + 1;
	}
	echo "----------".$contador;
		
?>
