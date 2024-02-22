<?php 
include("../principal/conectar_principal.php");
$Fecha = date('Y-m-d H:i');
for ($f=0;$f<=strlen($Valores);$f++)
{
	if (substr($Valores,$f,2)=="**")
	{
		$SARutLeyesRecargoValorUnidad=substr($Valores,0,$f);
		for ($i=0;$i<=strlen($SARutLeyesRecargoValorUnidad);$i++)
		{
			if (substr($SARutLeyesRecargoValorUnidad,$i,2)=="~~")
			{
				$SA = substr($SARutLeyesRecargoValorUnidad,0,$i);
				$RutLeyesRecargoValorUnidad = substr($SARutLeyesRecargoValorUnidad,$i+2);
				for ($j=0;$j<=strlen($RutLeyesRecargoValorUnidad);$j++)
				{
					if (substr($RutLeyesRecargoValorUnidad,$j,2)=="||")
					{
						$Rut=substr($RutLeyesRecargoValorUnidad,0,$j);
						$LeyesRecargoValorUnidad=substr($RutLeyesRecargoValorUnidad,$j+2);
						for ($k=0;$k<=strlen($LeyesRecargoValorUnidad);$k++)
						{
							if (substr($LeyesRecargoValorUnidad,$k,2)=="")
							{
								$Leyes=substr($LeyesRecargoValorUnidad,0,$k);
								$RecargoValorUnidad=substr($LeyesRecargoValorUnidad,$k+2);
								for ($l=0;$l<=strlen($RecargoValorUnidad);$l++)
								{
									if (substr($RecargoValorUnidad,$l,2)=="//")
									{
										$Recargo=substr($RecargoValorUnidad,0,$l);
										$ValorUnidad=substr($RecargoValorUnidad,$l+2);
										for ($m=0;$m<=strlen($ValorUnidad);$m++)
										{
											if (substr($ValorUnidad,$m,2)=="!!")
											{
												$Valor=substr($ValorUnidad,0,$m);
												if ($Valor<>'')
												{
													$Valor=str_replace(",",".",$Valor);
												}
												else
												{
													$Valor="NULL";
												}												
												$Unidad=substr($ValorUnidad,$m+2);
												if ($Recargo =='N')
												{
													$Consulta = "select  * from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado='5'";
													$Respuesta=mysqli_query($link, $Consulta);
													if(!$Fila=mysqli_fetch_array($Respuesta))
													{
														$Insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora) values ('";
														$Insertar=$Insertar.$Rut."',";
														$Insertar=$Insertar.$SA.",";
														$Insertar=$Insertar."'5','";
														$Insertar=$Insertar.$Fecha."')";
														mysqli_query($link, $Insertar);
														$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='5' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."'";
														mysqli_query($link, $Actualizar);
													}
													$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
													$Respuesta=mysqli_query($link, $Consulta);
													if($Fila=mysqli_fetch_array($Respuesta))
													{
														if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
														{
															$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
															mysqli_query($link, $Actualizar);
															$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,valor,cod_unidad) values(";
															$Insertar=$Insertar.$SA.",'";
															$Insertar=$Insertar.$Fecha."','";
															$Insertar=$Insertar.$Rut."','";
															$Insertar=$Insertar.$Leyes."',";
															$Insertar=$Insertar.$Valor.",'";
															$Insertar=$Insertar.$Unidad."')";
															mysqli_query($link, $Insertar);
															//echo $Insertar."<br>";	
														}
													}	
												}
												else
												{
													$Consulta = "select  * from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado='5'";
													$Respuesta=mysqli_query($link, $Consulta);
													if(!$Fila=mysqli_fetch_array($Respuesta))
													{
														$Insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora) values ('";
														$Insertar=$Insertar.$Rut."',";
														$Insertar=$Insertar.$SA.",'";
														$Insertar=$Insertar.$Recargo."',";
														$Insertar=$Insertar."'5','";
														$Insertar=$Insertar.$Fecha."')";
														mysqli_query($link, $Insertar);
														$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='5' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."'";
														mysqli_query($link, $Actualizar);
													}
													$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";											
													$Respuesta=mysqli_query($link, $Consulta);	
													if($Fila=mysqli_fetch_array($Respuesta))
													{
														if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
														{
															$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
															mysqli_query($link, $Actualizar);
															$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,valor,cod_unidad) values(";
															$Insertar=$Insertar.$SA.",'";
															$Insertar=$Insertar.$Fecha."','";
															$Insertar=$Insertar.$Rut."','";
															$Insertar=$Insertar.$Recargo."','";
															$Insertar=$Insertar.$Leyes."',";
															$Insertar=$Insertar.$Valor.",'";
															$Insertar=$Insertar.$Unidad."')";
															mysqli_query($link, $Insertar);
														}
													}		
												}
												/*echo "STR:";
												echo $SA."*";
												echo $Rut."*";
												echo $Leyes."*";
												echo $Recargo."*";
												echo $Valor."<br><BR>";*/
											}	
										}		
									}
								}
							}
						}	
					}
				}	
			}
		}
	$Valores=substr($Valores,$f+2);
	$f=0;
	}	
}
header ("location:cal_ingreso_valor_impurezas.php?ValoresSA=".$ValoresSA);
?>