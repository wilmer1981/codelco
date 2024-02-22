<?php
	$CodigoDeSistema=1;
include("../principal/conectar_cal_web.php");
$CookieRut=$_COOKIE["CookieRut"];
$RutProceso =$CookieRut;

$Opcion   = $_REQUEST["Opcion"];
$Muestras = $_REQUEST["Muestras"];
$ValorSA  = $_REQUEST["ValorSA"];
$FechaAT  = $_REQUEST["FechaAT"];
$TSaRutFecha  = $_REQUEST["TSaRutFecha"];

switch ($Opcion)
{
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
								if ($Recargo == 'N')
								{
									$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
									$insertar.="values ('".$Rut."','". $Sa."','7','".$FechaHora."','".$RutProceso."')";
									mysqli_query($link, $insertar);
									$Actualizar= "UPDATE  solicitud_analisis set estado_actual ='7' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$Sa."'";
									mysqli_query($link, $Actualizar);
		
								}
								//if ($Recargo !='0') 
								//{
									$Consulta ="select * from cal_web.solicitud_analisis where (nro_solicitud = '".$Sa."' ";
									$Consulta=$Consulta." and rut_funcionario = '".$Rut."' and recargo = '".$Recargo."') ";
									//echo $Consulta."<br>";
									$Respuesta=mysqli_query($link, $Consulta);
									$Fila=mysqli_fetch_array($Respuesta);   
									//Elimina en solictud de analisis
									$Eliminar="delete from cal_web.solicitud_analisis where  ";
									$Eliminar.=" nro_solicitud = '".$Sa."' and rut_funcionario and recargo = '".$Recargo."' ";
									$Eliminar.= " and id_muestra = '".$Fila["id_muestra"]."' and fecha_hora = '".$Fila["fecha_hora"]."'";
									mysqli_query($link, $Eliminar);
									//Elimina en estados por solicitud
									$Eliminar = "delete from cal_web.estados_por_solicitud where nro_solicitud = '".$Sa."' and recargo = '".$Recargo."' ";		
									mysqli_query($link, $Eliminar); 
									//Elimina en leyes por solicitud
									$Eliminar = "delete from cal_web.leyes_por_solicitud where nro_solicitud = '".$Sa."' and rut_funcionario = '".$Rut."' ";	
									$Eliminar.= " and recargo = '".$Recargo."'";// and fecha_hora = '".$Fila["fecha_hora"]."' 
									mysqli_query($link, $Eliminar);
								//}
							}
						}
					}	
				}
				$TSaRutFecha = substr($TSaRutFecha,$j + 2);
				$j = 0;
			}
		}
		header("location:cal_adm_solicitud_muestrera.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&TxtFechaIni=".$TxtFechaIni."&TxtFechaFin=".$TxtFechaFin);
		//header("location:cal_adm_solicitud_muestreo.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbAnoT=".$CmbAnoT."&CmbMesT=".$CmbMesT."&CmbDiasT=".$CmbDiasT);
		break;
	case "S":	
		header("location:../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=10");
		break;
	case "A":
		for ($j = 0;$j <= strlen($ValorSA); $j++)
		{
			if (substr($ValorSA,$j,2) == "//")
			{
				$RutSARecargo = substr($ValorSA,0,$j);
				for ($x=0;$x<=strlen($RutSARecargo);$x++)
				{
					if (substr($RutSARecargo,$x,2) == "~~")
					{
						$SA = substr($RutSARecargo,0,$x);			
						$RutRecargo=substr($RutSARecargo,$x+2,strlen($RutSARecargo));
						for ($y=0;$y<=strlen($RutRecargo);$y++)
						{
							if (substr($RutRecargo,$y,2) == "||")
							{
								$Rut = substr($RutRecargo,0,$y);
								$Recargo=substr($RutRecargo,$y+2,strlen($RutRecargo));
								$AuxMuestras = $Muestras;				
								if ($Recargo == 'N')
								{
									//$Eliminar= "delete from  estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and cod_estado > '2'";
									$Eliminar= "DELETE FROM  estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and (cod_estado between '50' and '55')";
									mysqli_query($link, $Eliminar);
									for ($i=0;$i<=strlen($AuxMuestras);$i++)
									{
										if (substr($AuxMuestras,$i,2) == "~~")
										{
											$AnalisisMuestra = substr($AuxMuestras,0,$i);			
											$AuxMuestras=substr($AuxMuestras,$i+2);
											$i= 0;
											//consulta para saber si existe un funcionario en la tabla estados_por_solicitud
											$insertar ="INSERT INTO estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,rut_proceso)";
											$insertar.="values ('".$Rut."','". $SA."','".$AnalisisMuestra."','".$RutProceso."')";
											mysqli_query($link, $insertar);
										}
									}
									$Consulta="SELECT nro_solicitud,recargo  from estados_por_solicitud where (nro_solicitud = '".$SA."' ";
									$Consulta = $Consulta."and rut_funcionario = '".Rut."' and cod_estado = 13)  ";
									$Respuesta= mysqli_query($link, $Consulta);
									if ($Fila=mysqli_fetch_array($Respuesta))	
									{
										//nada
									}	
									else
									{
										//Se inserta el cod_estado = 13 en la tabla estados por solicitud  
										$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
										$insertar.="values ('$Rut','$SA','13','$FechaAT','".$RutProceso."')";
										mysqli_query($link, $insertar);
										//Se actualiza el campo estado_actual asignando un 2 el cual indica que la solicitud esta en atencion muestrera  
										$Actualizar= "UPDATE solicitud_analisis set estado_actual ='13' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
										mysqli_query($link, $Actualizar);
									}
								}
								else
								{
									$Eliminar= "delete from  estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo = '".$Recargo."' and (cod_estado between '50' and '55') ";
									mysqli_query($link, $Eliminar);
									for ($i=0;$i<=strlen($AuxMuestras);$i++)
									{
										if (substr($AuxMuestras,$i,2) == "~~")
										{
											$AnalisisMuestra = substr($AuxMuestras,0,$i);			
											$AuxMuestras=substr($AuxMuestras,$i+2);
											$i= 0;
											//consulta para saber si existe un funcionario en la tabla estados_por_solicitud
											$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,rut_proceso)";
											$insertar.="values ('".$Rut."','". $SA."','$Recargo','".$AnalisisMuestra."','".$RutProceso."')";
											mysqli_query($link, $insertar);
										}
									}
									$Consulta="select nro_solicitud,recargo  from estados_por_solicitud where (nro_solicitud = '".$SA."' ";
									$Consulta = $Consulta."and recargo = '".Recargo."' and rut_funcionario = '".$Rut."' and cod_estado = 13)  ";
									$Respuesta= mysqli_query($link, $Consulta);
									if ($Fila=mysqli_fetch_array($Respuesta))	
									{
									//nada
									}	
									else
									{
										//Se inserta el cod_estado = 13 en la tabla estados por solicitud  
										$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
										$insertar.="values ('$Rut','$SA','$Recargo','13','$FechaAT','".$RutProceso."')";
										mysqli_query($link, $insertar);
										//Se actualiza el campo estado_actual asignando un 2 el cual indica que la solicitud esta en atencion muestrera  
										$Actualizar= "UPDATE solicitud_analisis set estado_actual ='13' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo ='".$Recargo."'";
										mysqli_query($link, $Actualizar);
									}
								}
							}	
						}
					}
				}	
				$ValorSA = substr($ValorSA,$j + 2);
				$j = 0;
			}
	
		}
		//cierra popup de atencion muestreo
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmMuestras.action='cal_adm_solicitud_muestrera.php';";
		//echo "window.opener.document.FrmMuestras.action='cal_adm_solicitud_muestreo.php';";
		echo "window.opener.document.FrmMuestras.submit();";
		echo "window.close();</script>";
	
		break;	
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
									if ($Recargo == 'N')
									{
										$Actualizar= "UPDATE   cal_web.solicitud_analisis set estado_actual ='2' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
									
										mysqli_query($link, $Actualizar);
										//echo $Actualizar;
										$Consulta = "select * from estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and cod_estado = '2'";
										$Respuesta = mysqli_query($link, $Consulta);
										if (!$Fila=mysqli_fetch_array($Respuesta)) 
										{
											$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
											$insertar.="values ('".$Rut."','". $SA."','2','".$FechaHora."','".$RutProceso."')";
											mysqli_query($link, $insertar);
											//echo $insertar;
										}
									}
									else 
									{
										$Actualizar= "UPDATE   cal_web.solicitud_analisis set estado_actual ='2' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo = '".$Recargo."'";
										
										mysqli_query($link, $Actualizar);
										$Consulta = "select * from estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'and recargo = '".$Recargo."' and cod_estado = '2'";
				
										$Respuesta = mysqli_query($link, $Consulta);
										if (!$Fila=mysqli_fetch_array($Respuesta)) 
										{
											$insertar ="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,recargo,rut_proceso)";
											$insertar.="values ('".$Rut."','". $SA."','2','".$FechaHora."','".$Recargo."','".$RutProceso."')";
											mysqli_query($link, $insertar);
										}
									}

								}				
							}	
						}
					}
					$ValoresSA = substr($ValoresSA,$j + 2);
					$j = 0;
				}
			}	
			header("location:cal_adm_solicitud_muestrera.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&TxtFechaIni=".$TxtFechaIni."&TxtFechaFin=".$TxtFechaFin."&Valores_Check=".$ValoresSA);
			//header("location:cal_adm_solicitud_muestreo.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbAnoT=".$CmbAnoT."&CmbMesT=".$CmbMesT."&CmbDiasT=".$CmbDiasT."&Valores_Check=".$ValoresSA);
			break;
			
			case "AS":	
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
										//$AuxMuestras = $Muestras;
										//Consulta que devuelve los estados asociados a una solicitud para la asignacion automatica  
										$Consulta  = "select * from estados_por_solicitud where nro_solicitud = '".$SA."' and (cod_estado between  '50' and '55') order by recargo ";	
										$Respuesta = mysqli_query($link, $Consulta);
										while ($Fila = mysqli_fetch_array($Respuesta))
										{
											//elimina los estados asociados a una solicitud anteriormente 
											$Eliminar= "delete from  estados_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo = '".$Recargo."' and (cod_estado between '50' and '55') ";   
											mysqli_query($link, $Eliminar);
											//Insertar los nuevos estados para para la solicitud
											$insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,rut_proceso)";
											$insertar.="values ('".$Rut."','".$SA."','".$Recargo."','".$Fila["cod_estado"]."','".$RutProceso."')";  										
											mysqli_query($link, $insertar);
											//actualiza el estado_actual 13 atendido por muestrarra 
											$Actualizar= "UPDATE   cal_web.solicitud_analisis set estado_actual ='13' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo = '".$Recargo."'";
											mysqli_query($link, $Actualizar); 		
											//inserta en estado por solicitud el estado 13
											$Consulta="select nro_solicitud,recargo  from estados_por_solicitud where (nro_solicitud = '".$SA."' ";
											$Consulta = $Consulta."and rut_funcionario = '".Rut."' and recargo = '".$Recargo."' and cod_estado = 13)  ";
											$Respuesta2= mysqli_query($link, $Consulta);
											if ($Fila2=mysqli_fetch_array($Respuesta2))	
											{
												//nada
											}
											else
											{
												$insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
												$insertar.="values ('".$Rut."','".$SA."','".$Recargo."','13','".$Fila2["fecha_hora"]."','".$RutProceso."')";  										
												mysqli_query($link, $insertar);
											}
										}
									}				
								}	
							}
						}
					$ValoresSA = substr($ValoresSA,$j + 2);
					$j = 0;
					}
				}
				//header ("location:cal_adm_solicitud_muestreo.php");
				
				header("location:cal_adm_solicitud_muestrera.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&TxtFechaIni=".$TxtFechaIni."&TxtFechaFin=".$TxtFechaFin);
				//header("location:cal_adm_solicitud_muestreo.php?CmbEstado=".$CmbEstado."&LimitIni=".$LimitIni."&LimitFin=".$LimitFin."&CmbAno=".$CmbAno."&CmbMes=".$CmbMes."&CmbDias=".$CmbDias."&CmbAnoT=".$CmbAnoT."&CmbMesT=".$CmbMesT."&CmbDiasT=".$CmbDiasT);
				/*echo "<script languaje='JavaScript'>";
				echo "window.opener.document.FrmMuestras.action='cal_adm_solicitud_muestreo.php';";
				echo "window.opener.document.FrmMuestras.submit();";
				echo "window.close();</script>";*/
				break;			


}

?>
