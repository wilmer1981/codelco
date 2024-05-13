<?php
	include("../principal/conectar_principal.php");
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Tipo     = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$CmbSubProducto  = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor    = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtCodigo       = isset($_REQUEST["TxtCodigo"])?$_REQUEST["TxtCodigo"]:"";
	$TxtDescripcion  = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";

	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor   = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$ChkTipo     = isset($_REQUEST["ChkTipo"])?$_REQUEST["ChkTipo"]:"";
	$Plantilla   = isset($_REQUEST["Plantilla"])?$_REQUEST["Plantilla"]:"";
	$ValoresAux      = isset($_REQUEST["ValoresAux"])?$_REQUEST["ValoresAux"]:"";

	switch($Proceso)
	{		
		case "G":// NUEVA PLANTILLA
			if ($CmbSubProducto=="S")
				$CmbSubProducto=0;
			if ($CmbProveedor=="S")
				$CmbProveedor="99999999-9";
			$Consulta = "SELECT * from age_web.limites where cod_plantilla='".$TxtCodigo."'";
			$Resp = mysqli_query($link, $Consulta);			
			if ($Fila=mysqli_fetch_array($Resp))
			{
				$Actualizar = "UPDATE age_web.limites set descripcion='".$TxtDescripcion."'";
				$Actualizar.= " where cod_plantilla='".$TxtCodigo."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				$Insertar = "INSERT INTO age_web.limites (tipo, cod_plantilla, descripcion, cod_producto, cod_subproducto, rut_proveedor, cod_leyes) ";
				$Insertar.= " values('".$Tipo."', '".$TxtCodigo."', '".strtoupper($TxtDescripcion)."', '1','".$CmbSubProducto."','".$CmbProveedor."','00')";
				mysqli_query($link, $Insertar);
			}			
			if ($CmbSubProducto=="0")
				$CmbSubProducto="S";
			if ($CmbProveedor=="99999999-9")
				$CmbProveedor="S";
			echo "<script laguage='JavaScript'>window.opener.document.location='age_ing_limites.php?ChkTipo=".$Tipo."&SubProducto=".$CmbSubProducto."&Proveedor=".$CmbProveedor."&Plantilla=".$TxtCodigo."';";
			echo "window.close();</script>";
			break;
		case "E":// ELIMINA PLANTILLA
			$Eliminar = "DELETE FROM age_web.limites where cod_plantilla='".$TxtCodigo."'";
			mysqli_query($link, $Eliminar);	
			echo "<script laguage='JavaScript'>window.opener.document.location='age_ing_limites.php';";
			echo "window.close();</script>";
			break;
		case "GL":// GUARDA LIMITES
			if ($SubProducto=="S")
				$SubProducto="0";
			if ($Proveedor=="S")
				$Proveedor="99999999-9";
			//SACO LA DESCRIPCION DE LA PLANTILLA
			//PRIMERO ELIMINA LO QUE HAY
			$Consulta = "SELECT distinct descripcion from age_web.limites ";
			$Consulta.= " where cod_plantilla='".$Plantilla."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
				$DescPlantilla = strtoupper($Fila["descripcion"]);
			else
				$DescPlantilla = "";
			//PRIMERO ELIMINA LO QUE HAY
			$Eliminar = "delete from age_web.limites where cod_plantilla='".$Plantilla."'";
			mysqli_query($link, $Eliminar);
			//INSERTA NUEVOS VALORES
			$Datos = explode("~~",$ValoresAux);
			foreach($Datos as $k => $v)			
			{
				$Datos2 = explode("//",$v);
				$CodLey = $Datos2[0];
				$ValorMin = str_replace(",",".",$Datos2[1]);
				$ValorMed = str_replace(",",".",$Datos2[2]);
				$ValorMax = str_replace(",",".",$Datos2[3]);
				$FechaAct = str_replace("/","",$Datos2[4]);
				$Insertar = "insert into age_web.limites (tipo, cod_plantilla, descripcion, cod_producto, cod_subproducto, rut_proveedor, cod_leyes, limite_minimo, limite_medio, limite_maximo,anomes) ";
				$Insertar.= " VALUES('".$ChkTipo."', '".$Plantilla."', '".$DescPlantilla."', '1','".$SubProducto."','".$Proveedor."','".$CodLey."','".$ValorMin."','".$ValorMed."','".$ValorMax."','".$FechaAct."')";
				//echo $Insertar;
				mysqli_query($link, $Insertar);
			}
			if ($SubProducto=="0")
				$SubProducto="S";
			if ($Proveedor=="99999999-9")
				$Proveedor="S";
			header("location:age_ing_limites.php?ChkTipo=".$ChkTipo."&SubProducto=".$SubProducto."&Proveedor=".$Proveedor."&Plantilla=".$Plantilla);
			break;
		
	}
?>
