<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.barro_aurifero_crudo ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.barro_aurifero_crudo set";
				$Actualizar.= " energia_elec = '".str_replace(",",".",$EnergiaElec)."', ";
				$Actualizar.= " grupo = '".$Grupo."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " observacion = '".$Obs."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";				
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				$Actualizar.= " and turno = '".$Turno."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.barro_aurifero_crudo ";
				$Insertar.= "(rut, fecha, num_electrolisis, grupo, energia_elec, operador, observacion,turno) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$NumElectrolisis."','".$Grupo."','".str_replace(",",".",$EnergiaElec)."','".$Operador."','".$Obs."','".$Turno."')";
				mysqli_query($link, $Insertar);
			}
			//header("location:pmn_barro_aurifero_crudo.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis."&Turno=".$Turno);
			break;
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.detalle_barro_aurifero_crudo ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			$Consulta.= " and num_bolsa = '".$Bolsa."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.detalle_barro_aurifero_crudo set ";
				$Actualizar.= " peso_humedo = '".str_replace(",",".",$PesoHumedo)."', ";
				$Actualizar.= " porc_humedad = '".str_replace(",",".",$PorcHumedad)."' ";
				$Actualizar.= " where fecha = '".$Fecha."' ";				
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				$Actualizar.= " and num_bolsa = '".$Bolsa."'";
				$Actualizar.= " and turno = '".$Turno."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.detalle_barro_aurifero_crudo ";
				$Insertar.= "(rut, fecha, num_electrolisis, num_bolsa, peso_humedo, porc_humedad,turno) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$NumElectrolisis."','".$Bolsa."','".str_replace(",",".",$PesoHumedo)."','".str_replace(",",".",$PorcHumedad)."','".$Turno."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_barro_aurifero_crudo.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis."&Turno=".$Turno);
			break;
		case "M":
			if (count($ChkBolsa)>0)
			{
				while (list($i,$p) = each($ChkBolsa))
				{
					header("location:pmn_barro_aurifero_crudo.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis."&Bolsa=".$p."&PesoHumedo=".$ChkPesoHumedo[$i]."&PorcHumedad=".$ChkPorcHumedad[$i]."&Turno=".$Turno);
				}
			}
			else
			{
				header("location:pmn_barro_aurifero_crudo.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E":
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.barro_aurifero_crudo ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$Eliminar.= " and num_electrolisis = '".$NumElectrolisis."'";					
			$Eliminar.= " and turno = '".$Turno."'";
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from pmn_web.detalle_barro_aurifero_crudo ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$Eliminar.= " and num_electrolisis = '".$NumElectrolisis."'";					
			$Eliminar.= " and turno = '".$Turno."'";
			mysqli_query($link, $Eliminar);
			header("location:pmn_barro_aurifero_crudo.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Turno=".$Turno);
			break;
		case "E2":
			if (count($ChkBolsa)>0)
			{
				while (list($i,$p) = each($ChkBolsa))
				{
					$Eliminar = "delete from pmn_web.detalle_barro_aurifero_crudo ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and num_electrolisis = '".$NumElectrolisis."'";
					$Eliminar.= " and num_bolsa = '".$p."'";					
					$Eliminar.= " and turno = '".$Turno."'";
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_barro_aurifero_crudo.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumElectrolisis=".$NumElectrolisis."&Turno=".$Turno);
			break;
			case "S":
			
			if (count($checkbox)>0)
			{
				$valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		            {
					
				   	$Eliminar = "delete from pmn_web.barro_aurifero_crudo ";
					$Eliminar.= " where num_electrolisis = '".$v."'";
					//echo $Eliminar;
					mysqli_query($link, $Eliminar);
					$Eliminar2 = "delete from pmn_web.detalle_barro_aurifero_crudo ";
					$Eliminar2.= " where num_electrolisis = '".$v."'";
					//echo $Eliminar2;
					mysqli_query($link, $Eliminar2);
					
				}
			}
		case "C": //CANCELAR
			header("location:pmn_barro_aurifero_crudo.php");
			break;
	}
?>