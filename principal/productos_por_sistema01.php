<?php
	include("conectar_principal.php");

	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Sistema     = isset($_REQUEST["Sistema"])?$_REQUEST["Sistema"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Valor       = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";

	switch ($Proceso)
	{
		case "G":
			if ($SubProducto == "T")
			{
				$Consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto='".$Producto."'";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					$Insertar = "INSERT into proyecto_modernizacion.productos_sistema (cod_sistema, cod_producto, cod_subproducto)";
					$Insertar.= " values('".$Sistema."', '".$Producto."', '".$Fila["cod_subproducto"]."')";
					mysqli_query($link, $Insertar);
				}
			}
			else
			{
				$Insertar = "INSERT into proyecto_modernizacion.productos_sistema (cod_sistema, cod_producto, cod_subproducto)";
				$Insertar.= " values('".$Sistema."', '".$Producto."', '".$SubProducto."')";
				mysqli_query($link, $Insertar);
			}
			header("location:productos_por_sistema.php?Sistema=".$Sistema."&Producto=".$Producto."&SubProducto=".$SubProducto);
			break;
		case "E";
			$Producto = intval(substr($Valor,0,3));
			$SubProducto = intval(substr($Valor,3));
			$Eliminar = "DELETE from proyecto_modernizacion.productos_sistema ";
			$Eliminar.= " where cod_sistema = '".$Sistema."' ";
			$Eliminar.= " and cod_producto = '".$Producto."' ";
			$Eliminar.= " and cod_subproducto = '".$SubProducto."' ";
			mysqli_query($link, $Eliminar);
			header("location:productos_por_sistema.php?Sistema=".$Sistema."&Producto=".$Producto."&SubProducto=".$SubProducto);
			break;
		case "ET":
			$Eliminar = "DELETE from proyecto_modernizacion.productos_sistema ";
			$Eliminar.= " WHERE cod_sistema = '".$Sistema."' ";
			mysqli_query($link, $Eliminar);
			header("location:productos_por_sistema.php?Sistema=".$Sistema."&Producto=".$Producto."&SubProducto=".$SubProducto);
			break;
	}
?>