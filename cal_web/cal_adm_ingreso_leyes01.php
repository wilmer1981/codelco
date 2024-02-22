<?php
include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];
$RutQ=$CookieRut;
$Fecha = date('Y-m-d H:i');

$Opcion = $_REQUEST["Opcion"];

switch ($Opcion)
{
	case "S":
		header("location:../principal/sistemas_usuario.php?CodSistema=1");
		break;
	case "P"://POR ATENDER
		for ($j = 0;$j <= strlen($ValoresSA); $j++)
		{
			if (substr($ValoresSA,$j,2) == "//")
			{
				$SARutRecargo = substr($ValoresSA,0,$j);
				for ($x=0;$x<=strlen($SARutRecargo);$x++)
				{
					if (substr($SARutRecargo,$x,2) == "~~")
					{
						$SA = substr($SARutRecargo,0,$x);			
						$RutRecargo=substr($SARutRecargo,$x+2,strlen($SARutRecargo));
						for ($y=0;$y<=strlen($RutRecargo);$y++)
						{
							if (substr($RutRecargo,$y,2) == "||")
							{
								$Rut = substr($RutRecargo,0,$y);
								$Recargo=substr($RutRecargo,$y+2,strlen($RutRecargo));
								if ($Recargo =='N')
								{
									$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
									$insertar.="values ('".$Rut."','".$SA."','5','".$Fecha."','".$RutQ."')";
									mysqli_query($link, $insertar);
									$Actualizar= "UPDATE  cal_web.solicitud_analisis set estado_actual ='5' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
									mysqli_query($link, $Actualizar);
								}
								else
								{
									$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
									$insertar.="values ('".$Rut."','".$SA."','".$Recargo."','5','".$Fecha."','".$RutQ."')";
									mysqli_query($link, $insertar);
									$Actualizar= "UPDATE  cal_web.solicitud_analisis set estado_actual ='5' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
									mysqli_query($link, $Actualizar);
								}		
							}	
						}
					}
				}	
				$ValoresSA = substr($ValoresSA,$j + 2);
				$j = 0;
			}
		}			
		header("location:cal_adm_ingreso_leyes.php?CmbEstado=".$CmbEstado."&Mostrar=S&CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbDias=".$CmbDias."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno."&CmbDiasT=".$CmbDiasT."&CmbMesT=".$CmbMesT."&CmbAnoT=".$CmbAnoT);
		break;
		
	/*case "F"://FINALIZAR PROCESO DE LA SOLICITUD
		for ($j = 0;$j <= strlen($ValoresSA); $j++)
		{
			if (substr($ValoresSA,$j,2) == "//")
			{
				$SARutRecargo = substr($ValoresSA,0,$j);
				for ($x=0;$x<=strlen($SARutRecargo);$x++)
				{
					if (substr($SARutRecargo,$x,2) == "~~")
					{
						$SA = substr($SARutRecargo,0,$x);			
						$RutRecargo=substr($SARutRecargo,$x+2,strlen($SARutRecargo));
						for ($y=0;$y<=strlen($RutRecargo);$y++)
						{
							if (substr($RutRecargo,$y,2) == "||")
							{
								$Rut = substr($RutRecargo,0,$y);
								$Recargo=substr($RutRecargo,$y+2,strlen($RutRecargo));
								if ($Recargo =='N')
								{
									$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora)";
									$insertar.="values ('".$Rut."','".$SA."','6','".$Fecha."')";
									mysqli_query($link, $insertar);
									$Actualizar= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
									mysqli_query($link, $Actualizar);
								}
								else
								{
									$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora)";
									$insertar.="values ('".$Rut."','".$SA."','".$Recargo."','6','".$Fecha."')";
									mysqli_query($link, $insertar);
									$Actualizar= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
									mysqli_query($link, $Actualizar);
								}		
							}	
						}
					}
				}	
				$ValoresSA = substr($ValoresSA,$j + 2);
				$j = 0;
			}
		}			
		header("location:cal_adm_ingreso_leyes.php");
		break;*/	
}

?>