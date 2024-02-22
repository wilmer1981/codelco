<?php
	include("../principal/conectar_pmn_web.php");
	$Rut =$CookieRut;
	$Fecha = $Ano."-".$Mes."-".$Dia;
	$FechaP = $CmbAnoP."-".$CmbMesP."-".$CmbDiasP;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.ingreso_platino_paladio ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and num_proceso = '".$NumProceso."'";
	//		echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.ingreso_platino_paladio set";
				$Actualizar.= " recepcion_ag_cl = '".str_replace(",",".",$Recepcion)."', ";
				$Actualizar.= " cant_platino = '".str_replace(",",".",$Platino)."', ";
				$Actualizar.= " oro = '".str_replace(",",".",$Oro)."', ";
				$Actualizar.= " paladio = '".str_replace(",",".",$Paladio)."', ";
				$Actualizar.= " total_recuperado = '".str_replace(",",".",$TotalRecuperado)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";				
				$Actualizar.= " and num_proceso = '".$NumProceso."'";
	//			echo $Actualizar."<br>"; 
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.ingreso_platino_paladio ";
				$Insertar.= "(rut,fecha,num_proceso,cant_platino,oro,recepcion_ag_cl,paladio,total_recuperado) ";
				$Insertar.= "values('".$Rut."','".$Fecha."','".str_replace(",",".",$NumProceso)."','".str_replace(",",".",$Platino)."', ";
				$Insertar.=" '".str_replace(",",".",$Oro)."','".str_replace(",",".",$Recepcion)."','".str_replace(",",".",$Paladio)."','".str_replace(",",".",$TotalRecuperado)."')";
	//			echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
		header("location:pmn_pladio_platino.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumProceso=".$NumProceso."&Platino=".$Platino."&Oro=".$Oro."&Paladio=".$Paladio."&Recepcion=".$Recepcion."&TotalRecuperado=".$TotalRecuperado);
			break;
		case "G2": //GRABAR
		
			$Consulta = "select * from pmn_web.detalle_ingreso_platino_paladio ";
			$Consulta= $Consulta." where fecha = '".$Fecha."'";
			$Consulta= $Consulta." and num_proceso = '".$NumProceso."'";
			$Consulta= $Consulta." and num_electrolisis_plata = '".$NumElectrolisis."' ";
//			echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.detalle_ingreso_platino_paladio set ";
				$Actualizar.= " fecha_proceso = '".$FechaP."'  ";
				$Actualizar.= " where fecha = '".$Fecha."' ";				
				$Actualizar.= " and num_proceso = '".$NumProceso."'";
				$Actualizar.= " and num_electrolisis_plata = '".$NumElectrolisis."' ";		
//				echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.detalle_ingreso_platino_paladio ";
				$Insertar.= "(rut, fecha, num_proceso,num_electrolisis_plata,fecha_proceso) ";
				$Insertar.= "values('".$Rut."','".$Fecha."','".$NumProceso."', ";
				$Insertar.= " '".$NumElectrolisis."','".$FechaP."')";
//				echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_pladio_platino.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumProceso=".$NumProceso."&Platino=".$Platino."&Oro=".$Oro."&Paladio=".$Paladio."&Recepcion=".$Recepcion."&TotalRecuperado=".$TotalRecuperado);
			break;
		case "M":
			if (count($ChkProceso)>0)
			{
				
				while (list($i,$p) = each($ChkProceso))
				{
					header("location:pmn_pladio_platino.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumProceso=".$p."&NumElectrolisis=".$ChkElectrolisis[$i]."&CmbDiasP=".$ChKDia[$i]."&CmbMesP=".$ChKMes[$i]."&CmbAnoP=".$ChKAno[$i]);
				}
			}
			else
			{
				header("location:pmn_pladio_platino.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E"://Elimna cabecera y detalle
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.ingreso_platino_paladio ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$Eliminar.= " and num_proceso = '".$NumProceso."'";					
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from  pmn_web.detalle_ingreso_platino_paladio ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			$Eliminar.= " and num_proceso = '".$NumProceso."'";					
			mysqli_query($link, $Eliminar);
			header("location:pmn_pladio_platino.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E2":
			if (count($ChkProceso)>0)
			{
				while (list($i,$p) = each($ChkProceso))
				{
					// ELIMINA DETALLE
					$Eliminar = "delete from  pmn_web.detalle_ingreso_platino_paladio ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and num_proceso = '".$p."'";					
					$Eliminar.= " and num_electrolisis_plata = '".$ChkElectrolisis[$i]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_pladio_platino.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumProceso=".$NumProceso."&Platino=".$Platino."&Oro=".$Oro."&Paladio=".$Paladio."&Recepcion=".$Recepcion."&TotalRecuperado=".$TotalRecuperado);
			break;
		case "C": //CANCELAR
			header("location:pmn_pladio_platino.php");
			break;
	}
?>