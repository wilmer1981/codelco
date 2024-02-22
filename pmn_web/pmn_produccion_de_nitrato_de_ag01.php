<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "O":
			$Consulta = "select * from pmn_web.produccion_nitrato_ag ";
			$Consulta.= " where fecha = '".$Fecha."' ";
			$Consulta.= " and turno = '".$Turno."' ";
			$Consulta.= " and num_electrolisis = '".$TxtElectrolisis."' ";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualiza
				$Actualizar = "UPDATE pmn_web.produccion_nitrato_ag set ";
				$Actualizar.= " stock_disp = '".$TxtStock."'";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and turno = '".$Turno."'";
				$Actualizar.= " and num_electrolisis = '".$TxtElectrolisis."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{	
				$Insertar = "INSERT INTO pmn_web.produccion_nitrato_ag ";
				$Insertar.= "(rut, fecha, turno,num_electrolisis,stock_disp) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$TxtElectrolisis."','".$TxtStock."')";
				mysqli_query($link, $Insertar);
			}			
			header("location:pmn_produccion_de_nitrato_de_ag.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Turno=".$Turno."&TxtElectrolisis=".$TxtElectrolisis."&TxtStock=".$TxtStock."&Mostrar=S");
			break;
		case "G": //GRABAR
				$Consulta = "select * from pmn_web.produccion_nitrato_ag ";
				$Consulta.= " where fecha = '".$Fecha."' ";
				$Consulta.= " and turno = '".$Turno."' ";
				$Consulta.= " and num_electrolisis = '".$TxtElectrolisis."' ";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Row = mysqli_fetch_array($Respuesta))
				{
					//Actualiza
					$Actualizar = "UPDATE pmn_web.produccion_nitrato_ag set ";
					$Actualizar.= " peso_cristales = '".str_replace(",",".",$PesoCristales)."', ";
					$Actualizar.= " volumen_acido_nitrico = '".$VolumenAcido."', ";
					$Actualizar.= " volumen_final = '".$VolumenFinal."' ";
					$Actualizar.= " where fecha = '".$Fecha."'";
					$Actualizar.= " and turno = '".$Turno."'";
					$Actualizar.= " and num_electrolisis = '".$TxtElectrolisis."'";
					$Actualizar.= " and stock_disp = '".$TxtStock."'";
					mysqli_query($link, $Actualizar);
				}
				/*else
					//Inserta
					$Insertar = "INSERT INTO pmn_web.produccion_nitrato_ag ";
					$Insertar.= "(rut, fecha, turno,num_electrolisis,stock_disp,peso_cristales,volumen_acido_nitrico,volumen_final) ";
					$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Turno."','".$TxtElectrolisis."','".$TxtStock."', ";
					$Insertar.=" '".str_replace(",",".",$PesoCristales)."','".$VolumenAcido."','".$VolumenFinal."')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
				}*/
			header("location:pmn_produccion_de_nitrato_de_ag.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Turno=".$Turno."&TxtElectrolisis=".$TxtElectrolisis."&TxtStock=".$TxtStock."&Mostrar=S");
			break;
		case "M":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					header("location:pmn_produccion_de_nitrato_de_ag.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Turno=".$p."&TxtElectrolisis=".$ChkNumElec[$i]."&PesoCristales=".$ChkPeso[$i]."&VolumenAcido=".$ChkVolumenA[$i]."&VolumenFinal=".$ChkVolumenF[$i]."&Mostrar=S");
					//header("location:pmn_carga_lixiviacion_barro_aurifero.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
				}
			}
			else
			{
				header("location:pmn_produccion_de_nitrato_de_ag.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;  
		case "E":
			if (count($ChkTurno)>0)
			{
				while (list($i,$p) = each($ChkTurno))
				{
					$Eliminar = "delete from pmn_web.produccion_nitrato_ag ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and turno = '".$p."'";
					$Eliminar.= " and peso_cristales = '".$ChkPeso[$i]."'";
					$Eliminar.= " and num_electrolisis = '".$ChkNumElec[$i]."'";
					$Eliminar.= " and volumen_acido_nitrico = '".$ChkVolumenA[$i]."'";
					$Eliminar.= " and volumen_final = '".$ChkVolumenF[$i]."'";
					mysqli_query($link, $Eliminar);
				}
			}
			/*Actualiza
			$Actualizar = "UPDATE pmn_web.produccion_nitrato_ag set ";
			$Actualizar.= " peso_cristales = NULL ,";
			$Actualizar.= " volumen_acido_nitrico = NULL, ";
			$Actualizar.= " volumen_final = NULL ";
			$Actualizar.= " where fecha = '".$Fecha."'";
			$Actualizar.= " and turno = '".$Turno."'";
			$Actualizar.= " and num_electrolisis = '".$TxtElectrolisis."'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);*/
			header("location:pmn_produccion_de_nitrato_de_ag.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Turno=".$Turno."&Mostrar=S");
			break;
		case "C": //CANCELAR
			header("location:pmn_produccion_de_nitrato_de_ag.php");
			break;
		case "E2":
			$Eliminar="delete from pmn_web.produccion_nitrato_ag where  fecha = '".$Fecha."'";
			//echo $Eliminar."<br>";
			mysqli_query($link, $Eliminar);		
			header("location:pmn_produccion_de_nitrato_de_ag.php");
		break;
		case "S":
			
			if (count($checkbox)>0)
			{
				$valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		            {
					 $Eliminar = "delete from pmn_web.produccion_nitrato_ag ";
					 $Eliminar.= " where fecha = '"$v"'";
					  mysqli_query($link, $Eliminar);
					 }
			}		  

	} 
?>