<?php 
include("../principal/conectar_principal.php");
$RutQ=$CookieRut;
$Fecha = date('Y-m-d H:i:s');
$Fecha2=date('Y-m-d H:i:s');
$FechaReg=date('Y-m-d H:i:s');
$Entrar = true;
switch ($Opcion)
{
	case "S":
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes_frx.php?Mostrar=S&Valores_Check=".$Valores."';";
		echo "window.opener.document.FrmIngLeyes.submit();";		
		echo "window.close();</script>";
		$Entrar=false;
		break;
	case "G":
		for ($f=0;$f<=strlen($Valores);$f++)
		{
			if (substr($Valores,$f,2)=="**")
			{
				$SARutLeyesRecargoValorUnidadPesoHPesoS=substr($Valores,0,$f);
				for ($i=0;$i<=strlen($SARutLeyesRecargoValorUnidadPesoHPesoS);$i++)
				{
					if (substr($SARutLeyesRecargoValorUnidadPesoHPesoS,$i,2)=="~~")
					{
						$SA = substr($SARutLeyesRecargoValorUnidadPesoHPesoS,0,$i);
						$RutLeyesRecargoValorUnidadPesoHPesoS = substr($SARutLeyesRecargoValorUnidadPesoHPesoS,$i+2);
						for ($j=0;$j<=strlen($RutLeyesRecargoValorUnidadPesoHPesoS);$j++)
						{
							if (substr($RutLeyesRecargoValorUnidadPesoHPesoS,$j,2)=="||")
							{
								$Rut=substr($RutLeyesRecargoValorUnidadPesoHPesoS,0,$j);
								$LeyesRecargoValorUnidadPesoHPesoS=substr($RutLeyesRecargoValorUnidadPesoHPesoS,$j+2);
								for ($k=0;$k<=strlen($LeyesRecargoValorUnidadPesoHPesoS);$k++)
								{
									if (substr($LeyesRecargoValorUnidadPesoHPesoS,$k,2)=="")
									{
										$Leyes=substr($LeyesRecargoValorUnidadPesoHPesoS,0,$k);
										$RecargoValorUnidadPesoHPesoS=substr($LeyesRecargoValorUnidadPesoHPesoS,$k+2);
										for ($l=0;$l<=strlen($RecargoValorUnidadPesoHPesoS);$l++)
										{
											if (substr($RecargoValorUnidadPesoHPesoS,$l,2)=="//")
											{
												$Recargo=substr($RecargoValorUnidadPesoHPesoS,0,$l);
												$ValorUnidadPesoHPesoS=substr($RecargoValorUnidadPesoHPesoS,$l+2);
												for ($m=0;$m<=strlen($ValorUnidadPesoHPesoS);$m++)
												{
													if (substr($ValorUnidadPesoHPesoS,$m,2)=="!!")
													{
														$Valor=substr($ValorUnidadPesoHPesoS,0,$m);
														$UnidadPesoHPesoS=substr($ValorUnidadPesoHPesoS,$m+2);												
														if ($Valor<>'')
														{
															$Valor=str_replace(",",".",$Valor);
														}
														else
														{
															$Valor="NULL";
														}												
														for ($n=0;$n<=strlen($UnidadPesoHPesoS);$n++)
														{
															if (substr($UnidadPesoHPesoS,$n,2)=="??")
															{	
																$Unidad=substr($UnidadPesoHPesoS,0,$n);
																$PesoHPesoS=substr($UnidadPesoHPesoS,$n+2);
																for($p=0;$p<=strlen($PesoHPesoS);$p++)
																{
																	if (substr($PesoHPesoS,$p,2)=="@@")
																	{	
																		$PesoH=substr($PesoHPesoS,0,$p);
																		$PesoS=substr($PesoHPesoS,$p+2);
																		if (($PesoH!='') and ($PesoS!=''))
																		{
																			$Valor=round((($PesoH-$PesoS)*100/$PesoH),6);
																		}
																		else
																		{
																			$PesoH="NULL";
																			$PesoS="NULL";
																			$Valor="NULL";
																		}
																		if ($Recargo =='N')
																		{
																			$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																			$Respuesta=mysqli_query($link, $Consulta);
																			if($Fila=mysqli_fetch_array($Respuesta))
																			{
																				if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
																				{
																					if ($Fila["proceso"]==0)//QUIMICO
																					{
																						$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=3,rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																						mysqli_query($link, $Actualizar);
																					}
																					else
																					{
																						if ((($Fila["proceso"]==1) || ($Fila["proceso"]==2)) and ($Valor=='NULL'))//ANULAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=5,rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																							mysqli_query($link, $Actualizar);
				
																						}
																						if (($Fila["proceso"]=='1')||($Fila["proceso"]=='2')||($Fila["proceso"]=='3')||($Fila["proceso"]=='4')||($Fila["proceso"]=='5'))//MODIFICAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=4,rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																							mysqli_query($link, $Actualizar);
																						}
																					}
																					$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																					$Insertar=$Insertar.$SA.",'";
																					$Insertar=$Insertar.$FechaReg."','";
																					$Insertar=$Insertar.$Rut."','";
																					$Insertar=$Insertar.$Leyes."',";
																					$Insertar=$Insertar.$PesoH.",";
																					$Insertar=$Insertar.$PesoS.",";
																					$Insertar=$Insertar.$Valor.",'";
																					$Insertar=$Insertar.$Unidad."',";
																					$Insertar=$Insertar."'0','".$RutQ."')";	
																					mysqli_query($link, $Insertar);
																				}
																			}
																			if ($PonerCandado=="S")
																			{
																				$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";		
																				mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
																				$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila=mysqli_fetch_array($Respuesta);
																				$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																				$Insertar=$Insertar.$SA.",'";
																				$Insertar=$Insertar.$Fecha."','";
																				$Insertar=$Insertar.$Rut."','";
																				$Insertar=$Insertar.$Leyes."',";
																				$Insertar=$Insertar.$Fila["peso_humedo"].",";
																				$Insertar=$Insertar.$Fila["peso_seco"].",";
																				$Insertar=$Insertar.$Fila["valor"].",'";
																				$Insertar=$Insertar.$Fila["cod_unidad"]."',";
																				$Insertar=$Insertar."'1','".$RutQ."')";
																				mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
																				//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																				$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and candado <> '1')";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila= mysqli_fetch_array($Respuesta);
																				if ($Fila["existe"] == 0)
																				{
																					$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) ";
																					$insertar2.="values ('".$Rut."','".$SA."','32','".$Fecha2."','".$RutQ."')";
																					mysqli_query($link, $insertar2);
																					$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='32' where rut_funcionario = '".$Rut."' and nro_solicitud =".$SA;
																					mysqli_query($link, $Actualizar2);
																				}
																			}	
																		}
																		else
																		{
																			$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";											
																			$Respuesta=mysqli_query($link, $Consulta);	
																			if($Fila=mysqli_fetch_array($Respuesta))
																			{
																				if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
																				{
																					if ($Fila["proceso"]==0)//QUIMICO
																					{
																						$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=3,rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																						mysqli_query($link, $Actualizar);
																					}
																					else
																					{
																						if ((($Fila["proceso"]==1) || ($Fila["proceso"]==2)) and ($Valor=='NULL'))//ANULAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=5,rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																							mysqli_query($link, $Actualizar);
				
																						}
																						if (($Fila["proceso"]=='1')||($Fila["proceso"]=='2')||($Fila["proceso"]=='3')||($Fila["proceso"]=='4')||($Fila["proceso"]=='5'))//MODIFICAR
																						{
																							$Actualizar = "UPDATE cal_web.leyes_por_solicitud set peso_humedo=".$PesoH.",peso_seco=".$PesoS.",valor=".$Valor.",cod_unidad='".$Unidad."',proceso=4,rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																							mysqli_query($link, $Actualizar);
																						}
																					}
																					$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																					$Insertar=$Insertar.$SA.",'";
																					$Insertar=$Insertar.$FechaReg."','";
																					$Insertar=$Insertar.$Rut."','";
																					$Insertar=$Insertar.$Recargo."','";
																					$Insertar=$Insertar.$Leyes."',";
																					$Insertar=$Insertar.$PesoH.",";
																					$Insertar=$Insertar.$PesoS.",";
																					$Insertar=$Insertar.$Valor.",'";
																					$Insertar=$Insertar.$Unidad."',";
																					$Insertar=$Insertar."'0','".$RutQ."')";
																					mysqli_query($link, $Insertar);
																				}
																			}
																			if ($PonerCandado=="S")
																			{
																				$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																				mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
																				$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila=mysqli_fetch_array($Respuesta);
																				$Insertar="insert into cal_web.registro_leyes(nro_solicitud,recargo,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
																				$Insertar=$Insertar.$SA.",'";
																				$Insertar=$Insertar.$Recargo."','";
																				$Insertar=$Insertar.$Fecha."','";
																				$Insertar=$Insertar.$Rut."','";
																				$Insertar=$Insertar.$Leyes."',";
																				$Insertar=$Insertar.$Fila["peso_humedo"].",";
																				$Insertar=$Insertar.$Fila["peso_seco"].",";
																				$Insertar=$Insertar.$Fila["valor"].",'";
																				$Insertar=$Insertar.$Fila["cod_unidad"]."',";
																				$Insertar=$Insertar."'1','".$RutQ."')";
																				mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
																				//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																				$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and candado <> '1')";
																				$Respuesta=mysqli_query($link, $Consulta);
																				$Fila= mysqli_fetch_array($Respuesta);
																				if ($Fila["existe"]== 0)
																				{
																					$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																					$insertar2.="values ('".$Rut."','".$SA."','".$Recargo."','32','".$Fecha2."','".$RutQ."')";
																					mysqli_query($link, $insertar2);
																					$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='32' where rut_funcionario = '".$Rut."' and nro_solicitud =".$SA." and recargo='".$Recargo."'";
																					mysqli_query($link, $Actualizar2);
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
}		
if ($Entrar=true)
{
	switch ($Tipo)
	{
		case "H":		
			header ("location:cal_ingreso_valor_humedad_frx.php?ValoresSA=".$ValoresSA."&CheckT=".$CheckT);
			break;
	
	}
}	
?>