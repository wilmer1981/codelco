<?php
	include("../principal/conectar_pmn_web.php");
	$Rut =$CookieRut;
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G": //GRABAR
			$Consulta = "select * from pmn_web.carga_fusion_barro_aurifero ";
			$Consulta.= " where fecha = '".$Fecha."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.carga_fusion_barro_aurifero set";
				$Actualizar.= " operador = '".$Operador."' ";
				$Actualizar.= " where fecha = '".$Fecha."'";				
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.carga_fusion_barro_aurifero ";
				$Insertar.= "(rut, fecha,operador) ";
				$Insertar.= "values('".$Rut."','".$Fecha."','".$Operador."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_carga_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Operador=".$Operador);
			break;
		case "G2": //GRABAR
			$Consulta = "select * from pmn_web.detalle_carga_fusion_barro_aurifero ";
			$Consulta= $Consulta." where fecha = '".$Fecha."'";
			$Consulta= $Consulta." and producto = '".$CmbProductos."' and subproducto = '".$CmbSubProducto."' ";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Row = mysqli_fetch_array($Respuesta))
			{
				//Actualizar
				$Actualizar = "UPDATE pmn_web.detalle_carga_fusion_barro_aurifero set ";
				$Actualizar.= " peso = '".str_replace(",",".",$Pesos)."', ";
				$Actualizar.= " unidades = '".str_replace(",",".",$Unidades)."'  ";
				$Actualizar.= " where fecha = '".$Fecha."' ";				
				$Actualizar.= " and producto = '".$CmbProductos."' and subproducto = '".$CmbSubProducto."' ";		
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				//Insertar
				$Insertar = "INSERT INTO pmn_web.detalle_carga_fusion_barro_aurifero ";
				$Insertar.= "(rut, fecha,producto,subproducto,peso,unidades) ";
				$Insertar.= "values('".$Rut."','".$Fecha."','".$CmbProductos."','".$CmbSubProducto."','".str_replace(",",".",$Pesos)."','".str_replace(",",".",$Unidades)."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
			header("location:pmn_carga_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Operador=".$Operador);
			break;
		case "M":
			if (count($ChkFecha)>0)
			{
				while (list($i,$p) = each($ChkFecha))
				{
					//echo "SubP".$ChkSubProducto[$i]."<br>"; 
					header("location:pmn_carga_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&CmbProductos=".$ChkProducto[$i]."&CmbSubProducto=".$ChkSubProducto[$i]."&Pesos=".$ChkPesos[$i]."&Unidades=".$ChkUnidades[$i]);
				}
			}
			else
			{
				header("location:pmn_carga_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			}
			break;
		case "E":
			// ELIMINA CABECERA
			$Eliminar = "delete from pmn_web.carga_fusion_barro_aurifero ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			mysqli_query($link, $Eliminar);
			// ELIMINA DETALLE
			$Eliminar = "delete from  pmn_web.detalle_carga_fusion_barro_aurifero ";
			$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
			mysqli_query($link, $Eliminar);
			header("location:pmn_carga_fusion_barro_aurifero.php");
			break;
		case "E2":
			if (count($ChkFecha)>0)
			{
				while (list($i,$p) = each($ChkFecha))
				{
					// ELIMINA DETALLE
					$Eliminar = "delete from  pmn_web.detalle_carga_fusion_barro_aurifero ";
					$Eliminar.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
					$Eliminar.= " and producto = '".$ChkProducto[$i]."'";
					$Eliminar.= " and subproducto = '".$ChkSubProducto[$i]."'";
					//echo $Eliminar."<br>";
					mysqli_query($link, $Eliminar);
				}
			}

			header("location:pmn_carga_fusion_barro_aurifero.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
			break;
		case "C": //CANCELAR
			header("location:pmn_carga_fusion_barro_aurifero.php");
			break;
	}
?>