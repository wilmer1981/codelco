<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.produccion_electrolisis_oro ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and correlativo = '".$Correlativo."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualiza
				$Actualizar = "UPDATE pmn_web.produccion_electrolisis_oro set";
				$Actualizar.= " resto = '".str_replace(",",".",$Resto)."', ";
				$Actualizar.= " catodo_seco = '".str_replace(",",".",$CatodoSeco)."', ";
			    $Actualizar.= " cloruro_aurico = '".str_replace(",",".",$CloruroAurico)."', ";
				$Actualizar.= " operador = '".$Operador."', ";
				$Actualizar.= " evpf = '".$Evpf."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and correlativo = '".$Correlativo."'";				
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Inserta
				$Insertar = "INSERT INTO pmn_web.produccion_electrolisis_oro ";
				$Insertar.= "(rut, fecha, correlativo, operador, evpf, resto, catodo_seco, cloruro_aurico) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Correlativo."','".$Operador."','".$Evpf."','".str_replace(",",".",$Resto)."',";
				$Insertar.= "'".str_replace(",",".",$CatodoSeco)."','".str_replace(",",".",$CloruroAurico)."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_produccion_elect_oro.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "M":
			if (count($ChkCorrelativo)>0)
			{
				while (list($i,$p) = each($ChkCorrelativo))
				{
					header("location:pmn_produccion_elect_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Correlativo=".$ChkCorrelativo[$i]);
				}
			}
			else
			{
				header("location:pmn_produccion_elect_oro.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E":
			if (count($ChkCorrelativo)>0)
			{
				while (list($i,$p) = each($ChkCorrelativo))
				{
					$Eliminar = "delete from pmn_web.produccion_electrolisis_oro ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and correlativo = '".$p."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_produccion_elect_oro.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "S":			
			if (count($checkbox)>0)
			{
				$valores = explode("~",$parametros);
		        while(list($c,$v) = each($valores))
		      	{					
				    $Eliminar = "delete from pmn_web.produccion_electrolisis_oro ";
					$Eliminar.= " where fecha = '".$v."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_produccion_elect_oro03.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;			
		case "C": //CANCELAR
			header("location:pmn_produccion_elect_oro.php");
			break;
	}
?>