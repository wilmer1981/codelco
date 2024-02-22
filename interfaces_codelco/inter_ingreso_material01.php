<?php
	include("../principal/conectar_principal.php");

	$Proceso           = $_REQUEST["Proceso"];
	$CmbProducto       = $_REQUEST["CmbProducto"];
	$CmbSubProducto    = $_REQUEST["CmbSubProducto"];
	$TxtMaterialSap    = $_REQUEST["TxtMaterialSap"];
	$TxtMedidaSap      = $_REQUEST["TxtMedidaSap"];
	$TxtMedida         = $_REQUEST["TxtMedida"];
	$CmbEmpaque        = $_REQUEST["CmbEmpaque"];
	$Valores           = $_REQUEST["Valores"];
	$TxtCentro         = $_REQUEST["TxtCentro"];
	

//	echo $ValoresAux;
	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from interfaces_codelco.homologacion where ";
			$Consulta.="  cod_producto='".$CmbProducto."' ";
			$Consulta.=" and cod_subproducto='".$CmbSubProducto."' and ucase(materiales_sap)='".strtoupper($TxtMaterialSap)."' ";
			$Resp=mysqli_query($link, $Consulta);
			echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:inter_ingreso_material_sap.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" INSERT into interfaces_codelco.homologacion ";
				$Insertar.=" (cod_producto,cod_subproducto,unidad_medida,materiales_sap,pedido,unidad_medida_sap, ";
				$Insertar.=" centro,cod_empaque ";
				$Insertar.=" ) values(";
				$Insertar.=" '".$CmbProducto."','".$CmbSubProducto."',";
				$Insertar.=" '".strtoupper($TxtMedida)."','".$TxtMaterialSap."','".$TxtMaterialSap."','".strtoupper($TxtMedidaSap)."','".strtoupper($TxtCentro)."',";
				$Insertar.=" '".$CmbEmpaque."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='inter_material_sap.php';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();</script>";	
			}
		break;
		case "E":
			$Datos = explode("//",$Valores);
			//foreach($Datos as $clave => $Codigo)
			foreach ($Datos as $clave => $Codigo)
			{
				$arreglo=explode("~",$Codigo);
				$Eliminar=" delete from interfaces_codelco.homologacion";
				$Eliminar.=" where ";
				$Eliminar.=" cod_producto='".$arreglo[0]."' and ";
				$Eliminar.=" cod_subproducto = '".$arreglo[1]."'";
				$Eliminar.=" cod_empaque = '".$arreglo[2]."'";
				mysqli_query($link, $Eliminar);  
				//echo $Eliminar."<br>";
			}
			header("location:inter_material_sap.php");
		break;
		case "M":
			$Datos2=explode('~',$Valores);
			//$Asignacion=$Datos2[0];
			$Producto=$Datos2[0];
			$SubProducto=$Datos2[1];
			$Empaque=$Datos2[2];
			//$OP=$Datos2[2];
			$Actualizar=" UPDATE  interfaces_codelco.homologacion set ";
			$Actualizar.="  cod_producto='".$CmbProducto."',   ";
			$Actualizar.="  cod_subproducto='".$CmbSubProducto."' , unidad_medida = '".strtoupper($TxtMedida)."', ";
			$Actualizar.="  materiales_sap='".$TxtMaterialSap."' , pedido = '".$TxtMaterialSap."',  unidad_medida_sap = '".strtoupper($TxtMedidaSap)."', ";
			$Actualizar.="  centro='".strtoupper($TxtCentro)."' , cod_empaque = '".$CmbEmpaque."' ";
			$Actualizar.=" where ";
			$Actualizar.=" cod_producto='".$Producto."' and ";
			$Actualizar.=" cod_subproducto = '".$SubProducto."' and ";
			$Actualizar.=" cod_empaque = '".$Empaque."' ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
		echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='inter_material_sap.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";	
		break;
	}
?>