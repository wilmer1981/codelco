<?php
	include("../principal/conectar_principal.php");
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";	
	$Ano = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Nodo = isset($_REQUEST["Nodo"])?$_REQUEST["Nodo"]:"";
	$Flujo = isset($_REQUEST["Flujo"])?$_REQUEST["Flujo"]:"";	
	$ChkRecep = isset($_REQUEST["ChkRecep"])?$_REQUEST["ChkRecep"]:"";
	$ChkBenef = isset($_REQUEST["ChkBenef"])?$_REQUEST["ChkBenef"]:"";	
	$PesoHum     = isset($_REQUEST["PesoHum"])?$_REQUEST["PesoHum"]:"";
	$PesoSeco    = isset($_REQUEST["PesoSeco"])?$_REQUEST["PesoSeco"]:"";
	$FinoCu      = isset($_REQUEST["FinoCu"])?$_REQUEST["FinoCu"]:"";
	$FinoAg      = isset($_REQUEST["FinoAg"])?$_REQUEST["FinoAg"]:"";
	$FinoAu      = isset($_REQUEST["FinoAu"])?$_REQUEST["FinoAu"]:"";
	$FinoAs      = isset($_REQUEST["FinoAs"])?$_REQUEST["FinoAs"]:"";
	
	
	switch ($Proceso)
	{
		case "G":
			if ($ChkRecep!="")
			{
				$Insertar = "insert into ram_web.cookie ";
				$Insertar.= " (ano,mes,tipo_movimiento,flujo,peso_humedo,peso_seco,fino_cu,fino_ag,fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','E','".$Flujo."','".$PesoHum."','".$PesoSeco."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
				mysqli_query($link,$Insertar);
			}
			if ($ChkBenef!="")
			{
				$Insertar = "insert into ram_web.cookie ";
				$Insertar.= " (ano,mes,tipo_movimiento,flujo,peso_humedo,peso_seco,fino_cu,fino_ag,fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','S','".$Flujo."','".$PesoHum."','".$PesoSeco."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
				mysqli_query($link,$Insertar);
			}
			header("location:ram_param_circulante_cookie.php?Ano=".$Ano."&Mes=".$Mes);
			break;
		case "E":
			$Datos = explode("//",$Valores);
			$Eliminar = "delete from ram_web.cookie ";
			$Eliminar.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Eliminar.= " and tipo_movimiento='".$Datos[0]."' and flujo='".$Datos[1]."' ";
			mysqli_query($link,$Eliminar);
			header("location:ram_param_circulante_cookie.php?Ano=".$Ano."&Mes=".$Mes);
			break;
	}
?>