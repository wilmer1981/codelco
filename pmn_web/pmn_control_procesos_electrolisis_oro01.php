<?php
include("../principal/conectar_pmn_web.php");
	$Fecha = $Ano."-".$Mes."-".$Dia;
	switch ($Proceso)
	{
		case "G":	
			$Consulta=" select * from pmn_web.control_procesos_electrolisis_oro ";
			$Consulta.=" where fecha = '".$Fecha."' and num_electrolisis = '".$TxtNumElectrolisis."' ";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Actualizar=" UPDATE pmn_web.control_procesos_electrolisis_oro set ";
				$Actualizar.=" observaciones ='".$TxtObs."' , ";
				$Actualizar.=" stock_ini_cloruro = '".str_replace(",",".",$TxtCloroStockI)."', ";
				$Actualizar.=" produccion_cloruro = '".str_replace(",",".",$TxtCloroProduccion)."', ";
				$Actualizar.=" stock_final_cloruro = '".str_replace(",",".",$TxtCloroStockF)."', ";
				$Actualizar.=" catodos_secos = '".str_replace(",",".",$TxtCatodosS)."', ";
				$Actualizar.=" restos_anodos_secos = '".str_replace(",",".",$TxtRestosAnodosS)."', ";
				$Actualizar.=" peso = '".str_replace(",",".",$TxtPeso)."' ,";
				$Actualizar.=" cantidad_anodos = '".str_replace(",",".",$TxtCant)."' ";
				$Actualizar.=" where fecha = '".$Fecha."' and num_electrolisis = '".$TxtNumElectrolisis."' ";
				mysqli_query($link, $Actualizar);			
			}
			else
			{
				$insertar="INSERT INTO pmn_web.control_procesos_electrolisis_oro ";
				$insertar.="(fecha,num_electrolisis,observaciones,stock_ini_cloruro, ";
				$insertar.=" produccion_cloruro,stock_final_cloruro ";
				$insertar.=" ,catodos_secos,restos_anodos_secos,peso,cantidad_anodos) ";
				$insertar.=" values ( '".$Fecha."','".$TxtNumElectrolisis."','".$TxtObs."', ";
				$insertar.=" '".str_replace(",",".",$TxtCloroStockI)."','".str_replace(",",".",$TxtCloroProduccion)."','".str_replace(",",".",$TxtCloroStockF)."' ";
				$insertar.=" ,'".str_replace(",",".",$TxtCatodosS)."', ";
				$insertar.=" '".str_replace(",",".",$TxtRestosAnodosS)."','".str_replace(",",".",$TxtPeso)."','".str_replace(",",".",$TxtCant)."')";
				mysqli_query($link, $insertar);
			}
			header("location:pmn_control_procesos_electrolisis_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&TxtNumElectrolisis=".$TxtNumElectrolisis);
		break;
		case "M":
			$Actualizar=" UPDATE pmn_web.control_procesos_electrolisis_oro set ";
			$Actualizar.=" observaciones ='".$TxtObs."' , ";
			$Actualizar.=" stock_ini_cloruro = '".str_replace(",",".",$TxtCloroStockI)."', ";
			$Actualizar.=" produccion_cloruro = '".str_replace(",",".",$TxtCloroProduccion)."', ";
			$Actualizar.=" stock_final_cloruro = '".str_replace(",",".",$TxtCloroStockF)."', ";
			$Actualizar.=" catodos_secos = '".str_replace(",",".",$TxtCatodosS)."', ";
			$Actualizar.=" restos_anodos_secos = '".str_replace(",",".",$TxtRestosAnodosS)."' ";
			$Actualizar.=" peso = '".str_replace(",",".",$TxtPeso)."' ,";
			$Actualizar.=" cantidad_anodos = '".str_replace(",",".",$TxtPeso)."' ";
			$Actualizar.=" where fecha = '".$Fecha."' and num_electrolisis = '".$TxtNumElectrolisis."' ";
			header("location:pmn_control_procesos_electrolisis_oro.php?Mostrar=S&Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&TxtNumElectrolisis=".$TxtNumElectrolisis);
			mysqli_query($link, $Actualizar);
		break;
		case "E":
			$Eliminar="delete from pmn_web.control_procesos_electrolisis_oro ";
			$Eliminar.="where fecha = '".$Fecha."' and num_electrolisis = '".$TxtNumElectrolisis."' ";
			mysqli_query($link, $Eliminar);
			header("location:pmn_control_procesos_electrolisis_oro.php");
		break;		
		case  "N":
			header("location:pmn_control_procesos_electrolisis_oro.php");
		break;
		}
?>	
	