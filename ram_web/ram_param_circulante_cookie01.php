<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G":
			if (isset($ChkRecep))
			{
				$Insertar = "INSERT INTO ram_web.cookie ";
				$Insertar.= " (ano,mes,tipo_movimiento,flujo,peso_humedo,peso_seco,fino_cu,fino_ag,fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','E','".$Flujo."','".$PesoHum."','".$PesoSeco."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
				mysqli_query($link, $Insertar);
			}
			if (isset($ChkBenef))
			{
				$Insertar = "INSERT INTO ram_web.cookie ";
				$Insertar.= " (ano,mes,tipo_movimiento,flujo,peso_humedo,peso_seco,fino_cu,fino_ag,fino_au, fino_as) ";
				$Insertar.= " VALUES('".$Ano."','".$Mes."','S','".$Flujo."','".$PesoHum."','".$PesoSeco."','".$FinoCu."','".$FinoAg."','".$FinoAu."','".$FinoAs."')";
				mysqli_query($link, $Insertar);
			}
			header("location:ram_param_circulante_cookie.php?Ano=".$Ano."&Mes=".$Mes);
			break;
		case "E":
			$Datos = explode("//",$Valores);
			$Eliminar = "delete from ram_web.cookie ";
			$Eliminar.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Eliminar.= " and tipo_movimiento='".$Datos[0]."' and flujo='".$Datos[1]."' ";
			mysqli_query($link, $Eliminar);
			header("location:ram_param_circulante_cookie.php?Ano=".$Ano."&Mes=".$Mes);
			break;
	}
?>