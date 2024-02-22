<?php
	include("../principal/conectar_principal.php");
	if ($SubProducto == "S")
	{
		$Producto = "99";
		$SubProducto = "99";
	}
	else
	{
		$Producto = '1';
	}
	if ($Proveedor == "S")
	{
		$RutAux = "99999999-9";
	}
	else
	{
		$Datos3 = explode("-",$Proveedor);
		$RutAux = ($Datos3[0]*1)."-".$Datos3[1];
	}
	switch ($Proceso)
	{
		case "G":			
			//PRIMERO ELIMINA LO QUE HAYs
			$Eliminar = "delete from asge_web.limites ";
			$ELiminar.= " where cod_producto='".$Producto."' ";
			$Eliminar.= " and cod_subproducto='".$SubProducto."' ";
			$Elimianr.= " and rut_proveedor='".$RutAux."'";
			mysqli_query($link, $Eliminar);
			//INSERTA NUEVOS VALORES
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)			
			{
				$Datos2 = explode("//",$v);
				$NomLey = $Datos2[0];
				$ValorSigno = $Datos2[1];
				$ValorLimite = $Datos2[2];
				$Insertar = "insert into age_web.limites (cod_producto, cod_subproducto, rut_proveedor, cod_leyes, signo, limite) ";
				$Insertar.= " VALUES('".$Producto."','".$SubProducto."','".$RutAux."','".$NomLey."','".$ValorSigno."','".$ValorLimite."')";
				mysqli_query($link, $Insertar);
			}
			if ($SubProducto=="99")
				$SubProducto="S";
			header("location:age_con_multiple_lotes_limites.php?SubProducto=".$SubProducto."&Proveedor=".$Proveedor);
			break;
		case "E":			
			$Eliminar = "delete from age_web.limites ";
			$Eliminar.= " where cod_producto='".$Producto."' ";
			$Eliminar.= " and cod_subproducto='".$SubProducto."' ";
			$Eliminar.= " and rut_proveedor='".$RutAux."'";
			mysqli_query($link, $Eliminar);
			if ($SubProducto=="99")
				$SubProducto="S";
			header("location:age_con_multiple_lotes_limites.php?SubProducto=".$SubProducto."&Proveedor=".$Proveedor);
			break;
	}
?>