<?php
	include("../principal/conectar_principal.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date('Y');
	$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date('m');
	$Dia     = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date('d');

	$RecuperadoDiario    = isset($_REQUEST["RecuperadoDiario"])?$_REQUEST["RecuperadoDiario"]:"";
	$RecuperadoAcumulado = isset($_REQUEST["RecuperadoAcumulado"])?$_REQUEST["RecuperadoAcumulado"]:"";
	$StandardDiario      = isset($_REQUEST["StandardDiario"])?$_REQUEST["StandardDiario"]:"";
	$StandardAcumulado   = isset($_REQUEST["StandardAcumulado"])?$_REQUEST["StandardAcumulado"]:"";
	$PaqLavar            = isset($_REQUEST["PaqLavar"])?$_REQUEST["PaqLavar"]:"";
	$PaqPesar            = isset($_REQUEST["PaqPesar"])?$_REQUEST["PaqPesar"]:"";
	$PaqStandard         = isset($_REQUEST["PaqStandard"])?$_REQUEST["PaqStandard"]:"";
	$PaqCatodosGranel    = isset($_REQUEST["PaqCatodosGranel"])?$_REQUEST["PaqCatodosGranel"]:"";
	$PaqStandardGranel   = isset($_REQUEST["PaqStandardGranel"])?$_REQUEST["PaqStandardGranel"]:"";
	$ConfecGranel        = isset($_REQUEST["ConfecGranel"])?$_REQUEST["ConfecGranel"]:"";
	$Observacion         = isset($_REQUEST["Observacion"])?$_REQUEST["Observacion"]:"";
	$EnPreparacion       = isset($_REQUEST["EnPreparacion"])?$_REQUEST["EnPreparacion"]:"";

	if($RecuperadoDiario=='')
		$RecuperadoDiario=0;
	if($RecuperadoAcumulado=='')
		$RecuperadoAcumulado=0;
	if($StandardDiario=='')
		$StandardDiario=0;
	if($StandardAcumulado=='')
		$StandardAcumulado=0;
	if($PaqLavar=='')
		$PaqLavar=0;
	if($PaqPesar=='')
		$PaqPesar=0;
	if($PaqStandard=='')
		$PaqStandard=0;
	if($PaqCatodosGranel=='')
		$PaqCatodosGranel=0;
	if($PaqStandardGranel=='')
		$PaqStandardGranel=0;
	if($ConfecGranel=='')
		$ConfecGranel=0;
	if($EnPreparacion=='')
		$EnPreparacion=0;
	
	switch ($Proceso)
	{
		case "G":
			if(strlen($Dia)==1)
				$Dia = "0".$Dia;
			if(strlen($Mes)==1)
				$Mes = "0".$Mes;
			$FechaInf = $Ano."-".$Mes."-".$Dia;
			$Consulta = "SELECT ifnull(count(*),0) as existe from sec_web.informe_diario ";
			$Consulta.= " where fecha = '".$FechaInf."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				if ($Fila["existe"] == 0)
				{
					$Insertar = "INSERT INTO sec_web.informe_diario (fecha, peso_paquete_lavar, peso_paquete_pesar, peso_paquete_standard, ";
					$Insertar.= "peso_catodos_granel, peso_standard_granel, peso_confec_paquetes, observacion, recuperado_diario, recuperado_acumulado, ";
					$Insertar.= "standard_diario, standard_acumulado,sin_preparar_arrastre) ";
					$Insertar.= " VALUES ('".$FechaInf."', '".str_replace(",",".",$PaqLavar)."', '".str_replace(",",".",$PaqPesar)."', '".str_replace(",",".",$PaqStandard)."',";
					$Insertar.= " '".str_replace(",",".",$PaqCatodosGranel)."','".str_replace(",",".",$PaqStandardGranel)."', ";
					$Insertar.= "'".str_replace(",",".",$ConfecGranel)."', '".$Observacion."', '".str_replace(",",".",$RecuperadoDiario)."', ";
					$Insertar.= "'".str_replace(",",".",$RecuperadoAcumulado)."', '".str_replace(",",".",$StandardDiario)."', '".str_replace(",",".",$StandardAcumulado)."' , '".str_replace(",",".", $EnPreparacion)."')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
				}
				else
				{
					$Actualizar = "UPDATE sec_web.informe_diario SET ";
					$Actualizar.= " peso_paquete_lavar = '".str_replace(",",".",$PaqLavar)."'";
					$Actualizar.= " , peso_paquete_pesar = '".str_replace(",",".",$PaqPesar)."'";
					$Actualizar.= " , peso_paquete_standard = '".str_replace(",",".",$PaqStandard)."'";
					$Actualizar.= " , peso_catodos_granel = '".str_replace(",",".",$PaqCatodosGranel)."'";
					$Actualizar.= " , peso_standard_granel = '".str_replace(",",".",$PaqStandardGranel)."'";
					$Actualizar.= " , peso_confec_paquetes = '".str_replace(",",".",$ConfecGranel)."'";
					$Actualizar.= " , observacion = '".$Observacion."'";
					$Actualizar.= " , recuperado_diario = '".str_replace(",",".",$RecuperadoDiario)."'";
					$Actualizar.= " , recuperado_acumulado = '".str_replace(",",".",$RecuperadoAcumulado)."'";
					$Actualizar.= " , standard_diario = '".str_replace(",",".",$StandardDiario)."'";
					$Actualizar.= " , standard_acumulado = '".str_replace(",",".",$StandardAcumulado)."'";
					$Actualizar.= " , sin_preparar_arrastre = '".str_replace(",",".",$EnPreparacion)."'";
					$Actualizar.= " where fecha = '".$FechaInf."'";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
				}
			}		
			$Consulta = "SELECT * from sec_web.catodo_por_pesar ";
			
			$Resp1 = mysqli_query($link, $Consulta);
			if ($Fila1 = mysqli_fetch_array($Resp1))
			{
				$Actualiza1 = "UPDATE sec_web.catodo_por_pesar SET catodo_por_pesar = '".$EnPreparacion."'";
				mysqli_query($link, $Actualiza1);
			}
			else
			{
				$Insertar = "Insert into sec_web.catodo_por_pesar(catodo_por_pesar) values('".$EnPreparacion."')"; 
				mysqli_query($link, $Insertar);
			}	
		
							
			break;		
		case "E":
			$Eliminar = "delete from sec_web.informe_diario ";
			$Eliminar.= " where fecha = '".$FechaInf."'";
			mysqli_query($link, $Eliminar);			
			break;
	}
	header("location:sec_informe_diario_ing.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano);
?>