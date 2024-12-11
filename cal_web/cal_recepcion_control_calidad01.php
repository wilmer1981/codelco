<?php
include ("../Principal/conectar_cal_web.php");	
$CookieRut = $_COOKIE["CookieRut"];
$RutProceso =$CookieRut;
$Opcion = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
$ValoresSA = isset($_REQUEST["ValoresSA"])?$_REQUEST["ValoresSA"]:"";
$FechaHora = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:"";
$TSaRutFecha = isset($_REQUEST["TSaRutFecha"])?$_REQUEST["TSaRutFecha"]:"";

$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date("d");
$CmbEstado = isset($_REQUEST["CmbEstado"])?$_REQUEST["CmbEstado"]:"";
$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
$LimitFin = isset($_REQUEST["LimitFin"])?$_REQUEST["LimitFin"]:"";
$LimitIni = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:"";
$CmbAnoT = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");
$CmbMesT = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
$CmbDiasT = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");

switch ($Opcion)
{
	case "R":
	for ($j = 0;$j <= strlen($ValoresSA); $j++)
	{
		if (substr($ValoresSA,$j,2) == "//")
		{
			$SARutRec = substr($ValoresSA,0,$j);
			for ($x=0;$x<=strlen($SARutRec);$x++)
			{
				if (substr($SARutRec,$x,2) == "~~")
				{
					$SA = substr($SARutRec,0,$x);			
					$RutRec = substr($SARutRec,$x+2,strlen($SARutRec));
					for ($y = 0 ; $y <=strlen($RutRec); $y++ )
					{
						if (substr($RutRec,$y,2)=="||")
						{
							$Rut = substr($RutRec,0,$y);
							$Recargo =substr($RutRec,$y+2,strlen($RutRec));
						}				
					}	
				}
			}
			if ($Recargo == 'N')
			{	
				//Actualiza solictud de analisis con el estado 5  
				$Actualizar= "update   cal_web.solicitud_analisis set estado_actual ='5' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
				mysqli_query($link,$Actualizar);
				//Consulta para saber si ya esta recepcionada
				$Consulta = "select * from estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and cod_estado = '4'";
				$Respuesta = mysqli_query($link,$Consulta);
				if (!$Fila=mysqli_fetch_array($Respuesta)) 
				{
					$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
					$insertar.="values ('".$Rut."','". $SA."','4','".$FechaHora."','".$RutProceso."')";
					mysqli_query($link,$insertar);
				}
				//Consulta para saber si ya esta atendido
				$Consulta = "select * from estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and cod_estado = '5'";
				$Respuesta = mysqli_query($link,$Consulta);
				if (!$Fila=mysqli_fetch_array($Respuesta)) 
				{
					$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
					$insertar.="values ('".$Rut."','". $SA."','5','".$FechaHora."','".$RutProceso."')";
					mysqli_query($link,$insertar);
				}
			}
			else//Solictud Con Recargo 
			{
				//Actualiza Solicitud de analisis con estado 5
				$Actualizar= "update   cal_web.solicitud_analisis set estado_actual ='5' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo = '".$Recargo."'";
				mysqli_query($link,$Actualizar);
				//Para saber si ya ha sido recepcionada
				$Consulta = "select * from estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'and recargo = '".$Recargo."' and cod_estado = '4'";
				$Respuesta = mysqli_query($link,$Consulta);
				if (!$Fila=mysqli_fetch_array($Respuesta)) 
				{
					$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,recargo,rut_proceso)";
					$insertar.="values ('".$Rut."','". $SA."','4','".$FechaHora."','".$Recargo."','".$RutProceso."')";
					mysqli_query($link,$insertar);
				}
				//Para saxber si  fur Atendida 
				$Consulta = "select * from estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'and recargo = '".$Recargo."' and cod_estado = '5'";
				$Respuesta = mysqli_query($link,$Consulta);
				if (!$Fila=mysqli_fetch_array($Respuesta)) 
				{
					$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,recargo,rut_proceso)";
					$insertar.="values ('".$Rut."','". $SA."','5','".$FechaHora."','".$Recargo."','".$RutProceso."')";
					mysqli_query($link,$insertar);
				}
			
			}
		$ValoresSA = substr($ValoresSA,$j + 2);
		$j = 0;
		}
	}
	break;
	case "E":
	for($j= 0;$j <= strlen($TSaRutFecha); $j++)
		{
			if (substr($TSaRutFecha,$j,2) == "||")
			{
				$SaRutFecha =substr($TSaRutFecha,0,$j);	
				for ($x=0;$x<= strlen($SaRutFecha);$x++)
				{
					if (substr($SaRutFecha,$x,2) == "~~")
					{
						$Sa = substr($SaRutFecha,0,$x);
						$RutFecha = substr($SaRutFecha,$x+2,strlen($SaRutFecha));
						for ($y=0;$y<= strlen($RutFecha);$y++)
						{
							if (substr($RutFecha,$y,2) == "//")
							{
							$Rut =substr($RutFecha,0,$y);							
							$Fecha =substr($RutFecha,$y+2,19);
							$Recargo =substr($RutFecha,$y+21,strlen($RutFecha));
							}
						}
						if ($Recargo == 'N')
						{
							$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
							$insertar.="values ('".$Rut."','". $Sa."','7','".$FechaHora."','".$RutProceso."')";
							mysqli_query($link,$insertar);
							$Actualizar= "update  cal_web.solicitud_analisis set estado_actual ='7' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$Sa."'";
							mysqli_query($link,$Actualizar);
						}
						if ($Recargo !='0') 
						{
							$Consulta ="select * from cal_web.solicitud_analisis where (nro_solicitud = '".$Sa."' ";
							$Consulta=$Consulta." and rut_funcionario = '".$Rut."' and recargo = '".$Recargo."') ";
							$Respuesta=mysqli_query($link,$Consulta);
							$Fila=mysqli_fetch_array($Respuesta);   
							//Elimina en solictud de analisis
							$Eliminar="delete from cal_web.solicitud_analisis where  ";
							$Eliminar.=" nro_solicitud = '".$Sa."' and rut_funcionario and recargo = '".$Recargo."' ";
							$Eliminar.= " and id_muestra = '".$Fila["id_muestra"]."' and fecha_hora = '".$Fila["fecha_hora"]."'";
							mysqli_query($link,$Eliminar);
							//Elimina en estados por solicitud
							$Eliminar = "delete from cal_web.estados_por_solicitud where nro_solicitud = '".$Sa."' and recargo = '".$Recargo."' ";		
							mysqli_query($link,$Eliminar); 
							//Elimina en leyes por solicitud
							$Eliminar = "delete from cal_web.leyes_por_solicitud where nro_solicitud = '".$Sa."' and rut_funcionario = '".$Rut."' ";	
							$Eliminar.= " and recargo = '".$Recargo."' and fecha_hora = '".$Fila["fecha_hora"]."' ";
							mysqli_query($link,$Eliminar);
						}
					}	
				}
				$TSaRutFecha = substr($TSaRutFecha,$j + 2);
				$j = 0;
			}
		}
		break;
}	
header("location:../cal_web/cal_recepcion_control_calidad.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbAnoT=".$CmbAnoT."&CmbMesT=".$CmbMesT."&CmbDiasT=".$CmbDiasT."&Mostrar=S");
?>
