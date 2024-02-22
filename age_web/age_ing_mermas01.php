<?php
	include("../principal/conectar_principal.php");
	$CmbContrato = str_replace("~~"," ",$CmbContrato);
	switch ($Proceso)
	{
		case "N":
			$Insertar = "insert into age_web.mermas (cod_producto, cod_subproducto, rut_proveedor, cod_contrato, tipo_aplicacion, referencia, porc,fecha) ";
			$Insertar.= " values(";
			switch ($ChkDefin)
			{
				case "S":
					$Insertar.= "'1','".$CmbSubProducto."','','',";
					break;
				case "P":
					$Insertar.= "'1','".$CmbSubProducto."','".$CmbProveedor."','',";
					break;
				case "C":
					$Insertar.= "'1','".$CmbSubProducto."','','".$CmbContrato."',";
					break;
			}
			$Insertar.= " '".$ChkAplic."','".$CmbReferencia."',";
			$Insertar.= " '".str_replace(",",".",$TxtPorc)."','".$TxtFechaIni."')";
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
			header("location:age_ing_mermas02.php?Proc=N&ChkDefin=".$ChkDefin);
			break;	
		case "M":
			$Actualizar = " UPDATE age_web.mermas set ";
			$Actualizar.= " tipo_aplicacion='".$ChkAplic."'";
			$Actualizar.= " , referencia='".$CmbReferencia."'";
			$Actualizar.= " , porc='".str_replace(",",".",$TxtPorc)."'";
			$Actualizar.= " , fecha='".$TxtFechaIni."'";
			$Actualizar.= " where cod_producto='1'";
			$Actualizar.= " and cod_subproducto='".$CmbSubProducto."'";
			$Actualizar.= " and rut_proveedor='".$CmbProveedor."'";
			$Actualizar.= " and cod_contrato='".$CmbContrato."'";
			mysqli_query($link, $Actualizar);
			$Valores = "1~~".$CmbSubProducto."~~".$CmbProveedor."~~".$CmbContrato."~~".$ChkAplic."~~".$CmbReferencia;
			header("location:age_ing_mermas02.php?Proc=M&Valores=".$Valores);
			break;
		case "E":			
			$Datos = explode("~~",$ChkSelec);			
			$Eliminar = "delete from age_web.mermas ";
			$Eliminar.= " where cod_producto='".$Datos[0]."'";
			$Eliminar.= " and cod_subproducto='".$Datos[1]."'";
			$Eliminar.= " and rut_proveedor='".$Datos[2]."'";
			$Eliminar.= " and cod_contrato='".$Datos[3]."'";
			$Eliminar.= " and tipo_aplicacion='".$Datos[4]."'";
			$Eliminar.= " and referencia='".$Datos[5]."'";
			mysqli_query($link, $Eliminar);			
			header("location:age_ing_mermas.php");
			break;		
	}
?>