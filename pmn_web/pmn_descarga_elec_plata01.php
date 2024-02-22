<?php
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
	$Fecha = $Ano."-".str_pad($Mes,'2','0',STR_PAD_LEFT)."-".$Dia;
	
	$HorasProceso=str_replace('.','',$HorasProceso);
	$HorasProceso=str_replace(',','.',$HorasProceso);
	$CantOrejas=str_replace('.','',$CantOrejas);
	$CantOrejas=str_replace(',','.',$CantOrejas);
	$PesoResto=str_replace('.','',$PesoResto);
	$PesoResto=str_replace(',','.',$PesoResto);
	$Kwh=str_replace('.','',$Kwh);
	$Kwh=str_replace(',','.',$Kwh);
	$PesoCrudo=str_replace('.','',$PesoCrudo);
	$PesoCrudo=str_replace(',','.',$PesoCrudo);
	$Humedad=str_replace('.','',$Humedad);
	$Humedad=str_replace(',','.',$Humedad);
	switch ($Proceso)
	{
		case "G": //GRABAR			
			$Consulta = "select * from pmn_web.descarga_electrolisis_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualiza
				$PesoAnterior=$Row[peso_resto];
				$CantAnterior=$Row[cant_orejas];
				$Actualizar = "UPDATE pmn_web.descarga_electrolisis_plata set";
				$Actualizar.= " hrs_proceso = '".$HorasProceso."', ";
				$Actualizar.= " grupo = '".$Grupo."', ";
				$Actualizar.= " cant_orejas = '".$CantOrejas."', ";
			    $Actualizar.= " peso_resto = '".$PesoResto."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " jefe_turno = '".$JefeTurno."', ";
				$Actualizar.= " observacion = '".$Obs."', ";
				$Actualizar.= " kwh = '".$Kwh."', ";
				$Actualizar.= " peso_aurifero = '".$PesoCrudo."',";
				$Actualizar.= " humedad = '".$Humedad."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$Turno."'";				
				$Actualizar.= " and num_electrolisis = '".$NumElectrolisis."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
				
				StockPmn_valor('19','17',$Ano,$Mes,'E','P',$PesoAnterior,$CantAnterior);				
				StockPmn_valor('19','17',$Ano,$Mes,'I','P',$PesoResto,$CantOrejas);				
			}
			else
			{
				//Inserta
				$Insertar = "INSERT INTO pmn_web.descarga_electrolisis_plata ";
				$Insertar.= "(rut, fecha, turno, num_electrolisis, grupo, hrs_proceso, cant_orejas, peso_resto, operador,jefe_turno, observacion,kwh,peso_aurifero,humedad) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$NumElectrolisis."','".$Grupo."','".$HorasProceso."',";
				$Insertar.= "'".$CantOrejas."','".$PesoResto."','".$Operador."','".$JefeTurno."','".$Obs."', '".$Kwh."', '".$PesoCrudo."', '".$Humedad."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
				
				StockPmn_valor('19','17',$Ano,$Mes,'I','P',$PesoResto,$CantOrejas);				

			}			
			header("location:pmn_principal_reportes.php?DElect2=".$Dia."&MElect2=".$Mes."&AElect2=".$Ano."&Tab3=true&TabElec2=true&VerElect2=O&ElectDesc=".$NumElectrolisis);
			break;
		case "M":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					header("location:pmn_principal_reportes.php?MostrarElect2=S&DElect2=".$Dia."&MElect2=".$Mes."&AElect2=".$Ano."&Turno=".$p."&Grupo=".$ChkGrupo[$i]."&NumElectrolisis=".$ChkNumElec[$i]."&Tab3=true&TabElec2=true");
				}
			}
			else
			{
				header("location:pmn_principal_reportes.php?DElect2=".$Dia."&MElect2=".$Mes."&AElect2=".$Ano."&Tab3=true&TabElec2=true");
			}
			break;
		case "E":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					$Consulta = "select * from pmn_web.descarga_electrolisis_plata ";
					$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Consulta.= " and turno = '".$p."'";
					$Consulta.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					//echo $Consulta."<br>";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						//Actualiza
						$PesoAnterior=$Row[peso_resto];
						$CantAnterior=$Row[cant_orejas];
					}
					$Eliminar = "delete from pmn_web.descarga_electrolisis_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					mysqli_query($link, $Eliminar);
					
					StockPmn_valor('19','17',$Ano,$Mes,'E','P',$PesoAnterior,$CantAnterior);	
					
				}
			}
			header("location:pmn_principal_reportes.php?DElect2=".$Dia."&MElect2=".$Mes."&AElect2=".$Ano."&Tab3=true&TabElec2=true");
			break;
			case "S":
			
			if (count($checkbox)>0)
			{
				$valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		            {
					
				    $Eliminar = "delete from pmn_web.descarga_electrolisis_plata ";
					$Eliminar.= " where num_electrolisis = '".$v."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}
		case "C": //CANCELAR
			header("location:pmn_principal_reportes.php?&Tab3=true&TabElec2=true");
			break;
	}
?>