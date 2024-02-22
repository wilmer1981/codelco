<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "SUMA":
			//ENVIA
			$Consulta = "select * from age_web.recepciones ";
			$Consulta.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Consulta.= " and cod_producto='".$EnvProd."' and cod_subproducto='".$EnvSubProd."'";
			$Consulta.= " and rut_proveedor='".$EnvRut."'";
   $Consulta.= " and peso_humedo='".$EnvPHum."'";
   $Consulta.= " and peso_seco='".$EnvPSec."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$EnvPSeco = $Fila["peso_seco"];
				$EnvPHumedo = $Fila["peso_humedo"];
				$EnvFinoCu = $Fila["fino_cu"];
				$EnvFinoAg = $Fila["fino_ag"];
				$EnvFinoAu = $Fila["fino_au"];
			}
			//RECIVE
			$Consulta = "select * from age_web.recepciones ";
			$Consulta.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Consulta.= " and cod_producto='".$RecProd."' and cod_subproducto='".$RecSubProd."'";
			$Consulta.= " and rut_proveedor='".$RecRut."'";
    $Consulta.= " and peso_humedo='".$RecPHum."'";
   $Consulta.= " and peso_seco='".$RecPSec."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$RecPSeco = $Fila["peso_seco"];
				$RecPHumedo = $Fila["peso_humedo"];
				$RecFinoCu = $Fila["fino_cu"];
				$RecFinoAg = $Fila["fino_ag"];
				$RecFinoAu = $Fila["fino_au"];
			}
			//ELIMINA REGISTRO ENVIADO
			$Eliminar = "delete from age_web.recepciones ";
			$Eliminar.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Eliminar.= " and cod_producto='".$EnvProd."' and cod_subproducto='".$EnvSubProd."'";
			$Eliminar.= " and rut_proveedor='".$EnvRut."'";
    $Eliminar.= " and peso_humedo='".$EnvPHum."'";
   $Eliminar.= " and peso_seco='".$EnvPSec."'";
			mysqli_query($link, $Eliminar);
			//ACTUALIZA REGISTRO RECEPTOR DE PESO
			$Actualizar = "UPDATE age_web.recepciones set ";
			$Actualizar.= " peso_seco = '".($RecPSeco + $EnvPSeco)."',";
			$Actualizar.= " peso_humedo = '".($RecPHumedo + $EnvPHumedo)."',";
			$Actualizar.= " fino_cu = '".($RecFinoCu + $EnvFinoCu)."',";
			$Actualizar.= " fino_ag = '".($RecFinoAg + $EnvFinoAg)."',";
			$Actualizar.= " fino_au = '".($RecFinoAu + $EnvFinoAu)."'";
			$Actualizar.= " where ano='".$Ano."' and mes='".$Mes."' ";
			$Actualizar.= " and cod_producto='".$RecProd."' and cod_subproducto='".$RecSubProd."'";
			$Actualizar.= " and rut_proveedor='".$RecRut."'";
   $Actualizar.= " and peso_humedo='".$RecPHum."'";
   $Actualizar.= " and peso_seco='".$RecPSec."'";
			mysqli_query($link, $Actualizar);
			break;
	}
	header("location:age_carga_liq15.php?Mostrar=S&Ano=".$Ano."&Mes=".$Mes."&SubProducto=".$RecSubProd);
?>
