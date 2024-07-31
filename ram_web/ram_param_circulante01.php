<?php
	include("../principal/conectar_principal.php");
	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Nodo        = isset($_REQUEST["Nodo"])?$_REQUEST["Nodo"]:"";
	$Flujo       = isset($_REQUEST["Flujo"])?$_REQUEST["Flujo"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Rut         = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
	$Tipo        = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	switch ($Proceso)
	{
		case "G":
			$Insertar = "insert into ram_web.param_circulante ";
			$Insertar.= " (nodo,flujo,cod_producto,cod_subproducto,tipo_movimiento) ";
			$Insertar.= " VALUES('".$Nodo."','".$Flujo."','".$Producto."','".$SubProducto."','".$Tipo."')";
			mysqli_query($link, $Insertar);
			header("location:ram_param_circulante.php");
			break;
		case "E":
			$Datos = explode("//",$Valores);
			$Eliminar = "delete from ram_web.param_circulante ";
			$Eliminar.= " where nodo='".$Datos[0]."' and flujo='".$Datos[1]."' ";
			$Eliminar.= " and cod_producto='".$Datos[2]."' and cod_subproducto='".$Datos[3]."' ";
			$Eliminar.= " and tipo_movimiento='".$Datos[4]."'";
			mysqli_query($link, $Eliminar);
			header("location:ram_param_circulante.php");
			break;
	}
?>