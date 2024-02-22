<?php
include("../principal/conectar_cal_web.php");

switch($Proceso)
{	
	case "EA"://ESTADO ANTERIOR
		//$Valores = substr($Valores,0,strlen($Valores)-2);	
		$Datos = explode("~~",$Valores);
		foreach($Datos as $k => $v)
		{
			$Datos2 = explode("//",$v);
			$SA_Aux = $Datos2[0];
			$Recargo_Aux = $Datos2[1];
			$EstActual_Aux = $Datos2[2];
			$FechaEstActual_Aux = $Datos2[3];
			$EstNuevo_Aux = $Datos2[4];
			//CONSULTA FECHA-HORA ESTADO NUEVO PARA BORRAR TODOS LOS ESTADOS PUESTOS POSTERIORMENTE
			$Consulta = "select * from cal_web.estados_por_solicitud ";
			$Consulta.= " where nro_solicitud='".$SA_Aux."'";
			$Consulta.= " and recargo='".$Recargo_Aux."'";
			$Consulta.= " and cod_estado = '".$EstNuevo_Aux."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$FechaEstNuevo = $Fila["fecha_hora"];
			}
			//ELIMINA ESTADOS POSTERIORES AL QUE SE DESEA ESTAR
			$Eliminar = "delete from cal_web.estados_por_solicitud ";
			$Eliminar.= " where nro_solicitud='".$SA_Aux."'";
			$Eliminar.= " and recargo='".$Recargo_Aux."'";
			$Eliminar.= " and fecha_hora >= '".$FechaEstNuevo."'";
			$Eliminar.= " and cod_estado <> '".$EstNuevo_Aux."'";
			$Eliminar.= " and cod_estado < 50";
			//echo $Eliminar;
			mysqli_query($link, $Eliminar);
			//ACTUALIZA TABLA SOL. ANALISIS CON EL NUEVO ESTADO
			$Actualizar = "UPDATE cal_web.solicitud_analisis set ";
			$Actualizar.= " estado_actual = '".$EstNuevo_Aux."'";
			$Actualizar.= " where nro_solicitud='".$SA_Aux."' ";
			$Actualizar.= " and recargo='".$Recargo_Aux."' ";
			mysqli_query($link, $Actualizar);	
		}
		header("location:cal_historial_solicitudes02.php?SA=".$SA."");
	break;
	case "RE"://RECUPERAR ESTADO DE REGISTRO
		$Consulta="select fecha_hora,nro_solicitud,rut_funcionario,recargo,estado_actual  ";
		$Consulta.=" from cal_web.solicitud_analisis where nro_solicitud='".$SA."'";
		//echo $Consulta."<br>";
		$RespEst=mysqli_query($link, $Consulta);
		if($FilaEst=mysqli_fetch_assoc($RespEst))
		{
			$Insertar = "insert into cal_web.estados_por_solicitud ";
			$Insertar.= "(rut_funcionario, nro_solicitud, recargo, cod_estado, fecha_hora, ult_atencion, rut_proceso) ";
			$Insertar.= " values('".$FilaEst["rut_funcionario"]."','".$SA."','".$FilaEst["recargo"]."','".$FilaEst["estado_actual"]."','".$FilaEst["fecha_hora"]."','N','".$FilaEst["rut_funcionario"]."')";
			//echo $Insertar;
			mysqli_query($link, $Insertar);
		}		
		header("location:cal_historial_solicitudes.php?SA=//".$SA."//&NumIni=".substr($SA,4)."&NumFin=".substr($SA,4)."&Mostrar=I");
	break;
	default:
		$Rut=$CookieRut;
		$RutProceso=$CookieRut;
		$FechaHora = date("Y-m-d G:i");
		for ($j = 0;$j <= strlen($SA); $j++)
		{
			if (substr($SA,$j,2) == "//")
			{	
				$Solicitud = substr($SA,0,$j);
				$Consulta ="select * from cal_web.solicitud_analisis where nro_solicitud = '".$Solicitud."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);		
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					//Especial o no ha sido anulada o eliminada
					if (($Fila["tipo_solicitud"]== 'R' ) && (($Fila["estado_actual"] != '16')&&($Fila["estado_actual"]!= '7') &&($Fila["estado_actual"]!= '15'))) 
					{
						$ObsFinal=$Fila["observacion"].','.$TextObs;
						$Actualizar= "UPDATE solicitud_analisis set estado_actual ='16',observacion = '".$ObsFinal."'  where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud = '".$Solicitud."'";
						//echo $Actualizar."<br>";
						mysqli_query($link, $Actualizar);	
						$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
						$insertar.="values ('".$Fila["rut_funcionario"]."','". $Solicitud."','16','".$FechaHora."','".$RutProceso."')";
						mysqli_query($link, $insertar);
					}
					//Automatica o no ha sido anulada o eliminada
					if (($Fila["tipo_solicitud"] == 'A') && (($Fila["estado_actual"]!= '16')&&($Fila["estado_actual"]!= '15')))
					{
						$ObsFinal = $Fila["observacion"].','.$TextObs;
						$Actualizar= "UPDATE solicitud_analisis set estado_actual ='16', observacion = '".$ObsFinal."'  where rut_funcionario = '".$Fila["rut_funcionario"]."' and nro_solicitud = '".$Solicitud."' and recargo ='".$Fila["recargo"]."' ";
						//echo $Actualizar."<br>";
						mysqli_query($link, $Actualizar);	
						$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,recargo,fecha_hora,rut_proceso)";
						$insertar.="values ('".$Fila["rut_funcionario"]."','". $Solicitud."','16','".$Fila["recargo"]."','".$FechaHora."','".$RutProceso."')";
						mysqli_query($link, $insertar);
					}
				}
				$SA = substr($SA,$j + 2);
				$j = 0;
			}
		}
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmGeneracion.action='cal_historial_solicitudes.php?SA=".$SA02."&Mostrar=I';";
		echo "window.opener.document.FrmGeneracion.submit();";
		echo "window.close();</script>";
	break;
}
	
?>


