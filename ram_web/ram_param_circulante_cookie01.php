<?
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G":
			if (isset($ChkRecep))
			{
				$Insertar = "insert into ram_web.cookie ";
				$Insertar.= " (ano,mes,tipo_movimiento,flujo,peso_humedo,peso_seco,fino_cu,fino_ag,fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','E','".$Flujo."','".$PesoHum."','".$PesoSeco."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
				mysql_query($Insertar);
			}
			if (isset($ChkBenef))
			{
				$Insertar = "insert into ram_web.cookie ";
				$Insertar.= " (ano,mes,tipo_movimiento,flujo,peso_humedo,peso_seco,fino_cu,fino_ag,fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','S','".$Flujo."','".$PesoHum."','".$PesoSeco."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
				mysql_query($Insertar);
			}
			header("location:ram_param_circulante_cookie.php?Ano=".$Ano."&Mes=".$Mes);
			break;
		case "E":
			$Datos = explode("//",$Valores);
			$Eliminar = "delete from ram_web.cookie ";
			$Eliminar.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Eliminar.= " and tipo_movimiento='".$Datos[0]."' and flujo='".$Datos[1]."' ";
			mysql_query($Eliminar);
			header("location:ram_param_circulante_cookie.php?Ano=".$Ano."&Mes=".$Mes);
			break;
	}
?>