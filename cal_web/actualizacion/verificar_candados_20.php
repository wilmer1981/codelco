<?php
	include ("../Principal/conectar_cal_web.php");
	
	
	$Consulta="select * from cal_web.solicitud_analisis where estado_actual='5' and fecha_hora between '2003-10-10 00:00:01' and '2003-10-20 23:59:59'";
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
		if ($Fila2[total]==0)
		{
			/*echo "NRO.SA:".$Fila["nro_solicitud"];
			echo " NRO.RECARGO:".$Fila["recargo"];
			echo " NRO.ID_MUESTRA:".$Fila["id_muestra"];*/
			if ((is_null($Fila["recargo"]))||($Fila["recargo"]==''))
			{
				$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='6' where nro_solicitud ='".$Fila["nro_solicitud"]."' ";
				$Actualizar.="  and fecha_hora ='".$Fila["fecha_hora"]."' and rut_funcionario ='".$Fila["rut_funcionario"]."' ";
				$Actualizar.=" and id_muestra ='".$Fila["id_muestra"]."' ";
				mysqli_query($link, $Actualizar);
				$Consulta="select * from cal_web.estados_por_solicitud where nro_solicitud='".$Fila["nro_solicitud"]."'  ";
				$Consulta.=" and rut_funcionario='".$Fila["rut_funcionario"]."' and cod_estado='5'   ";
				$Respuesta3=mysqli_query($link, $Consulta); 
				if ($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$Insertar="insert into cal_web.estados_por_solicitud   ";
					$Insertar.=" (rut_funcionario,fecha_hora,nro_solicitud,cod_estado,ult_atencion,rut_proceso  ) ";
					$Insertar.=" values ('".$Fila["rut_funcionario"]."','".$Fila3["fecha_hora"]."','".$Fila["nro_solicitud"]."', ";
					$Insertar.=" '6','N','".$Fila3[rut_proceso]."') ";
					mysqli_query($link, $Insertar);
				}
			
			}
			else
			{
				$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='6' where nro_solicitud = '".$Fila["nro_solicitud"]."' ";
				$Actualizar.=" and recargo ='".$Fila["recargo"]."' and fecha_hora = '".$Fila["fecha_hora"]."' and rut_funcionario = '".$Fila["rut_funcionario"]."' ";
				$Actualizar.=" and id_muestra = '".$Fila["id_muestra"]."' ";
				mysqli_query($link, $Actualizar);
				$Consulta="select * from cal_web.estados_por_solicitud where nro_solicitud='".$Fila["nro_solicitud"]."' and recargo = '".$Fila["recargo"]."' ";
				$Consulta.=" and rut_funcionario= '".$Fila["rut_funcionario"]."' and cod_estado='5'   ";
				$Respuesta3=mysqli_query($link, $Consulta); 
				if ($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$Insertar="insert into cal_web.estados_por_solicitud   ";
					$Insertar.="(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_estado,ult_atencion,rut_proceso  ) ";
					$Insertar.=" values ('".$Fila["rut_funcionario"]."','".$Fila3["fecha_hora"]."','".$Fila["nro_solicitud"]."','".$Fila["recargo"]."',";
					$Insertar.=" '6','N','".$Fila3[rut_proceso]."') ";
					mysqli_query($link, $Insertar);
				}
			}
			$i++;
			echo "<br>";		
		}	
	}
	echo "datos actualizados:".$i;


?>