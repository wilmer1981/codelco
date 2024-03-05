<?php
	include("../principal/conectar_principal.php");
//	echo $ValoresAux;

	$Proceso        = $_REQUEST["Proceso"];
	$CmbAsignacion  = $_REQUEST["CmbAsignacion"];
	$CmbProducto    = $_REQUEST["CmbProducto"];
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	$CmbMateriales  = $_REQUEST["CmbMateriales"];
	$CmbDivision    = $_REQUEST["CmbDivision"];
	$CmbUnidad      = $_REQUEST["CmbUnidad"];
	$TxtOP          = $_REQUEST["TxtOP"];
	$TxtClase       = $_REQUEST["TxtClase"];
	$Valores        = $_REQUEST["Valores"];


	switch ($Proceso)
	{
		case "N":
			$Existe=false;
			$Consulta="select * from interfaces_codelco.ordenes_produccion where ";
			$Consulta.="  asignacion ='".$CmbAsignacion."' and cod_producto='".$CmbProducto."' ";
			$Consulta.=" and cod_subproducto='".$CmbSubProducto."' and ucase(codigo_op)='".strtoupper($TxtOP)."' ";
			$Resp=mysqli_query($link, $Consulta);
			//echo $Consulta;
			if($Fila=mysqli_fetch_array($Resp))
			{
				$Existe=true;
				header("location:inter_orden_produccion_proceso.php?Existe=".$Existe."&Proceso=".$Proceso);
			}
			else
			{
				$Insertar=" INSERT INTO interfaces_codelco.ordenes_produccion ";
				$Insertar.=" (asignacion,cod_producto,cod_subproducto,codigo_op,cod_material_sap,unidad_medida, ";
				$Insertar.=" centro,clase_valorizacion ";
				$Insertar.=" ) values(";
				$Insertar.=" '".$CmbAsignacion."','".$CmbProducto."','".$CmbSubProducto."',";
				$Insertar.=" '".strtoupper($TxtOP)."','".$CmbMateriales."','".$CmbUnidad."','".$CmbDivision."',";
				$Insertar.=" '".strtoupper($TxtClase)."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='inter_orden_produccion.php';";
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
				$Eliminar=" delete from interfaces_codelco.ordenes_produccion ";
				$Eliminar.=" where ";
				if($arreglo[0] == "")
					$Eliminar.="  isnull(asignacion) ";
				else
					$Eliminar.=" asignacion='".$arreglo[0]."' ";
				$Eliminar.=" and cod_producto='".$arreglo[1]."' and ";
				$Eliminar.=" cod_subproducto = '".$arreglo[2]."' and ucase(codigo_op)='".strtoupper($arreglo[3])."'  ";
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			header("location:inter_orden_produccion.php");
		break;
		case "M":
			$Datos2=explode('~',$Valores);
			$Asignacion=$Datos2[0];
			$Producto=$Datos2[1];
			$SubProducto=$Datos2[2];
			$OP=$Datos2[3];
			$Actualizar=" UPDATE  interfaces_codelco.ordenes_produccion set ";
			$Actualizar.="  asignacion ='".$CmbAsignacion."',cod_producto='".$CmbProducto."',   ";
			$Actualizar.="  cod_subproducto='".$CmbSubProducto."' , codigo_op = '".strtoupper($OP)."', ";
			$Actualizar.="  cod_material_sap='".$CmbMateriales."' , unidad_medida = '".$CmbUnidad."', ";
			$Actualizar.="  centro='".$CmbDivision."' , clase_valorizacion = '".strtoupper($TxtClase)."' ";
			$Actualizar.=" where ";
			if($Asignacion == "")
				$Actualizar.="  isnull(asignacion) ";
			else	
				$Actualizar.=" asignacion='".$Asignacion."' ";
			$Actualizar.=" and cod_producto='".$Producto."' and ";
			$Actualizar.=" cod_subproducto = '".$SubProducto."' and ucase(codigo_op)='".strtoupper($OP)."'  ";
			mysqli_query($link, $Actualizar);
			//echo $Actualizar;
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='inter_orden_produccion.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";	
		break;
	}
?>