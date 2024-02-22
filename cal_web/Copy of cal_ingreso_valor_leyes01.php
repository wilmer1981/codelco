<?php 
include("../principal/conectar_principal.php");
function IngresaCobre($Prod,$SubPro,$NumSA,$FechaR,$RutFun,$RutQuim)
{

	$Consulta = "select count(*) as candados_imp_abiertos ";
	$Consulta.= " from cal_web.leyes_por_solicitud ";
	$Consulta.= " where nro_solicitud=".$NumSA;
	$Consulta.= " and candado <> '1'";
	$Consulta.= " and cod_leyes <> '02'";
	$RespProd = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($RespProd);
	if ($Fila["candados_imp_abiertos"] == 0)
	{
		$Consulta = "select * ";
		$Consulta.= " from cal_web.leyes_por_solicitud ";
		$Consulta.= " where nro_solicitud=".$NumSA;
		if (($Prod==16 || $Prod==17 || $Prod==19) || ($Prod==18 && ($SubPro== '16' || $SubPro=='17')))
			$Consulta.= " and (cod_leyes <> '02')";
		else
			$Consulta.= " and (cod_leyes <> '02' and cod_leyes <> '48')";
		$RespProd = mysqli_query($link, $Consulta);
		//echo $Consulta;
		$SumaImpurezas = 0;
		$LeyCu = 0;
		while ($FilaProd = mysqli_fetch_array($RespProd))
		{
			$ValorImpureza = 0;
			$ValorImpureza = $FilaProd["valor"];
			if (($FilaProd["signo"] == "<") && ($ValorImpureza == 0.5 && $ValorImpureza > 0.2))
				$ValorImpureza = 0.4;
			if (($FilaProd["signo"] == "<") && ($ValorImpureza == 0.2 && $ValorImpureza > 0.1))
				$ValorImpureza = 0.1;
			$SumaImpurezas = $SumaImpurezas + $ValorImpureza;
		}
		if ($Prod==16 || $Prod==17|| $Prod==19)
		{
			$LeyCu = 100 - (($SumaImpurezas + 100) / 10000);
			$LeyCu = round($LeyCu,2);
		}
		else
			$LeyCu = 100 - (($SumaImpurezas) / 10000);
		
		$Actualizar = "UPDATE cal_web.leyes_por_solicitud set valor=".$LeyCu.",cod_unidad='1',proceso = '6',signo='=',rut_quimico='".$RutQuim."' where nro_solicitud=".$NumSA." and rut_funcionario ='".$RutFun."' and cod_leyes ='02'";
		mysqli_query($link, $Actualizar);
		//echo $Actualizar."<br>";
		$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values(";
		$Insertar=$Insertar.$NumSA.",'";
		$Insertar=$Insertar.$FechaR."','";
		$Insertar=$Insertar.$RutFun."','";
		$Insertar=$Insertar."02',";
		$Insertar=$Insertar.$LeyCu.",'";
		$Insertar=$Insertar."1',";
		$Insertar=$Insertar."'0','=','".$RutQuim."')";
		mysqli_query($link, $Insertar);
		//echo $Insertar."<br>";
		$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQuim."' where nro_solicitud=".$NumSA." and rut_funcionario ='".$RutFun."' and cod_leyes ='02'";		
		mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
		//echo $Actualizar."<br>";
		$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$NumSA." and rut_funcionario ='".$RutFun."' and cod_leyes ='02'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso,signo) values(";
		$Insertar=$Insertar.$NumSA.",'";
		$Insertar=$Insertar.$FechaR."','";
		$Insertar=$Insertar.$RutFun."','";
		$Insertar=$Insertar."02',";
		$Insertar=$Insertar.$Fila["peso_humedo"].",";
		$Insertar=$Insertar.$Fila["peso_seco"].",";
		$Insertar=$Insertar.$LeyCu.",'";
		$Insertar=$Insertar."1',";
		$Insertar=$Insertar."'1','".$RutQuim."','=')";
		mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
		//echo $Insertar;
	}
	return;
}
$RutQ=$CookieRut;
$Fecha = date('Y-m-d H:i');
$FechaReg = date('Y-m-d H:i:s');
$Fecha2=date("Y-m-d H:i:s");
$Entrar = true;
switch ($Opcion)
{
	case "S":
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes.php?Mostrar=S&Valores_Check=".$Valores."';";
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
															$Consulta = "select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and candado='0'";
															$Respuesta=mysqli_query($link, $Consulta);
															if(!$Fila=mysqli_fetch_array($Respuesta))
															{
																$Insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values ('";
																$Insertar=$Insertar.$Rut."',";
																$Insertar=$Insertar.$SA.",";
																$Insertar=$Insertar."'5','";
																$Insertar=$Insertar.$Fecha."','RutQ')";
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
																	//-------CONSULTA PARA SABER SI SON CATODOS E.W. EXTERNOS (PARA CALCULAR Cu AUTOMATICAMENTE)
																	$ConsProd = "select * from cal_web.solicitud_analisis where nro_solicitud = ".$SA;
																	$RespProd = mysqli_query($link, $ConsProd);
																	if ($FilaProd = mysqli_fetch_array($RespProd))
																	{
																		$Producto = $FilaProd["cod_producto"];
																		$SubProducto = $FilaProd["cod_subproducto"]; 
																	}
																	if (($Producto == "18" && ($SubProducto == "6" || $SubProducto == "7" || $SubProducto == "8"  || 
																	    $SubProducto == "17"  || $SubProducto == "16" || $SubProducto == "9" || $SubProducto == "10" || 
																		$SubProducto == "12" || $SubProducto == "56"  || $SubProducto == "45" || $SubProducto =="48" || $SubProducto =="53"
																		|| $Subproducto == "50" || $SubProducto == "51" || $SubProducto == "52" || $SubProducto =="54")) 
																		|| ($Producto == "48" && ($SubProducto == "2"))
																		|| ($Producto == "17" && ($SubProducto == "1" || $SubProducto == "2" || $SubProducto == "3" || $SubProducto == "4"))
																		|| ($Producto == "16" && $SubProducto == "24")||($Producto == "19"))
																	{

																		IngresaCobre($Producto,$SubProducto,$SA,$FechaReg,$Rut,$RutQ);
																	}
																	//--------------------------------------------------------------------
																	//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
																	$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and candado <> '1'";
																	$Respuesta=mysqli_query($link, $Consulta);
																	$Fila= mysqli_fetch_array($Respuesta);
																	if ($Fila["existe"] == 0)
																	{
																		$Consulta = "select count(*) as existe_at_quimico from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado = 5";
																		$Respuesta2=mysqli_query($link, $Consulta);
																		$Fila2= mysqli_fetch_array($Respuesta2);
																		if ($Fila2["existe_at_quimico"]==0)
																		{
																			$insertar3 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
																			$insertar3.="values ('".$Rut."','".$SA."','5','".$Fecha2."','".$RutQ."')";
																			mysqli_query($link, $insertar3);
																		}
																		$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) ";
																		$insertar2.="values ('".$Rut."','".$SA."','6','".$Fecha2."','".$RutQ."')";
																		mysqli_query($link, $insertar2);
																		$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
																		mysqli_query($link, $Actualizar2);
																	}
																}	
															//}	
														}
														else//CON RECARGO
														{
															//$Consulta = "select  * from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado='5'";
															$Consulta = "select  * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and candado='0'";															
															$Respuesta=mysqli_query($link, $Consulta);
															if(!$Fila=mysqli_fetch_array($Respuesta))
															{
																$Insertar="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso) values ('";
																$Insertar=$Insertar.$Rut."',";
																$Insertar=$Insertar.$SA.",'";
																$Insertar=$Insertar.$Recargo."',";
																$Insertar=$Insertar."'5','";
																$Insertar=$Insertar.$Fecha."','".$RutQ."')";
																mysqli_query($link, $Insertar);
																$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='5',rut_proceso='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."'";
																mysqli_query($link, $Actualizar);
															}
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
																	$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and candado <> '1'";
																	$Respuesta=mysqli_query($link, $Consulta);
																	$Fila= mysqli_fetch_array($Respuesta);
																	if ($Fila["existe"]== 0)
																	{
																		$Consulta = "select count(*) as existe_at_quimico from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado = '5'";
																		$Respuesta2=mysqli_query($link, $Consulta);
																		$Fila2= mysqli_fetch_array($Respuesta2);
																		if ($Fila2["existe_at_quimico"]==0)
																		{
																			$insertar3 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																			$insertar3.="values ('".$Rut."','".$SA."','".$Recargo."','5','".$Fecha2."','".$RutQ."')";
																			mysqli_query($link, $insertar3);					
																		}
																		$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
																		$insertar2.="values ('".$Rut."','".$SA."','".$Recargo."','6','".$Fecha2."','".$RutQ."')";
																		mysqli_query($link, $insertar2);
																		$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
																		mysqli_query($link, $Actualizar2);
																	}
																}		
															//}	
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
			header ("location:cal_ingreso_valor_leyes.php?ValoresSA=".$ValoresSA);
			break;
		case "I"://INGRESO VALOR IMPUREZAS
			header ("location:cal_ingreso_valor_impurezas.php?ValoresSA=".$ValoresSA);
			break;
		case "R"://INGRESO VALOR RETALLA		
			header ("location:cal_ingreso_valor_retalla.php?ValoresSA=".$ValoresSA);
			break;
	}
}	


?>
