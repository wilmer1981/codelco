<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G":
			$Codigos=explode('~',$Valores);
			$CodAsig=str_replace('*',' ',$Codigos[0]);
			$Actualizar = "UPDATE age_web.deduc_metalurgicas set valor1='".str_replace(',','.',$TxtValor1)."',valor2='".str_replace(',','.',$TxtValor2)."',valor3='".str_replace(',','.',$TxtValor3)."',valor4='".str_replace(',','.',$TxtValor4)."' ";
			$Actualizar.= " where cod_recepcion='".$CodAsig."' and cod_producto='1' and cod_subproducto='".$Codigos[1]."' and rut_proveedor='".$Codigos[2]."' and cod_leyes='".$Codigos[3]."'";
			mysqli_query($link, $Actualizar);			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='age_parametros_deduccion.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
			break;
		case "N"://NUEVO
			$Insertar = "insert into age_web.deduc_metalurgicas (cod_recepcion,cod_producto,cod_subproducto,rut_proveedor,cod_leyes,cant_param,valor1,valor2,valor3,valor4,tipo_formula,formula) values (";
			$Insertar.= "'$CmbRecepcion','1','$CmbSubProducto','$CmbProveedor','$CmbLey','$CmbCantP','$TxtValor1','$TxtValor2','$TxtValor3','$TxtValor4','$CmbTipoF','$Formula')";
			mysqli_query($link, $Insertar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='age_parametros_deduccion.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
			break;
		case "M"://MODIFICA
			$Consultar ="Select * from age_web.deduc_metalurgicas where cod_recepcion = '".$CmbRecepcion."' and cod_producto = 1 and ";
			$Consultar.=" cod_subproducto = '".$CmbSubProducto."' and rut_proveedor = '".$CmbProveedor."' and cod_leyes = '".$CmbLey."'";
			$Resp = mysqli_query($link, $Consultar);
			//echo $Consultar;
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$Actualiza = "Update age_web.deduc_metalurgicas set cant_param = '".$CmbCantP."',valor1 = '".$TxtValor1."', '".$TxtValor2."',valor3 = '".$TxtValor3."',";
				$Actualiza.="valor4 = '".$TxtValor4."',tipo_formula = �".$CmbTipoF."',formula ='".$Formula."' where cod_recepcion = '".$CmbRecepcion."' and cod_producto = 1 and ";
				$Actualiza.=" cod_subproducto = '".$CmbSubProducto."' and rut_proveedor = '".$CmbProveedor."' and cod_leyes = '".$CmbLey."'";
				//echo $Actualiza;
				mysqli_query($link, $Actualiza);
			}
			else
			{
				$Insertar = "insert into age_web.deduc_metalurgicas (cod_recepcion,cod_producto,cod_subproducto,rut_proveedor,cod_leyes,cant_param,valor1,valor2,valor3,valor4,tipo_formula,formula) values (";
				$Insertar.= "'$CmbRecepcion','1','$CmbSubProducto','$CmbProveedor','$CmbLey','$CmbCantP','$TxtValor1','$TxtValor2','$TxtValor3','$TxtValor4','$CmbTipoF','$Formula')";
				mysqli_query($link, $Insertar);
				//echo $Insertar;
			}
		 	echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='age_parametros_deduccion.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
			break;
		case "E"://Elimina 14-04-09
			$Datos=explode('~',$Valores);
			$CodAsig=str_replace('*',' ',$Datos[0]);
			$CodSubProd=$Datos[1];
			$RutPrv=$Datos[2];
			$CodLey=$Datos[3];
			$Elimina="Delete from age_web.deduc_metalurgicas where cod_recepcion = '".$CodAsig."' and ";
			$Elimina.=" cod_subproducto = '".$CodSubProd."' and cod_leyes = '".$CodLey."' ";
			if ($RutPrv!='T')
				 $Elimina.=" and rut_proveedor = '".$RutPrv."'";
			mysqli_query($link, $Elimina);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='age_parametros_deduccion.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();</script>";
			break;

	}
?>