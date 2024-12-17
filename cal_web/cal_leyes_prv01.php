<?php
	include("../principal/conectar_principal.php");
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Rut = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
	$TxtCodLeyes = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:"";
	$TxtCodImpurezas = isset($_REQUEST["TxtCodImpurezas"])?$_REQUEST["TxtCodImpurezas"]:"";
		
	switch ($Proceso)
	{
		case "M":
			$Consulta = "select * from age_web.relaciones ";
			$Consulta.= " where cod_producto='1'";
			$Consulta.= " and cod_subproducto='".$SubProducto."'";
			$Consulta.= " and rut_proveedor='".$Rut."'";
			//echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{				
				//ACTUALIZAR
				$Actualizar = "UPDATE age_web.relaciones SET ";
				$Actualizar.= "leyes='$TxtCodLeyes'";
				$Actualizar.= ",impurezas='$TxtCodImpurezas'";
				$Actualizar.= " where cod_producto='1'";
				$Actualizar.= " and cod_subproducto='".$SubProducto."'";
				$Actualizar.= " and rut_proveedor='".$Rut."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar;
			}
			echo "<script language='JavaScript'>";
			echo " window.opener.document.frmPrincipal.action = 'cal_leyes_prv.php?TipoBusq2=3&Mostrar2=S&SubProducto2=".$SubProducto."&Proveedor2=".$Rut."';";
			echo " window.opener.document.frmPrincipal.submit();";
			echo " window.close();";
			echo "</script>";
			break;
	}
?>