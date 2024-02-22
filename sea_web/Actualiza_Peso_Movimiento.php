<?php
	include("../principal/conectar_sea_web.php");
	
    $consulta = "SELECT STRAIGHT_JOIN t1.tipo_movimiento, t1.cod_producto, t1.cod_subproducto, t1.hornada,";
    $consulta = $consulta." t1.numero_recarga, t1.fecha_movimiento, t1.campo1, t1.campo2,";
    $consulta = $consulta." t1.unidades, t1.flujo, t1.fecha_benef, ";
    $consulta = $consulta." ROUND(t1.unidades * (t2.peso_unidades / t2.unidades)) AS peso";
    $consulta = $consulta." FROM sea_web.movimientos AS t1";
    $consulta = $consulta." INNER JOIN sea_web.hornadas AS t2";
    $consulta = $consulta." ON t1.cod_producto = t2.cod_producto";
    $consulta = $consulta." AND t1.cod_subproducto = t1.cod_subproducto";
    $consulta = $consulta." AND t1.hornada = t2.hornada_ventana";
	$consulta = $consulta." WHERE t1.tipo_movimiento = 2 AND fecha_movimiento BETWEEN '2003-11-14' AND '2003-11-14'";
    //$consulta = $consulta." ORDER BY tipo_movimiento";
	//$consulta = $consulta." LIMIT 0,20";
	//echo $consulta."<br>";
    $rs = mysqli_query($link, $consulta);
	
    while ($row = mysqli_fetch_array($rs))
	{
        $actualiza = "UPDATE sea_web.movimientos SET peso = '".$row["peso"]."'";
        $actualiza = $actualiza." WHERE tipo_movimiento = '".$row[tipo_movimiento]."'";
        $actualiza = $actualiza." AND cod_producto = '".$row["cod_producto"]."'";
        $actualiza = $actualiza." AND cod_subproducto = '".$row["cod_subproducto"]."'";
        $actualiza = $actualiza." AND hornada = '".$row["hornada"]."'";
        $actualiza = $actualiza." AND numero_recarga = '".$row[numero_recarga]."'";
        $actualiza = $actualiza." AND fecha_movimiento = '".$row[fecha_movimiento]."'";
        $actualiza = $actualiza." AND campo1 = '".$row[campo1]."'";
        $actualiza = $actualiza." AND campo2 = '".$row[campo2]."'";
        $actualiza = $actualiza." AND unidades = '".$row["unidades"]."'";
        $actualiza = $actualiza." AND flujo = '".$row["flujo"]."'";
        $actualiza = $actualiza." AND fecha_benef = '".$row[fecha_benef]."'";
        mysqli_query($link, $actualiza);
		echo $actualiza."<br>";
	}
	
	echo "Los Pesos de los Movimientos Actualizados";
	
	include("../principal/cerrar_sea_web.php");
?>