<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	
	switch ($Proceso)
	{
		case "G": //GRABAR
			$PesoAnodos=str_replace(".","",$PesoAnodos);
			$PesoAnodos=str_replace(",",".",$PesoAnodos);
			$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " and grupo = '".$Grupo."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			$Consulta.= " and correlativo = '".$Correlativo."'";
			$Consulta.= " and hornada = '".$Hornada."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				$PesoAnterior=$Row[peso_anodos];
				$CantAnterior=$Row[cant_anodos];
				//Actualiza
				$Actualizar = "UPDATE pmn_web.carga_electrolisis_plata set";
				$Actualizar.= " cant_anodos = '".$CantAnodos."', ";
			    $Actualizar.= " peso_anodos = '".$PesoAnodos."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " observacion = '".$Obs."' , ";
				$Actualizar.= " jefe_turno = '".$JefeTurno."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$Turno."'";
				$Actualizar.= " and grupo = '".$Grupo."'";
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				$Actualizar.= " and correlativo = '".$Correlativo."'";
				$Actualizar.= " and hornada = '".$HornadaElect."'";
				//echo $Actualizar;
				mysqli_query($link, $Actualizar);
				
				StockPmn_valor('44','1',$Ano,$Mes,'E','B',str_replace(",",".",$PesoAnterior),$CantAnterior);
				StockPmn_valor('44','1',$Ano,$Mes,'I','B',$PesoAnodos,$CantAnodos);
			}
			else
			{
				//Inserta
				$Insertar = "INSERT INTO pmn_web.carga_electrolisis_plata ";
				$Insertar.= "(rut, fecha, turno, grupo, num_electrolisis, correlativo, hornada, cant_anodos, ";
				$Insertar.= "peso_anodos, operador, observacion,jefe_turno) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$Grupo."','".$NumElectrolisis."',";
				$Insertar.= "'".$Correlativo."','".$HornadaElect."','".$CantAnodos."','".$PesoAnodos."','".$Operador."','".$Obs."','".$JefeTurno."')";
				//echo $Insertar;
				mysqli_query($link, $Insertar);
				
				StockPmn_valor('44','1',$Ano,$Mes,'I','B',$PesoAnodos,$CantAnodos);
			}
			
			header("location:pmn_principal_reportes.php?DiaMod=".$Dia."&MesMod=".$Mes."&AnoMod=".$Ano."&Turno=".$Turno."&Grupo=".$Grupo."&NumElectrolisis=".$NumElectrolisis."&Correlativo=".$Correlativo."&Operador=".$Operador."&JefeTurno=".$JefeTurno."&Tab3=true&TabElec1=true&Consulta=S&Graba=S");
			break;
		case "M":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					header("location:pmn_principal_reportes.php?MostrarElect1=S&DiaMod=".$Dia."&MesMod=".$Mes."&AnoMod=".$Ano."&Turno=".$p."&Proceso=".$Proceso."&Grupo=".$ChkGrupo[$i]."&NumElectrolisis=".$ChkNumElec[$i]."&Correlativo=".$ChkCorrelativo[$i]."&Hornada=".$ChkHornada[$i]."&Tab3=true&TabElec1=true");
				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?DiaMod=".$Dia."&MesMod=".$Mes."&AnoMod=".$Ano."&Tab3=true&TabElec1=true");
			}
			break;
		case "E":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
					$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Consulta.= " and turno = '".$p."'";
					$Consulta.= " and grupo = '".$ChkGrupo[$i]."'";
					$Consulta.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					$Consulta.= " and correlativo = '".$ChkCorrelativo[$i]."'";
					$Consulta.= " and hornada = '".$ChkHornada[$i]."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						$PesoAnterior=$Row[peso_anodos];
						$CantAnterior=$Row[cant_anodos];
					}
					$Eliminar = "delete from pmn_web.carga_electrolisis_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and grupo = '".$ChkGrupo[$i]."'";
					$Eliminar.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					$Eliminar.= " and correlativo = '".$ChkCorrelativo[$i]."'";
					$Eliminar.= " and hornada = '".$ChkHornada[$i]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
					
					StockPmn_valor('44','1',$Ano,$Mes,'E','B',str_replace(",",".",$PesoAnterior),$CantAnterior);
				}
			}
			case "S":
			
			if (count($checkbox)>0)
			{
				$valores = explode("//",$parametros);
		        while(list($c,$v) = each($valores))
		        {
					$valores2 = explode("~",$v);
					$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
					$Consulta.= " where fecha = '".$valores2[0]."'";
					$Consulta.= " and num_electrolisis = '".$valores2[1]."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						$PesoAnterior=$Row[peso_anodos];
						$CantAnterior=$Row[cant_anodos];
					}
				    $Eliminar = "delete from pmn_web.carga_electrolisis_plata ";
					$Eliminar.= " where fecha = '".$valores2[0]."' and num_electrolisis = '".$valores2[1]."'";
					mysqli_query($link, $Eliminar);
					$AnoMesDia=explode('-',$valores2[0]);
					StockPmn_valor('44','1',$AnoMesDia[0],$AnoMesDia[1],'E','B',$PesoAnterior,$CantAnterior);
					
				}
			}
			header("location:pmn_principal_reportes.php?DiaMod=".$Dia."&MesMod=".$Mes."&AnoMod=".$Ano."&Tab3=true&TabElec1=true&Elim=S&Electrolisis=".$NumElectrolisis);
			break;
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?Tab3=true&TabElec1=true");
			break;
	}
?>
