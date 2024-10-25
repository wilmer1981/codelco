<?php
	include("../principal/conectar_principal.php");
	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mes         = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano         = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$ChkLeyes    = isset($_REQUEST["ChkLeyes"])?$_REQUEST["ChkLeyes"]:"";
	$PesoHum     = isset($_REQUEST["PesoHum"])?$_REQUEST["PesoHum"]:"";
	$TxtLeyHum   = isset($_REQUEST["TxtLeyHum"])?$_REQUEST["TxtLeyHum"]:0;
	$TxtLeyCu    = isset($_REQUEST["TxtLeyCu"])?$_REQUEST["TxtLeyCu"]:0;
	$TxtLeyAg    = isset($_REQUEST["TxtLeyAg"])?$_REQUEST["TxtLeyAg"]:0;
	$TxtLeyAu    = isset($_REQUEST["TxtLeyAu"])?$_REQUEST["TxtLeyAu"]:0;
	$TxtLeyAs    = isset($_REQUEST["TxtLeyAs"])?$_REQUEST["TxtLeyAs"]:0;
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	
	switch ($Proceso)
	{
		case "G":
			$P_Seco=0;$F_Cu=0;$F_Ag=0;$F_Au=0;$F_As=0;
			if ($ChkLeyes == "M")
			{
				$TxtLeyHum = str_replace(",",".",$TxtLeyHum);
				$TxtLeyCu = str_replace(",",".",$TxtLeyCu);
				$TxtLeyAg = str_replace(",",".",$TxtLeyAg);
				$TxtLeyAu = str_replace(",",".",$TxtLeyAu);
				$TxtLeyAs = str_replace(",",".",$TxtLeyAs);
				$P_Seco = ($PesoHum * (100-$TxtLeyHum))/100;
				$F_Cu = ($P_Seco * $TxtLeyCu)/100;
				$F_Ag = ($P_Seco * $TxtLeyAg)/1000;
				$F_Au = ($P_Seco * $TxtLeyAu)/1000;
				$F_As = ($P_Seco * $TxtLeyAs)/100;
			}
			$FechaAux1 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
			$FechaAux2 = date("Y-m-d", mktime(0,0,0,intval(substr($FechaAux1,5,2)),1-1,intval(substr($FechaAux1,0,4))));
			
			/*$Consulta = "SELECT COUNT(fecha) as cant FROM ram_web.stock_piso
						GROUP BY cod_producto,cod_subproducto
						HAVING COUNT(fecha) > 0";*/
				
			$Consulta="select * from ram_web.stock_piso ";
			$Consulta.=" where fecha = '".$FechaAux2."' and cod_producto = '".$Producto."' and cod_subproducto = '".$SubProducto."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			$CantReg  = mysqli_num_rows($Respuesta);
			if ($CantReg > 0)
			{
				$msg = "Registro ya existe...";
			}
			else
			{	
				$Insertar = "insert into ram_web.stock_piso ";
				$Insertar.= " (fecha,cod_existencia,cod_producto,cod_subproducto,peso_humedo, peso_seco, fino_cu, fino_ag, fino_au, fino_as, tipo_calculo) ";
				$Insertar.= " VALUES('".$FechaAux2."','01','".$Producto."','".$SubProducto."','".$PesoHum."',";
				$Insertar.= " '".$P_Seco."','".$F_Cu."','".$F_Ag."','".$F_Au."','".$F_As."','".$ChkLeyes."')";
				mysqli_query($link, $Insertar);
				$msg = "Registro grabado correctamente...";
			}
			header("location:ram_stock_piso_circulante.php?Mes=".$Mes."&Ano=".$Ano."&Mensaje=".$msg);
			/*
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frm1.action='ram_stock_piso_circulante.php';";
			echo "window.opener.document.frm1.submit();";
			echo "window.close();";
			echo "alert('".$msg."');";*/
			break;
		case "E":
			$FechaAux1 = date("Y-m-d", mktime(0,0,0,$Mes+1,1,$Ano));
			$FechaAux2 = date("Y-m-d", mktime(0,0,0,intval(substr($FechaAux1,5,2)),1-1,intval(substr($FechaAux1,0,4))));
			$Datos = explode("//",$Valores);
			$Eliminar = "delete from ram_web.stock_piso ";
			$Eliminar.= " where fecha='".$FechaAux2."' and cod_existencia='01' ";
			$Eliminar.= " and cod_producto='".$Datos[0]."' and cod_subproducto='".$Datos[1]."' ";
			mysqli_query($link, $Eliminar);
			header("location:ram_stock_piso_circulante.php?Mes=".$Mes."&Ano=".$Ano);
			break;
	}
?>