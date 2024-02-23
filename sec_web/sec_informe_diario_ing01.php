<?php
	include("../principal/conectar_principal.php");

	$Proceso = $_REQUEST["Proceso"];
	$Ano = $_REQUEST["Ano"];
	$Mes = $_REQUEST["Mes"];
	$Dia = $_REQUEST["Dia"];

	$RecuperadoDiario = $_REQUEST["RecuperadoDiario"];
	$RecuperadoAcumulado = $_REQUEST["RecuperadoAcumulado"];
	$StandardDiario = $_REQUEST["StandardDiario"];
	$StandardAcumulado = $_REQUEST["StandardAcumulado"];

	$FechaInf = $Ano."-".$Mes."-".$Dia;

	if($RecuperadoDiario=='')
		$RecuperadoDiario=0;
	if($RecuperadoAcumulado=='')
		$RecuperadoAcumulado=0;
	if($StandardDiario=='')
		$StandardDiario=0;
	if($StandardAcumulado=='')
		$StandardAcumulado=0;
	switch ($Proceso)
	{
		case "G":
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
					//echo $Insertar."<br>";
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