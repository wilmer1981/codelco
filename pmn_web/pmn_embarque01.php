<?php
	include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.produccion_oro_plata set";
				$Actualizar.= " observacion = '".str_replace("'"," ",$Obs)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_oro_plata ";
				$Insertar.= "(rut, fecha, observacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Obs."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "G1": //GRABAR
			$Consulta = "select * from pmn_web.produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.produccion_oro_plata set";
				$Actualizar.= " observacion = '".str_replace("'"," ",$Obs)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_oro_plata ";
				$Insertar.= "(rut, fecha, observacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Obs."')";
				mysqli_query($link, $Insertar);
			}
			//DETALLE
			$Consulta = "select * from pmn_web.detalle_produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and tipo = 'C'";
			$Consulta.= " and campo01 = '".$NumCaja."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{ 
				//Actualizar DETALLE CAJA
				$Actualizar = "UPDATE pmn_web.detalle_produccion_oro_plata set";
				$Actualizar.= " campo01 = '".str_replace(",",".",$NumCaja)."', ";
				$Actualizar.= " num_electrolisis = '".str_replace(",",".",$NumElectrolisis)."', ";
				$Actualizar.= " campo03 = '".str_replace(",",".",$PesoCaja)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and tipo = 'C'";
				$Actualizar.= " and campo01 = '".$NumCaja."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar Detalle CAJA
				$Insertar = "INSERT INTO pmn_web.detalle_produccion_oro_plata ";
				$Insertar.= "(fecha, tipo, campo01, num_electrolisis, campo03) ";
				$Insertar.= "values('".$Fecha."','C','".$NumCaja."','".$NumElectrolisis."','".$PesoCaja."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.produccion_oro_plata set";
				$Actualizar.= " observacion = '".str_replace("'"," ",$Obs)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_oro_plata ";
				$Insertar.= "(rut, fecha, observacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Obs."')";
				mysqli_query($link, $Insertar);
			}
			//DETALLE
			$Consulta = "select * from pmn_web.detalle_produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and tipo = 'B'";
			$Consulta.= " and campo01 = '".$NumBarra."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{ 
				//Actualizar DETALLE BARRA
				$Actualizar = "UPDATE pmn_web.detalle_produccion_oro_plata set";
				$Actualizar.= " campo01 = '".str_replace(",",".",$NumBarra)."', ";
				$Actualizar.= " campo02 = '".str_replace(",",".",$PesoNetoBarra)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and tipo = 'B'";
				$Actualizar.= " and campo01 = '".$NumBarra."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar Detalle BARRA
				$Insertar = "INSERT INTO pmn_web.detalle_produccion_oro_plata ";
				$Insertar.= "(fecha, tipo, campo01, campo02) ";
				$Insertar.= "values('".$Fecha."','B','".$NumBarra."','".$PesoNetoBarra."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "G3": //GRABAR
			$Consulta = "select * from pmn_web.produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.barro_aurifero_crudo set";
				$Actualizar.= " observacion = '".str_replace("'"," ",$Obs)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_oro_plata ";
				$Insertar.= "(rut, fecha, observacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Obs."')";
				mysqli_query($link, $Insertar);
			}
			//DETALLE
			$Consulta = "select * from pmn_web.detalle_produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and tipo = 'BE'";
			$Consulta.= " and campo01 = '".$NumBarraEsp."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{ 
				//Actualizar DETALLE BARRA ESPECIAL
				$Actualizar = "UPDATE pmn_web.detalle_produccion_oro_plata set";
				$Actualizar.= " campo01 = '".str_replace(",",".",$NumBarraEsp)."', ";
				$Actualizar.= " campo02 = '".str_replace(",",".",$PesoNetoBarraEsp)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and tipo = 'BE'";
				$Actualizar.= " and campo01 = '".$NumBarraEsp."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar Detalle BARRA ESPECIAL
				$Insertar = "INSERT INTO pmn_web.detalle_produccion_oro_plata ";
				$Insertar.= "(fecha, tipo, campo01, campo02) ";
				$Insertar.= "values('".$Fecha."','BE','".$NumBarraEsp."','".$PesoNetoBarraEsp."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "G4": //GRABAR
			$Consulta = "select * from pmn_web.produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.barro_aurifero_crudo set";
				$Actualizar.= " observacion = '".str_replace("'"," ",$Obs)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.produccion_oro_plata ";
				$Insertar.= "(rut, fecha, observacion) ";
				$Insertar.= "values('".$CookieRut."','".$Fecha."','".$Obs."')";
				mysqli_query($link, $Insertar);
			}
			//DETALLE
			$Consulta = "select * from pmn_web.detalle_produccion_oro_plata ";
			$Consulta.= " where fecha = '".$Fecha."'";
			$Consulta.= " and tipo = 'CT'";
			$Consulta.= " and campo01 = '".$NumCatodo."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{ 
				//Actualizar DETALLE CATODO
				$Actualizar = "UPDATE pmn_web.detalle_produccion_oro_plata set";
				$Actualizar.= " campo01 = '".str_replace(",",".",$NumCatodo)."', ";
				$Actualizar.= " campo02 = '".str_replace(",",".",$PesoNetoCatodo)."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";
				$Actualizar.= " and tipo = 'CT'";
				$Actualizar.= " and campo01 = '".$NumCatodo."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar Detalle CATODO
				$Insertar = "INSERT INTO pmn_web.detalle_produccion_oro_plata ";
				$Insertar.= "(fecha, tipo, campo01, campo02) ";
				$Insertar.= "values('".$Fecha."','CT','".$NumCatodo."','".$PesoNetoCatodo."')";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "M1":
			if (count($ChkNumCaja)>0)
			{
				while (list($i,$p) = each($ChkNumCaja))
				{
					header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumCaja=".$p."&NumElectrolisis=".$ChkNumElectrolisis[$i]."&PesoCaja=".$ChkPesoCaja[$i]);
				}
			}
			else
			{
				header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "M2":
			if (count($ChkNumBarra)>0)
			{
				while (list($i,$p) = each($ChkNumBarra))
				{
					header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumBarra=".$p."&PesoNetoBarra=".$ChkPesoNetoBarra[$i]);
				}
			}
			else
			{
				header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "M3":
			if (count($ChkNumBarraEsp)>0)
			{
				while (list($i,$p) = each($ChkNumBarraEsp))
				{
					header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumBarraEsp=".$p."&PesoNetoBarraEsp=".$ChkPesoNetoBarraEsp[$i]);
				}
			}
			else
			{
				header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "M4":
			if (count($ChkNumCatodo)>0)
			{
				while (list($i,$p) = each($ChkNumCatodo))
				{
					header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&NumCatodo=".$p."&PesoNetoCatodo=".$ChkPesoNetoCatodo[$i]);
				}
			}
			else
			{
				header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E":
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.produccion_oro_plata ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";					
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from pmn_web.detalle_produccion_oro_plata ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";					
			mysqli_query($link, $Eliminar);
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E1":
			if (count($ChkNumCaja)>0)
			{
				while (list($i,$p) = each($ChkNumCaja))
				{
					$Eliminar = "delete from pmn_web.detalle_produccion_oro_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and tipo = 'C'";
					$Eliminar.= " and campo01 = '".$p."'";
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E2":
			if (count($ChkNumBarra)>0)
			{
				while (list($i,$p) = each($ChkNumBarra))
				{
					$Eliminar = "delete from pmn_web.detalle_produccion_oro_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and tipo = 'B'";
					$Eliminar.= " and campo01 = '".$p."'";					
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E3":
			if (count($ChkNumBarraEsp)>0)
			{
				while (list($i,$p) = each($ChkNumBarraEsp))
				{
					$Eliminar = "delete from pmn_web.detalle_produccion_oro_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and tipo = 'BE'";
					$Eliminar.= " and campo01 = '".$p."'";					
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "E4":
			if (count($ChkNumCatodo)>0)
			{
				while (list($i,$p) = each($ChkNumCatodo))
				{
					$Eliminar = "delete from pmn_web.detalle_produccion_oro_plata ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and tipo = 'CT'";
					$Eliminar.= " and campo01 = '".$p."'";					
					mysqli_query($link, $Eliminar);
				}
			}
			header("location:pmn_embarque.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "C": //CANCELAR
			header("location:pmn_embarque.php");
			break;
	}
?>