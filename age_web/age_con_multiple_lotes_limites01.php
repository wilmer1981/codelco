<?php
	include("../principal/conectar_principal.php");
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor   = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";

	if ($SubProducto == "S")
	{
		$Producto = "99";
		$SubProducto = "99";
	}else{
		$Producto = '1';
	}
	
	if ($Proveedor == "S")
	{
		$RutAux = "99999999-9";
	}else{
		$Datos3 = explode("-",$Proveedor);
		$RutAux = ($Datos3[0]*1)."-".$Datos3[1];
	}

	switch ($Proceso)
	{
		case "G":			
			//PRIMERO ELIMINA LO QUE HAYs
			$Eliminar = "delete from age_web.limites ";
			$Eliminar.= " where cod_producto='".$Producto."' ";
			$Eliminar.= " and cod_subproducto='".$SubProducto."' ";
			$Eliminar.= " and rut_proveedor='".$RutAux."'";
			mysqli_query($link, $Eliminar);
			//INSERTA NUEVOS VALORES
			/*
			age_con_multiple_lotes_limites01.php?Proceso=G&Valores=
			Valores=02//>//11~~
			        04//>//12~~
					05//>//13~~

					07//>//111~~
					08//>//121~~
					09//>//131
					*/
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)			
			{
				$Datos2 = explode("//",$v);
				$NomLey = $Datos2[0];
				$ValorSigno = $Datos2[1];
				$ValorLimite = $Datos2[2];

				/*  se desactivo por que la tabla no tiene columnas: signo y imite
				$Insertar = "insert into age_web.limites (cod_producto, cod_subproducto, rut_proveedor, cod_leyes, signo, limite) ";
				$Insertar.= " VALUES('".$Producto."','".$SubProducto."','".$RutAux."','".$NomLey."','".$ValorSigno."','".$ValorLimite."')";
				*/
				$Insertar = "insert into age_web.limites (cod_producto, cod_subproducto, rut_proveedor, cod_leyes) ";
				$Insertar.= " VALUES('".$Producto."','".$SubProducto."','".$RutAux."','".$NomLey."')";
				
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