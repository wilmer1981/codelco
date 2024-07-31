<?php
	include("../principal/conectar_principal.php");
	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Nodo        = isset($_REQUEST["Nodo"])?$_REQUEST["Nodo"]:"";
	$Flujo       = isset($_REQUEST["Flujo"])?$_REQUEST["Flujo"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Rut         = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
	$Tipo        = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$Destino     = isset($_REQUEST["Destino"])?$_REQUEST["Destino"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	switch ($Proceso)
	{
		case "G":
			$Insertar = "insert into ram_web.flujo_rut ";
			$Insertar.= " (cod_existencia, cod_producto, cod_subproducto, rut, destino, flujo, nodo) ";
			$Insertar.= " VALUES('".$Tipo."','".$Producto."','".$SubProducto."','".$Rut."','".$Destino."','".$Flujo."', '".$Nodo."')";
			mysqli_query($link, $Insertar);
			header("location:ram_param_pmineros.php");
			break;
		case "E":
			$Datos = explode("//",$Valores);
			$Eliminar = "delete from ram_web.flujo_rut ";
			$Eliminar.= " where cod_existencia='".$Datos[0]."' and cod_producto='".$Datos[1]."' ";
			$Eliminar.= " and cod_subproducto='".$Datos[2]."' and rut='".$Datos[3]."' and destino='".$Datos[4]."' ";
			$Eliminar.= " and flujo='".$Datos[5]."' and nodo='".$Datos[6]."'";
			mysqli_query($link, $Eliminar);
			header("location:ram_param_pmineros.php");
			break;
	}
?>