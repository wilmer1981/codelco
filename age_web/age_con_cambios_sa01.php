<?php
	include("../principal/conectar_principal.php");
	$Proceso    = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("n");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$TxtValores = isset($_REQUEST["TxtValores"])?$_REQUEST["TxtValores"]:"";
	$SubProducto= isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor  = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";

	$CmbMes        = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("n");
	$CmbAno        = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbSubProducto= isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor  = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtAjuPeso   = isset($_REQUEST["TxtAjuPeso"])?$_REQUEST["TxtAjuPeso"]:"";
	$TxtAjuCu     = isset($_REQUEST["TxtAjuCu"])?$_REQUEST["TxtAjuCu"]:"";
	$TxtAjuAg     = isset($_REQUEST["TxtAjuAg"])?$_REQUEST["TxtAjuAg"]:"";
	$TxtAjuAu     = isset($_REQUEST["TxtAjuAu"])?$_REQUEST["TxtAjuAu"]:"";

	switch ($Proceso)
	{
		case "U":
			$Datos = explode("///",$TxtValores);
			$MesAjuste = date("n", mktime(0,0,0,$Mes+1,1,$Ano));
			$AnoAjuste = date("Y", mktime(0,0,0,$Mes+1,1,$Ano));
			$SubProductoAnt = $SubProducto;
			foreach($Datos as $k => $v)
			{
				$Datos01=explode("~~",$v);
				$Producto = $Datos01[0];
				$SubProducto = $Datos01[1];
				$RutProveedor = $Datos01[2];
				$CodLeyes = $Datos01[3];
				$ValorAjuste = $Datos01[4];
				$Consulta = "select * from age_web.ajustes ";
				$Consulta.= " where ano='".$AnoAjuste."' and mes='".$MesAjuste."' ";
				$Consulta.= " and cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."' and rut_proveedor='".$RutProveedor."' ";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Resp))
				{
					$Actualizar = "UPDATE age_web.ajustes SET ";
					switch ($CodLeyes)
					{
						case "01":
							$Actualizar.= " peso_seco=(peso_seco+".$ValorAjuste.") ";
							break;
						case "02":
							$Actualizar.= " fino_cu=(fino_cu+".$ValorAjuste.") ";
							break;
						case "04":
							$Actualizar.= " fino_ag=(fino_ag+".$ValorAjuste.") ";
							break;
						case "05":
							$Actualizar.= " fino_au=(fino_au+".$ValorAjuste.") ";
							break;
					}
					$Actualizar.= " where ano='".$AnoAjuste."' and mes='".$MesAjuste."' ";
					$Actualizar.= " and cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."' and rut_proveedor='".$RutProveedor."' ";
					mysqli_query($link, $Actualizar);
				}
				else
				{
					$Insertar = "INSERT INTO age_web.ajustes(ano, mes, cod_producto, cod_subproducto, rut_proveedor ";
					switch ($CodLeyes)
					{
						case "01":
							$Insertar.= ", peso_seco)";
							break;
						case "02":
							$Insertar.= ", fino_cu)";
							break;
						case "04":
							$Insertar.= ", fino_ag)";
							break;
						case "05":
							$Insertar.= ", fino_au)";
							break;
					}
					$Insertar.= " values ('".$AnoAjuste."','".$MesAjuste."','".$Producto."','".$SubProducto."','".$RutProveedor."','".$ValorAjuste."')";
					mysqli_query($link, $Insertar);
				}//FIN ELSE
			}
			header("location:age_con_cambios_sa.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."&SubProducto=".$SubProductoAnt."&Proveedor=".$Proveedor);
			break;
		case "E":
			$Datos = explode("///",$TxtValores);
			$MesAjuste = date("n", mktime(0,0,0,$Mes+1,1,$Ano));
			$AnoAjuste = date("Y", mktime(0,0,0,$Mes+1,1,$Ano));
			$SubProductoAnt = $SubProducto;
			foreach($Datos as $k => $v)
			{
				$Datos01=explode("~~",$v);
				$AnoAjuste = $Datos01[0];
				$MesAjuste = $Datos01[1];
				$Producto = $Datos01[2];
				$SubProducto = $Datos01[3];
				$RutProveedor = $Datos01[4];
				$Eliminar = "delete from age_web.ajustes ";
				$Eliminar.= " where ano='".$AnoAjuste."' and mes='".$MesAjuste."' ";
				$Eliminar.= " and cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."' and rut_proveedor='".$RutProveedor."' ";
				mysqli_query($link, $Eliminar);
			}
			header("location:age_con_cambios_sa.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."&SubProducto=".$SubProductoAnt."&Proveedor=".$Proveedor);
			break;
		case "AM"://AJUSTE MANUAL
			$Consulta = "select * from age_web.ajustes ";
			$Consulta.= " where ano='".$CmbAno."' and mes='".$CmbMes."' ";
			$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."' and rut_proveedor='".$CmbProveedor."' ";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resp))
			{
				//ACTUALIZO
				$Actualizar = "UPDATE age_web.ajustes SET ";
				$Actualizar.= " peso_seco='".str_replace(",",".",$TxtAjuPeso)."' ";
				$Actualizar.= " , fino_cu='".str_replace(",",".",$TxtAjuCu)."' ";
				$Actualizar.= " , fino_ag='".str_replace(",",".",$TxtAjuAg)."' ";
				$Actualizar.= " , fino_au='".str_replace(",",".",$TxtAjuAu)."' ";
				$Actualizar.= " where ano='".$CmbAno."' and mes='".$CmbMes."' ";
				$Actualizar.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."' and rut_proveedor='".$CmbProveedor."' ";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//INSERTO
				$Insertar = "INSERT INTO age_web.ajustes(ano, mes, cod_producto, cod_subproducto, ";
				$Insertar.= " rut_proveedor, peso_seco, fino_cu, fino_ag, fino_au)";
				$Insertar.= " values ('".$CmbAno."','".$CmbMes."','1','".$CmbSubProducto."',";
				$Insertar.= " '".$CmbProveedor."','".str_replace(",",".",$TxtAjuPeso)."',";
				$Insertar.= " '".str_replace(",",".",$TxtAjuCu)."','".str_replace(",",".",$TxtAjuAg)."','".str_replace(",",".",$TxtAjuAu)."')";
				mysqli_query($link, $Insertar);
			}
			$ClaveAjuste=$CmbAno."~~".$CmbMes."~~1~~".$CmbSubProducto."~~".$CmbProveedor;
			header("location:age_con_cambios_sa_ajuste_manual.php?Proceso=M&TxtValores=".$ClaveAjuste);			
			break;
	}
?>