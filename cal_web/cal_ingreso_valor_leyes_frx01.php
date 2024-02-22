<?php 
include("../principal/conectar_principal.php");
$RutQ=$CookieRut;
$Fecha = date('Y-m-d H:i');
$FechaReg = date('Y-m-d H:i:s');
$Fecha2=date("Y-m-d H:i:s");
$Entrar = true;
switch ($Opcion)
{
	case "S":
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes_frx.php?Mostrar=S&Valores_Check=".$Valores."';";
		//echo "window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes.php?Mostrar=S';";
		echo "window.opener.document.FrmIngLeyes.submit();";		
		echo "window.close();</script>";
		$Entrar=false;
		break;
	case "G":
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
														$Signo="=";
														if ($Valor!='')
														{
															if ($Valor=="ND")
															{
																$Valor="NULL";	
																$Signo="N";//PARA INDICAR QUE ES UN VALOR NO DETECTADO
															}
															else
															{
																$Valor=str_replace(",",".",$Valor);
															}		
														}
														else
														{
															$Valor="NULL";
														}												
														$Unidad=substr($ValorUnidad,$m+2);
														$Unidad=substr($Unidad,0,strlen($Unidad)-1);
														if ($Signo!='N')
														{
															$Signo=substr($ValorUnidad,strlen($ValorUnidad)-1);
														}
														if ($Recargo =='N')//SIN RECARGO
														{
															$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
															$Respuesta=mysqli_query($link, $Consulta);
															if($Fila=mysqli_fetch_array($Respuesta))
															{
																if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
																{
																	if (($Leyes=='02') || ($Leyes=='04') || ($Leyes=='05'))//DOSIMACIA ESTADO 6
																	{
																		$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso = '6',signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																		mysqli_query($link, $Actualizar);
																	}
																	else
																	{
																		if ($Fila["proceso"]==0)//QUIMICO ESTADO 3
																		{
																			$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso=3,signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																			mysqli_query($link, $Actualizar);
																		}	
																		else
																		{
																			if ((($Fila["proceso"]==1) || ($Fila["proceso"]==2)) and ($Valor=='NULL'))//ANULAR
																			{
																				$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso = '5',signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																				mysqli_query($link, $Actualizar);
																			}
																			else
																			{
																				if (($Fila["proceso"]==1) || ($Fila["proceso"]==2)||($Fila["proceso"]=='3')||($Fila["proceso"]=='4')||($Fila["proceso"]=='5'))//MODIFICAR
																				{
																					$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso = '4',signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																					mysqli_query($link, $Actualizar);
																				}
																			}	
																		}	
																	}	
																	$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
																	$Insertar=$Insertar.$SA.",'";
																	$Insertar=$Insertar.$FechaReg."','";
																	$Insertar=$Insertar.$Rut."','";
																	$Insertar=$Insertar.$Leyes."',";
																	$Insertar=$Insertar.$Valor.",'";
																	$Insertar=$Insertar.$Unidad."',";
																	$Insertar=$Insertar."'0','$Signo','$RutQ')";
																	mysqli_query($link, $Insertar);
																}
															}
															$Consulta = "select cod_producto from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."'";																	
															$Respuesta=mysqli_query($link, $Consulta);
															$Fila=mysqli_fetch_array($Respuesta);
															if (($Fila["cod_producto"]=="16")||($Fila["cod_producto"]=="17")||($Fila["cod_producto"]=="18")||($Fila["cod_producto"]=="20")||($Fila["cod_producto"]=="21"))
															{
																$Consulta="select count(*) as total from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes <> '01' and signo <> 'N' and isnull(valor) ";
																$Respuesta=mysqli_query($link, $Consulta);
																$Fila=mysqli_fetch_array($Respuesta);
																if ($Fila["total"]==0)
																{
																	$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) ";
																	$insertar2.="values ('".$Rut."','".$SA."','32','".$Fecha2."','".$RutQ."')";
																	mysqli_query($link, $insertar2);
																	$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='32' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
																	mysqli_query($link, $Actualizar2);
																	$Actualizar3= "UPDATE  cal_web.leyes_por_solicitud set candado ='1',rut_quimico='".$RutQ."' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
																	mysqli_query($link, $Actualizar3);
																	$Actualizar4= "UPDATE  cal_web.registro_leyes set candado ='1',rut_proceso='".$RutQ."' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
																	mysqli_query($link, $Actualizar4);
																}
															}
															else
															{
																if ($PonerCandado=="S")
																{
																	$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";		
																	mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
																	$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
																	$Respuesta=mysqli_query($link, $Consulta);
																	$Fila=mysqli_fetch_array($Respuesta);
																	$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso,signo) values(";
																	$Insertar=$Insertar.$SA.",'";
																	$Insertar=$Insertar.$FechaReg."','";
																	$Insertar=$Insertar.$Rut."','";
																	$Insertar=$Insertar.$Leyes."',";
																	$Insertar=$Insertar.$Fila["peso_humedo"].",";
																	$Insertar=$Insertar.$Fila["peso_seco"].",";
																	$Insertar=$Insertar.$Fila["valor"].",'";
																	$Insertar=$Insertar.$Fila["cod_unidad"]."',";
																	$Insertar=$Insertar."'1','".$RutQ."','$Signo')";
																	mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
																	//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																	$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and candado <> '1')";
																	$Respuesta=mysqli_query($link, $Consulta);
																	$Fila= mysqli_fetch_array($Respuesta);
																	if ($Fila["existe"] == 0)
																	{
																		$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) ";
																		$insertar2.="values ('".$Rut."','".$SA."','32','".$Fecha2."','".$RutQ."')";
																		$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='32' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
																		mysqli_query($link, $insertar2);
																		mysqli_query($link, $Actualizar2);
																		$ConsProd = "select * from cal_web.solicitud_analisis where nro_solicitud = ".$SA;
																		$RespProd = mysqli_query($link, $ConsProd);
																		if ($FilaProd = mysqli_fetch_array($RespProd))
																		{
																			$Producto = $FilaProd["cod_producto"];
																			$SubProducto = $FilaProd["cod_subproducto"]; 
																		}
																		TraspasarDatoPI($Producto,$SubProducto,$SA);
																	}
																}	
															}	
														}
														else//CON RECARGO
														{
															$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";											
															$Respuesta=mysqli_query($link, $Consulta);	
															if($Fila=mysqli_fetch_array($Respuesta))
															{
																if(($Valor)!=($Fila["valor"]) or (($Unidad)!=($Fila["cod_unidad"])))
																{
																	if (($Leyes=='02') || ($Leyes=='04') || ($Leyes=='05'))//DOSIMACIA ESTADO 6
																	{
																		$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso = '6',signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																		mysqli_query($link, $Actualizar);
																	}
																	else
																	{
																		if ($Fila["proceso"]==0)//QUIMICO ESTADO 3
																		{
																			$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso=3,signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																			mysqli_query($link, $Actualizar);
																		}	
																		else
																		{
																			if ((($Fila["proceso"]==1) || ($Fila["proceso"]==2)) and ($Valor=='NULL'))//ANULAR
																			{
																				$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso = '5',signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																				mysqli_query($link, $Actualizar);
																			}
																			else
																			{
																				if (($Fila["proceso"]==1) || ($Fila["proceso"]==2)||($Fila["proceso"]=='3')||($Fila["proceso"]=='4')||($Fila["proceso"]=='5'))//MODIFICAR
																				{
																					$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$Valor.",cod_unidad='".$Unidad."',proceso = '4',signo='".$Signo."',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																					mysqli_query($link, $Actualizar);
																				}
																			}	
																		}	
																	}	
																	$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
																	$Insertar=$Insertar.$SA.",'";
																	$Insertar=$Insertar.$FechaReg."','";
																	$Insertar=$Insertar.$Rut."','";
																	$Insertar=$Insertar.$Recargo."','";
																	$Insertar=$Insertar.$Leyes."',";
																	$Insertar=$Insertar.$Valor.",'";
																	$Insertar=$Insertar.$Unidad."',";
																	$Insertar=$Insertar."'0','";
																	$Insertar=$Insertar.$Signo."','$RutQ')";
																	mysqli_query($link, $Insertar);
																}
															}
															$Consulta = "select cod_producto from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."'";																	
															$Respuesta=mysqli_query($link, $Consulta);
															$Fila=mysqli_fetch_array($Respuesta);
															if (($Fila["cod_producto"]=="16")||($Fila["cod_producto"]=="17")||($Fila["cod_producto"]=="18")||($Fila["cod_producto"]=="20")||($Fila["cod_producto"]=="21"))
															{
																$Consulta="select count(*) as total from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_leyes <> '01' and signo <> 'N' and isnull(valor)";
																$Respuesta=mysqli_query($link, $Consulta);
																$Fila=mysqli_fetch_array($Respuesta);
																if ($Fila["total"]==0)
																{
																	$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																	$insertar2.="values ('".$Rut."','".$SA."','".$Recargo."','32','".$Fecha2."','".$RutQ."')";
																	mysqli_query($link, $insertar2);
																	$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='32' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
																	mysqli_query($link, $Actualizar2);
																	$Actualizar3= "UPDATE  cal_web.leyes_por_solicitud set candado ='1',rut_quimico='".$RutQ."' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
																	mysqli_query($link, $Actualizar3);
																	$Actualizar4= "UPDATE  cal_web.registro_leyes set candado ='1',rut_proceso='".$RutQ."' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
																	mysqli_query($link, $Actualizar4);
																}
															}
															else
															{
																if ($PonerCandado=="S")
																{
																	$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																	mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
																	$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
																	$Respuesta=mysqli_query($link, $Consulta);
																	$Fila=mysqli_fetch_array($Respuesta);
																	$Insertar="insert into cal_web.registro_leyes(nro_solicitud,recargo,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso,signo) values(";
																	$Insertar=$Insertar.$SA.",'";
																	$Insertar=$Insertar.$Recargo."','";
																	$Insertar=$Insertar.$FechaReg."','";
																	$Insertar=$Insertar.$Rut."','";
																	$Insertar=$Insertar.$Leyes."',";
																	$Insertar=$Insertar.$Fila["peso_humedo"].",";
																	$Insertar=$Insertar.$Fila["peso_seco"].",";
																	$Insertar=$Insertar.$Fila["valor"].",'";
																	$Insertar=$Insertar.$Fila["cod_unidad"]."',";
																	$Insertar=$Insertar."'1','".$RutQ."','$Signo')";
																	mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
																	//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																	$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and candado <> '1')";
																	$Respuesta=mysqli_query($link, $Consulta);
																	$Fila= mysqli_fetch_array($Respuesta);
																	if ($Fila["existe"]== 0)
																	{
																		$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																		$insertar2.="values ('".$Rut."','".$SA."','".$Recargo."','32','".$Fecha2."','".$RutQ."')";
																		$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='32' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
																		mysqli_query($link, $insertar2);
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
			$Valores=substr($Valores,$f+2);
			$f=0;
			}	
		}
		break;
}	
if ($Entrar==true)
{
	switch ($Tipo)
	{
		case "L"://INGRESO VALOR LEYES
			header ("location:cal_ingreso_valor_leyes_frx.php?ValoresSA=".$ValoresSA);
			break;
		
		case "R"://INGRESO VALOR RETALLA		
			header ("location:cal_ingreso_valor_retalla_frx.php?ValoresSA=".$ValoresSA);
			break;
	}
}
function TraspasarDatoPI($Producto,$SubProducto,$SA)
{
	$Consulta = "select t1.cod_producto,t1.cod_subproducto, t2.descripcion as nom_producto,t3.descripcion as nom_subproducto ";
	$Consulta.=" from raf_web.ti_interfaces_cal_productos t1 inner join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.=" where t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."'";
	//echo $Consulta."<br>";
	$Resp = mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Cod_Prod=$Fila["cod_producto"];
		$Cod_SubProd=$Fila["cod_subproducto"];
		$Nom_Prod=$Fila["nom_producto"];
		$Nom_SubProd=$Fila["nom_subproducto"];
		$Consulta= "select t1.nro_solicitud,t1.fecha_hora,t1.id_muestra,t1.fecha_muestra,t2.valor,t3.abreviatura as nombre_leyes,t4.abreviatura as nombre_unidad ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora ";
		$Consulta.= " and t1.nro_solicitud=t2.nro_solicitud and t1.recargo=t2.recargo inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes=t3.cod_leyes inner join proyecto_modernizacion.unidades t4 on t2.cod_unidad=t4.cod_unidad ";
		$Consulta.= " where t1.nro_solicitud='".$SA."' and t1.estado_actual in ('32') and t1.cod_producto='".$Cod_Prod."' and t1.cod_subproducto='".$Cod_SubProd."'";
		$RespLey=mysqli_query($link, $Consulta);
		while($FilaLey=mysqli_fetch_array($RespLey))
		{
			$Fecha_hora=$FilaLey["fecha_hora"];
			$Id_Muestra=$FilaLey["id_muestra"];
			$Fecha_Muestra=$FilaLey["fecha_muestra"];
			$Ley=$FilaLey["nombre_leyes"];
			/*if is_null($FilaLey["valor"])
				$Valor_Ley="";
			else*/
				$Valor_Ley=$FilaLey["valor"];
			$Unidad=$FilaLey["nombre_unidad"];
			$Consulta="select * from raf_web.ti_interfaces_cal where NUM_SOLICITUD='".$SA."' and FECHA_CREACION='".$Fecha_hora."' and COD_PRODUCTO='".$Cod_Prod."' and COD_SUBPRODUCTO ='".$Cod_SubProd."' and C_ELEMENTO='".$Ley."'";
			$Resp3=mysqli_query($link, $Consulta);
			if($FilaResp=mysqli_fetch_array($Resp3))
			{
				$Actualizar="UPDATE raf_web.ti_interfaces_cal set C_LEY='".str_replace(",", ".",$Valor_Ley)."',C_UNIDAD_ELEMENTO='".$Unidad."' where NUM_SOLICITUD='".$SA."' and FECHA_CREACION='".$Fecha_hora."' and COD_PRODUCTO='".$Cod_Prod."' and COD_SUBPRODUCTO ='".$Cod_SubProd."' and C_ELEMENTO='".$Ley ."'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				$Insertar="insert into raf_web.ti_interfaces_cal (NUM_SOLICITUD,FECHA_CREACION,COD_PRODUCTO,COD_SUBPRODUCTO,NOM_PRODUCTO,NOM_SUBPRODUCTO,ID_MUESTRA,FECHA_MUESTRA,C_ELEMENTO,C_LEY,C_UNIDAD_ELEMENTO) values ";
				$Insertar.="('".$SA."','".$Fecha_hora."','".$Cod_Prod."','".$Cod_SubProd."','".$Nom_Prod."','".$Nom_SubProd."','".$Id_Muestra."','".$Fecha_Muestra."','".$Ley."','".str_replace(",", ".",$Valor_Ley)."','".$Unidad."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
		}
	}
}

	
?>