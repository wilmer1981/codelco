<?php
	include ("../principal/conectar_cal_web.php");

	
	$CmbDias = $_REQUEST["CmbDias"];
	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];
	$CmbDiasT = $_REQUEST["CmbDiasT"];
	$CmbMesT = $_REQUEST["CmbMesT"];
	$CmbAnoT = $_REQUEST["CmbAnoT"];

	if(strlen($CmbMes)==1){$CmbMes="0".$CmbMes;}
	if(strlen($CmbDias)==1){$CmbDias="0".$CmbDias;}
	if(strlen($CmbMesT)==1){$CmbMesT="0".$CmbMesT;}
	if(strlen($CmbDiasT)==1){$CmbDiasT="0".$CmbDiasT;}

	$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
	$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
	$Consulta="select * from cal_web.solicitud_analisis where estado_actual='5' and fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;

	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
		{
			$Consulta="select count(*) as total from leyes_por_solicitud ";
			$Consulta=$Consulta." where rut_funcionario='".$Fila["rut_funcionario"]."'";
			$Consulta=$Consulta." and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"];
			$Consulta=$Consulta." and candado <> '1'";
		}
		else
		{
			$Consulta="select count(*) as total from leyes_por_solicitud ";
			$Consulta=$Consulta." where rut_funcionario='".$Fila["rut_funcionario"]."'";
			$Consulta=$Consulta." and fecha_hora ='".$Fila["fecha_hora"]."' and nro_solicitud=".$Fila["nro_solicitud"]." and recargo='".$Fila["recargo"]."'";
			$Consulta=$Consulta." and candado <> '1'";
		}
		$Respuesta2=mysqli_query($link, $Consulta);
		$Fila2=mysqli_fetch_array($Respuesta2);
		if ($Fila2["total"]==0)
		{
			if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
			{
				$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='6' where nro_solicitud ='".$Fila["nro_solicitud"]."' ";
				$Actualizar.="  and fecha_hora ='".$Fila["fecha_hora"]."' and rut_funcionario ='".$Fila["rut_funcionario"]."' ";
				$Actualizar.=" and id_muestra ='".$Fila["id_muestra"]."' ";
				mysqli_query($link, $Actualizar);
				$Consulta="select count(*) as cantreg from cal_web.estados_por_solicitud where nro_solicitud='".$Fila["nro_solicitud"]."'  ";
				$Consulta.=" and rut_funcionario='".$Fila["rut_funcionario"]."' and cod_estado='6' ";
				$Respuesta3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3); 
				if ($Fila3["cantreg"]==0)
				{
					$Consulta="select * from cal_web.estados_por_solicitud where nro_solicitud='".$Fila["nro_solicitud"]."'  ";
					$Consulta.=" and rut_funcionario='".$Fila["rut_funcionario"]."' and cod_estado='5'   ";
					$Respuesta3=mysqli_query($link, $Consulta); 
					if ($Fila3=mysqli_fetch_array($Respuesta3))
					{
						$Insertar="insert into cal_web.estados_por_solicitud   ";
						$Insertar.=" (rut_funcionario,fecha_hora,nro_solicitud,cod_estado,ult_atencion,rut_proceso  ) ";
						$Insertar.=" values ('".$Fila["rut_funcionario"]."','".$Fila3["fecha_hora"]."','".$Fila["nro_solicitud"]."', ";
						$Insertar.=" '6','N','".$Fila3["rut_proceso"]."') ";
						mysqli_query($link, $Insertar);
					}
				}			
			}
			else
			{
				$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='6' where nro_solicitud = '".$Fila["nro_solicitud"]."' ";
				$Actualizar.=" and recargo ='".$Fila["recargo"]."' and fecha_hora = '".$Fila["fecha_hora"]."' and rut_funcionario = '".$Fila["rut_funcionario"]."' ";
				$Actualizar.=" and id_muestra = '".$Fila["id_muestra"]."' ";
				mysqli_query($link, $Actualizar);
				$Consulta="select count(*) as cantreg from cal_web.estados_por_solicitud where nro_solicitud='".$Fila["nro_solicitud"]."' and recargo = '".$Fila["recargo"]."' ";
				$Consulta.=" and rut_funcionario= '".$Fila["rut_funcionario"]."' and cod_estado='6'";
				$Respuesta3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3); 
				if ($Fila3["cantreg"]==0)
				{
					$Consulta="select * from cal_web.estados_por_solicitud where nro_solicitud='".$Fila["nro_solicitud"]."' and recargo = '".$Fila["recargo"]."' ";
					$Consulta.=" and rut_funcionario= '".$Fila["rut_funcionario"]."' and cod_estado='5'   ";
					$Respuesta3=mysqli_query($link, $Consulta); 
					if ($Fila3=mysqli_fetch_array($Respuesta3))
					{
						$Insertar="insert into cal_web.estados_por_solicitud   ";
						$Insertar.="(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_estado,ult_atencion,rut_proceso  ) ";
						$Insertar.=" values ('".$Fila["rut_funcionario"]."','".$Fila3["fecha_hora"]."','".$Fila["nro_solicitud"]."','".$Fila["recargo"]."',";
						$Insertar.=" '6','N','".$Fila3["rut_proceso"]."') ";
						mysqli_query($link, $Insertar);
					}
				}	
			}
			$i++;
		}	
	}
	header("location:actualizar_candados.php?TxtCant=".$i);
?>
