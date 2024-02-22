<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.produccion_fusion_barro_aurifero ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.produccion_fusion_barro_aurifero set";
				$Actualizar.= " anodos = '".str_replace(",",".",$Anodos)."', ";
				$Actualizar.= " peso = '".str_replace(",",".",$Peso)."', ";
				$Actualizar.= " colada = '".str_replace(",",".",$Colada)."', ";
				$Actualizar.= " escoria = '".str_replace(",",".",$Escoria)."', ";
				$Actualizar.= " porc_recuperacion = '".str_replace(",",".",$PorcRecuperacion)."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " observacion = '".$Obs."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";				
				$Actualizar.= " and hornada = '".$Hornada."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_fusion_barro_aurifero ";
				$Insertar.= "(rut, fecha, hornada, operador, observacion, anodos, peso, colada, escoria, porc_recuperacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Hornada."','".$Operador."','".$Obs."', ";
				$Insertar.= "'".str_replace(",",".",$Anodos)."','".str_replace(",",".",$Peso)."', '".str_replace(",",".",$Colada)."', ";
				$Insertar.= "'".str_replace(",",".",$Escoria)."', '".str_replace(",",".",$PorcRecuperacion)."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_prod_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada);
			break;
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.detalle_prod_fusion_barro_aurifero ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.detalle_prod_fusion_barro_aurifero set ";
				$Actualizar.= " unidades = '".str_replace(",",".",$Unidades)."', ";
				$Actualizar.= " peso = '".str_replace(",",".",$Peso2)."', ";
				$Actualizar.= " observacion = '".$Obs2."' ";
				$Actualizar.= " where fecha = '".$Fecha."' ";
				$Actualizar.= " and hornada = '".$Hornada."'";				
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.detalle_prod_fusion_barro_aurifero ";
				$Insertar.= "(rut, fecha, hornada, num_electrolisis, unidades, peso, observacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."', '".$Hornada."','".$NumElectrolisis."','".$Unidades."','".str_replace(",",".",$Peso2)."','".$Obs2."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_prod_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada);
			break;
		case "M":
			if (count($ChkNumElectrolisis)>0)
			{
				while (list($i,$p) = each($ChkNumElectrolisis))
				{
					header("location:pmn_prod_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada."&NumElectrolisis=".$p."&Unidades=".$ChkUnidades[$i]."&Peso2=".$ChkPeso[$i]."&Obs2=".$ChkObservacion[$i]);
				}
			}
			else
			{
				header("location:pmn_prod_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada);
			}
			break;
		case "E":
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.produccion_fusion_barro_aurifero ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$Eliminar.= " and hornada = '".$Hornada."'";					
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from pmn_web.detalle_prod_fusion_barro_aurifero ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$Eliminar.= " and hornada = '".$Hornada."'";					
			mysqli_query($link, $Eliminar);
			header("location:pmn_prod_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E2":
			if (count($ChkNumElectrolisis)>0)
			{
				while (list($i,$p) = each($ChkNumElectrolisis))
				{
					$Eliminar = "delete from pmn_web.detalle_prod_fusion_barro_aurifero ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and hornada = '".$Hornada."'";
					$Eliminar.= " and num_electrolisis = '".$p."'";					
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_prod_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Hornada=".$Hornada);
			break;
		case "C": //CANCELAR
			header("location:pmn_prod_fusion_barro_aurifero.php");
			break;
	}
?>