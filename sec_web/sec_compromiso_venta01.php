<?php
	include("../principal/conectar_principal.php");

	$Rut =$CookieRut;

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Tipo    = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
	$MesIni2 = isset($_REQUEST["MesIni2"])?$_REQUEST["MesIni2"]:"";
	$AnoIni2 = isset($_REQUEST["AnoIni2"])?$_REQUEST["AnoIni2"]:"";
	$CmbCliente  = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$Pais        = isset($_REQUEST["Pais"])?$_REQUEST["Pais"]:"";
	$CmbContrato = isset($_REQUEST["CmbContrato"])?$_REQUEST["CmbContrato"]:"";
	$Tonelada    = isset($_REQUEST["Tonelada"])?$_REQUEST["Tonelada"]:0;
	$ChkContrato1= isset($_REQUEST["ChkContrato1"])?$_REQUEST["ChkContrato1"]:"";
	$ChkTonelajeTotal= isset($_REQUEST["ChkTonelajeTotal"])?$_REQUEST["ChkTonelajeTotal"]:"";
	$ChkTonelaje1 = isset($_REQUEST["ChkTonelaje1"])?$_REQUEST["ChkTonelaje1"]:"";
	$ChkTonelaje2 = isset($_REQUEST["ChkTonelaje2"])?$_REQUEST["ChkTonelaje2"]:"";
	$ChkTonelaje3 = isset($_REQUEST["ChkTonelaje3"])?$_REQUEST["ChkTonelaje3"]:"";
	$ChkTonelaje4 = isset($_REQUEST["ChkTonelaje4"])?$_REQUEST["ChkTonelaje4"]:"";
	$ChkTonelaje5 = isset($_REQUEST["ChkTonelaje5"])?$_REQUEST["ChkTonelaje5"]:"";
	$ChkTonelaje6 = isset($_REQUEST["ChkTonelaje6"])?$_REQUEST["ChkTonelaje6"]:"";
	$ChkTonelaje7 = isset($_REQUEST["ChkTonelaje7"])?$_REQUEST["ChkTonelaje7"]:"";
	$ChkTonelaje8 = isset($_REQUEST["ChkTonelaje8"])?$_REQUEST["ChkTonelaje8"]:"";
	$ChkTonelaje9 = isset($_REQUEST["ChkTonelaje9"])?$_REQUEST["ChkTonelaje9"]:"";
	$ChkTonelaje10 = isset($_REQUEST["ChkTonelaje10"])?$_REQUEST["ChkTonelaje10"]:"";
	$ChkTonelaje11 = isset($_REQUEST["ChkTonelaje11"])?$_REQUEST["ChkTonelaje11"]:"";
	$ChkTonelaje12 = isset($_REQUEST["ChkTonelaje12"])?$_REQUEST["ChkTonelaje12"]:"";
	$ChkCliente    = isset($_REQUEST["ChkCliente"])?$_REQUEST["ChkCliente"]:"";

	if ($Tipo == "E")
		$Cliente = $CmbCliente;
	else
		$Cliente = $Pais;
	
	switch ($Proceso)
	{
		case "O": //GRABAR
			$Consulta="select * from sec_web.programa_ventas ";
			$Consulta.= " where enm_code = '".$Tipo."'";
			if ($Tipo == "E")
				$Consulta.= " and cod_contrato = '".$CmbContrato."'";
			$Consulta.= " and ano = '".$AnoIni2."'";
			$Consulta.= " and cod_cliente = '".$Cliente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Mostrar='S';
			}
			else
			{				
				$Insertar = "insert ignore into sec_web.programa_ventas ";
				$Insertar.= "(enm_code,cod_cliente,cod_contrato,tonelaje_total,ano) ";
				$Insertar.= "values('".$Tipo."','".$Cliente."','".$CmbContrato."','".str_replace(",",".",$Tonelada)."','".$AnoIni2."')";
				mysqli_query($link, $Insertar);	
			}
			header("location:sec_compromiso_venta.php?Mostrar=".$Mostrar."&AnoIni2=".$AnoIni2."&MesIni2=".$MesIni2."&Tipo=".$Tipo."&CmbCliente=".$CmbCliente."&Pais=".$Pais);
			break;
		case "G": //GRABAR 
			if (is_countable($ChkContrato1) && count($ChkContrato1)>0)
			{
				foreach($ChkContrato1 as $i => $p)
				{
					if ($ChkTonelaje1[$i]=='')
					{
						$ChkTonelaje1[$i]="NULL";
					}
					if ($ChkTonelaje2[$i]=='')
					{
						$ChkTonelaje2[$i]="NULL";
					}
					if ($ChkTonelaje3[$i]=='')
					{
						$ChkTonelaje3[$i]="NULL";
					}
					if ($ChkTonelaje4[$i]=='')
					{
						$ChkTonelaje4[$i]="NULL";
					}
					if ($ChkTonelaje5[$i]=='')
					{
						$ChkTonelaje5[$i]="NULL";
					}
					if ($ChkTonelaje6[$i]=='')
					{
						$ChkTonelaje6[$i]="NULL";
					}
					if ($ChkTonelaje7[$i]=='')
					{
						$ChkTonelaje7[$i]="NULL";
					}
					if ($ChkTonelaje8[$i]=='')
					{
						$ChkTonelaje8[$i]="NULL";
					}
					if ($ChkTonelaje9[$i]=='')
					{
						$ChkTonelaje9[$i]="NULL";
					}
					if ($ChkTonelaje10[$i]=='')
					{
						$ChkTonelaje10[$i]="NULL";
					}
					if ($ChkTonelaje11[$i]=='')
					{
						$ChkTonelaje11[$i]="NULL";
					}
					if ($ChkTonelaje12[$i]=='')
					{
						$ChkTonelaje12[$i]="NULL";
					}
								//Actualizar
					$Actualizar = "UPDATE sec_web.programa_ventas set ";
					$Actualizar.= " tonelaje_total = ".str_replace(",",".",$ChkTonelajeTotal[$i]).", ";
					$Actualizar.= " ene = ".str_replace(",",".",$ChkTonelaje1[$i]).", ";
					$Actualizar.= " feb = ".str_replace(",",".",$ChkTonelaje2[$i]).",  ";
					$Actualizar.= " mar = ".str_replace(",",".",$ChkTonelaje3[$i]).",  ";
					$Actualizar.= " abr = ".str_replace(",",".",$ChkTonelaje4[$i]).",  ";
					$Actualizar.= " may = ".str_replace(",",".",$ChkTonelaje5[$i]).", ";
					$Actualizar.= " jun = ".str_replace(",",".",$ChkTonelaje6[$i]).",  ";
					$Actualizar.= " jul = ".str_replace(",",".",$ChkTonelaje7[$i]).",  ";
					$Actualizar.= " ago = ".str_replace(",",".",$ChkTonelaje8[$i]).",  ";
					$Actualizar.= " sep = ".str_replace(",",".",$ChkTonelaje9[$i]).", ";
					$Actualizar.= " oct = ".str_replace(",",".",$ChkTonelaje10[$i]).",  ";
					$Actualizar.= " nov = ".str_replace(",",".",$ChkTonelaje11[$i]).",  ";
					$Actualizar.= " dic = ".str_replace(",",".",$ChkTonelaje12[$i])."  ";
					$Actualizar.= " where enm_code = '".$Tipo."'";
					if ($Tipo == "E")
						$Actualizar.= " and cod_contrato = '".$p."'";
					$Actualizar.= " and ano = '".$AnoIni2."'";
					$Actualizar.= " and cod_cliente = '".$ChkCliente[$i]."'";
					mysqli_query($link, $Actualizar);
				}
			}	
			//header("location:sec_compromiso_venta.php?Mostrar=".$Mostrar."&Tipo=".$Tipo."&AnoIni2=".$AnoIni2."&MesIni2=".$MesIni2."&Tipo=".$Tipo."&CmbCliente=".$CmbCliente."&Pais=".$Pais);
			header("location:sec_compromiso_venta.php?Mostrar=".$Mostrar."&AnoIni2=".$AnoIni2."&MesIni2=".$MesIni2."&Tipo=".$Tipo."&CmbCliente=".$CmbCliente."&Pais=".$Pais);
			break;
		case "E":
			if (is_countable($ChkContrato1) && count($ChkContrato1)>0)
			{
				foreach($ChkContrato1 as $i => $p)
				{
					// ELIMINA DETALLE
					$Eliminar = "delete from  sec_web.programa_ventas ";
					$Eliminar.= " where enm_code = '".$Tipo."' ";
					if ($Tipo == "E")
						$Eliminar.= " and cod_contrato = '".$p."'"; 
					$Eliminar.= " and ano = '".$AnoIni2."'";
					$Eliminar.= " and cod_cliente = '".$ChkCliente[$i]."'";
					mysqli_query($link, $Eliminar);
				}
			}
			//header("location:sec_compromiso_venta.php?Mostrar=".$Mostrar."&Tipo=".$Tipo."&AnoIni2=".$AnoIni2."&MesIni2=".$MesIni2."&Tipo=".$Tipo."&CmbCliente=".$CmbCliente."&Pais=".$Pais);
			header("location:sec_compromiso_venta.php?Mostrar=".$Mostrar."&AnoIni2=".$AnoIni2."&MesIni2=".$MesIni2."&Tipo=".$Tipo."&CmbCliente=".$CmbCliente."&Pais=".$Pais);
			break;		
	}
?>