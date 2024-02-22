<?php
	include("../principal/conectar_sec_web.php");
	$FechaCreacion= date("Y-m-d");
	$Ano=date("Y");
	$FechaConsulta=substr($FechaO,0,4);
	switch ($Proceso)	
	{
		case "G":
			$EncontroIns=0;
			$CodBultoAux=$CodBulto;
			$CodPaqueteIAux=$CodPaqueteI;
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='3004' and cod_subclase='".$CodBulto."' ";
			$Respuesta0=mysqli_query($link, $Consulta);
			$Fila0=mysqli_fetch_array($Respuesta0);
			$CodBulto=$Fila0["nombre_subclase"];
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='3004' and cod_subclase='".$CodPaqueteI."' ";
			$Respuesta1=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta1);
			$CodPaqueteI=$Fila1["nombre_subclase"];
			$Consulta="SELECT cod_paquete,num_paquete from sec_web.paquete_catodo ";
			$Consulta.=" where cod_paquete='".$CodPaqueteI."' and num_paquete = '".$NumPaqueteI."' 	";
			$Resp=mysqli_query($link, $Consulta);
			if ($Fil=mysqli_fetch_array($Resp))
			{
				$Consulta="SELECT cod_paquete,num_paquete from sec_web.paquete_catodo ";
				$Consulta.=" where cod_paquete='".$CodPaqueteI."' and num_paquete = '".$NumPaqueteF."' 	";
				$Resp1=mysqli_query($link, $Consulta);
				if ($Fil1=mysqli_fetch_array($Resp1))
				{
					$Consulta=" SELECT * from sec_web.lote_catodo	";
					$Consulta.=" where cod_paquete='".$CodPaqueteI."' and num_paquete = '".$NumPaqueteI."' 	";
					$Consulta.=" and cod_estado='a'			";
					$Resp0=mysqli_query($link, $Consulta);
					if ($Fil0=mysqli_fetch_array($Resp0))
					{
						$Mensaje5 = "El Paquete Inicial esta  Asignado al lote ".$Fil0["cod_bulto"]."-".$Fil0["num_bulto"].", Del A�o ,".substr($Fil0["fecha_creacion_lote"],0,4);
					}
					else
					{
						$Consulta=" SELECT * from sec_web.lote_catodo	";
						$Consulta.=" where cod_paquete='".$CodPaqueteI."' and num_paquete = '".$NumPaqueteF."' 	";
						$Consulta.=" and cod_estado='a'			";
						$Resp2=mysqli_query($link, $Consulta);
						if ($Fil2=mysqli_fetch_array($Resp2))
						{	
							$Mensaje6 = "El Paquete Final esta  Asignado al lote ".$Fil2["cod_bulto"]."-".$Fil2["num_bulto"].", Del A�o ,".substr($Fil2["fecha_creacion_lote"],0,4);							
						}
						else
						{
							$Consulta=" SELECT * from sec_web.marca_catodos   ";
							$Consulta.=" where cod_marca='".$Marca."'   	 ";
							$Resp3=mysqli_query($link, $Consulta);
							if ($Fil3=mysqli_fetch_array($Resp3))
							{
									$Consulta="SELECT * from sec_web.programa_enami		";
									$Consulta.=" where corr_enm='".$ENM."'	    		";
									$Resp4=mysqli_query($link, $Consulta);
									if ($Fil4=mysqli_fetch_array($Resp4))
									{
										$Consulta="SELECT distinct cod_bulto,num_bulto from sec_web.lote_catodo ";
										$Consulta.=" where corr_enm='".$ENM."' 	";
										$Resp20=mysqli_query($link, $Consulta);
										$Fil20=mysqli_fetch_array($Resp20);
										if ((($Fil20["cod_bulto"]==$CodBulto)&&($Fil20["num_bulto"]==$NumBulto))||(($Fil20["cod_bulto"]=="")&&($Fil20["cod_bulto"]=="")))
										{	
											$Consulta="SELECT * from sec_web.programa_enami  ";
											$Consulta.=" where corr_enm='".$ENM."' and ((estado2='C' or estado2='A') or isnull(num_prog_loteo))	";
											$Resp5=mysqli_query($link, $Consulta);
											if($Fil5=mysqli_fetch_array($Resp5))
											{
												$Mensaje8="La IE No Esta Asignada al P.Loteo o no ha sido enviada";  
											}
											else
											{
												$Consulta="SELECT cantidad_embarque,cod_cliente from sec_web.programa_enami  ";
												$Consulta.=" where corr_enm='".$ENM."'			 ";
												$Resp6=mysqli_query($link, $Consulta);
												$Fil6=mysqli_fetch_array($Resp6);
												$PesoProgramado=((($Fil6[cantidad_embarque])*1000));
												$Cliente=$Fil6["cod_cliente"];
												for($i=$NumPaqueteI;$i<=$NumPaqueteF;$i++)	
												{
													
													$Consulta="SELECT * from sec_web.paquete_catodo   ";
													$Consulta.=" where cod_paquete='".$CodPaqueteI."' and ";	
													$Consulta.=" num_paquete='".$i."' and cod_estado='a'";
													$Respuesta=mysqli_query($link, $Consulta);
													if($Fila=mysqli_fetch_array($Respuesta)) 
													{
														$Consulta="SELECT * from lote_catodo ";
														$Consulta.=" where cod_paquete='".$Fila["cod_paquete"]."' ";
														$Consulta.=" and num_paquete='".$Fila["num_paquete"]."' and cod_estado='a'  ";
														$Respuesta1=mysqli_query($link, $Consulta);
														if($Fila1=mysqli_fetch_array($Respuesta1)) 
														{						
															//si existe asignado a algun lote no hace nada 
														}
														else
														{
															$Consulta=" SELECT * from sec_web.lote_catodo ";
															$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' ";
															$Consulta.=" and  LEFT(fecha_creacion_lote,4)='".$FechaConsulta."'";
															$Respuesta2=mysqli_query($link, $Consulta);
															if($Fila2=mysqli_fetch_array($Respuesta2))
															{
																//Asigna valores ya ingresados
																$CodBulto=$Fila2["cod_bulto"];
																$NumBulto=$Fila2["num_bulto"];
																$Marca=$Fila2["cod_marca"];
																$Cliente=$Fila2["cod_cliente"];
																$CorE=$Fila2[cor_enm];
																$FechaCreacion=$Fila2["fecha_creacion_lote"];
																$Cliente=$Fila2["cod_cliente"];
																$Nave=$Fila2["cod_nave"];
																$SW=$Fila2[sw];
															}
															$Consulta="SELECT peso_paquetes from sec_web.paquete_catodo ";
															$Consulta.=" where cod_paquete='".$CodPaqueteI."' and num_paquete='".$i."'	and cod_estado='a'	";
															$Resp7=mysqli_query($link, $Consulta);
															$Fil7=mysqli_fetch_array($Resp7);
															$Consulta="SELECT sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
															$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
															$Consulta.=" and t1.num_paquete=t2.num_paquete ";
															$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$FechaConsulta."' and ";
															$Consulta.=" t1.cod_estado='a' and t2.cod_estado='a'";
															$Resp8=mysqli_query($link, $Consulta);
															$Fil8=mysqli_fetch_array($Resp8);
															$SumaTotal=$Fil8[suma_paquetes];
															if (($Fil8[suma_paquetes] + $Fil7["peso_paquetes"]) > $PesoProgramado)
															{
																$Mensaje9="Error,Peso del Lote > que el peso Programado";														
																break;
															}
															else
															{
																$A=$i;
																if ($Ant=="")
																{
																	$Ant=$A-1;
																}
																if (($A-1)==$Ant)
																{
																	//inserta nuevo registro en tabla lote catodo
																	$insertar="insert into sec_web.lote_catodo  ";
																	$insertar.="(cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,  ";
																	$insertar.=" cod_marca,cod_estado,cod_cliente,cod_nave,sw,corr_enm,disponibilidad)";
																	$insertar.= " values ('".$CodBulto."','".$NumBulto."','".$CodPaqueteI."',";
																	$insertar.=" '".$i."','".$FechaCreacion."','".$Marca."','a','".$Cliente."','".$Nave."','".$SW."','".$ENM."','P') ";
																	mysqli_query($link, $insertar);
																	$Actualizar="UPDATE sec_web.programa_enami set estado2='P' where corr_enm='".$ENM." '";
																	mysqli_query($link, $Actualizar);
																	$Actualizar="UPDATE sec_web.programa_enami set estado1='R' where corr_enm='".$ENM." '";
																	mysqli_query($link, $Actualizar);
																}
																else
																{
																	$Mensaje11="No se completo el rango se�alado por que los Paquetes  No son  Consecutivos"; 
																	break;
																}
																$Ant=$i;
															}
														}
													}
												
												} //Fin del for		
												$Consulta="SELECT sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
												$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
												$Consulta.=" and t1.num_paquete=t2.num_paquete ";
												$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$FechaConsulta."' and ";
												$Consulta.=" t1.cod_estado='a' and t2.cod_estado='a'		";
												$Resp8=mysqli_query($link, $Consulta);
												$Fil8=mysqli_fetch_array($Resp8);
												$SumaTotal2=$Fil8[suma_paquetes];//peso de paquetes
												if (($PesoProgramado-$SumaTotal2)<500)
												{
													$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T' where corr_enm='".$ENM."' and ";
													$Actualizar.=" cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$FechaConsulta."'  ";
													mysqli_query($link, $Actualizar);
													$Mensaje10="El Lote Se ha Terminado de Pesar con ".$SumaTotal2."  , Kilos ";
												}
											}
									}
									else//si  esta asiganada a otro lote
									{
										$Consulta="SELECT distinct cod_bulto,num_bulto from sec_web.lote_catodo ";
										$Consulta.=" where corr_enm='".$ENM."' 	";
										$Resp21=mysqli_query($link, $Consulta);
										$Fil21=mysqli_fetch_array($Resp21);
										$Mensaje12="La Ins.Embarque esta asignada a otro Lote,".$Fil21["cod_bulto"]."-".$Fil21["num_bulto"];
									}
									$EncontroIns=1;
									}
									else//Busca en tabla programa codelco
									{
										$Consulta="SELECT * from sec_web.programa_codelco		";
										$Consulta.=" where corr_codelco='".$ENM."'	    		";
										$Resp4=mysqli_query($link, $Consulta);
										if ($Fil4=mysqli_fetch_array($Resp4))
										{	
											$Consulta="SELECT distinct cod_bulto,num_bulto from sec_web.lote_catodo ";
											$Consulta.=" where corr_enm='".$ENM."' 	";
											$Resp20=mysqli_query($link, $Consulta);
											$Fil20=mysqli_fetch_array($Resp20);
											if ((($Fil20["cod_bulto"]==$CodBulto)&&($Fil20["num_bulto"]==$NumBulto))||(($Fil20["cod_bulto"]=="")&&($Fil20["cod_bulto"]=="")))
											{											
												$Consulta="SELECT * from sec_web.programa_codelco  ";
												$Consulta.=" where corr_codelco='".$ENM."'  and ((estado2='C'  or estado2='A') or isnull(num_prog_loteo))	";
												$Resp5=mysqli_query($link, $Consulta);
												if ($Fil5=mysqli_fetch_array($Resp5))
												{
													$Mensaje8="La IE No Esta Asignada al P.Loteo o no ha sido enviada";  
												}
												else
												{
													//inserta nuevos registros 
													$Consulta="SELECT cantidad_programada,cod_cliente from sec_web.programa_codelco  ";
													$Consulta.=" where corr_codelco='".$ENM."'			 ";
													$Resp6=mysqli_query($link, $Consulta);
													$Fil6=mysqli_fetch_array($Resp6);
													$PesoProgramado=(($Fil6["cantidad_programada"])*1000);
													$Cliente=$Fil6["cod_cliente"];
													for($i=$NumPaqueteI;$i<=$NumPaqueteF;$i++)	
													{
														$Consulta="SELECT * from sec_web.paquete_catodo   ";
														$Consulta.=" where cod_paquete='".$CodPaqueteI."' and ";	
														$Consulta.=" num_paquete='".$i."' and cod_estado='a'";
														$Respuesta=mysqli_query($link, $Consulta);
														if($Fila=mysqli_fetch_array($Respuesta)) 
														{
															$Consulta="SELECT * from lote_catodo ";
															$Consulta.=" where cod_paquete='".$Fila["cod_paquete"]."' ";
															$Consulta.=" and num_paquete='".$Fila["num_paquete"]."' and cod_estado='a'  ";
															$Respuesta1=mysqli_query($link, $Consulta);
															if($Fila1=mysqli_fetch_array($Respuesta1)) 
															{						
																//si existe asignado a algun lote no hace nada 
															}
															else
															{
																$Consulta=" SELECT * from sec_web.lote_catodo ";
																$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' ";
																$Consulta.=" and  LEFT(fecha_creacion_lote,4)='".$FechaConsulta."'";
																$Respuesta2=mysqli_query($link, $Consulta);
																if($Fila2=mysqli_fetch_array($Respuesta2))
																{
																	//Asigna valores ya ingresados
																	$CodBulto=$Fila2["cod_bulto"];
																	$NumBulto=$Fila2["num_bulto"];
																	$Marca=$Fila2["cod_marca"];
																	$Cliente=$Fila2["cod_cliente"];
																	$CorE=$Fila2[cor_enm];
																	$FechaCreacion=$Fila2["fecha_creacion_lote"];
																	$Cliente=$Fila2["cod_cliente"];
																	$Nave=$Fila2["cod_nave"];
																	$SW=$Fila2[sw];
																}
																$Consulta="SELECT peso_paquetes from sec_web.paquete_catodo ";
																$Consulta.=" where cod_paquete='".$CodPaqueteI."' and num_paquete='".$i."'	and cod_estado='a'	";
																$Resp7=mysqli_query($link, $Consulta);
																$Fil7=mysqli_fetch_array($Resp7);
																$Consulta="SELECT sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
																$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
																$Consulta.=" and t1.num_paquete=t2.num_paquete ";
																$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$FechaConsulta."'";
																$Consulta.=" and t1.cod_estado='a' and t2.cod_estado='a'";
																$Resp8=mysqli_query($link, $Consulta);
																$Fil8=mysqli_fetch_array($Resp8);
																$SumaTotal=$Fil8[suma_paquetes];
																if (($Fil8[suma_paquetes] + $Fil7["peso_paquetes"]) > $PesoProgramado)
																{
																	$Mensaje9="Error,Peso del Lote > que el peso Programado";														
																	break;
																}
																else
																{
																	$A=$i;
																	if ($Ant=="")
																	{
																		$Ant=$A-1;
																	}
																	if (($A-1)==$Ant)
																	{
																		//inserta nuevo registro en tabla lote catodo
																		$insertar="insert into sec_web.lote_catodo  ";
																		$insertar.="(cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,  ";
																		$insertar.=" cod_marca,cod_estado,cod_cliente,cod_nave,sw,corr_enm,disponibilidad)";
																		$insertar.= " values ('".$CodBulto."','".$NumBulto."','".$CodPaqueteI."',";
																		$insertar.=" '".$i."','".$FechaCreacion."','".$Marca."','a','".$Cliente."','".$Nave."','".$SW."','".$ENM."','P') ";
																		mysqli_query($link, $insertar);
																		$Actualizar="UPDATE sec_web.programa_codelco set estado2='P' where corr_codelco='".$ENM." '";
																		mysqli_query($link, $Actualizar);
																		$Actualizar="UPDATE sec_web.programa_codelco set estado1='R' where corr_codelco='".$ENM." '";
																		mysqli_query($link, $Actualizar);
																	}
																	else
																	{
																		$Mensaje11="No se completo el rango se�alado por los Paquetes No son Consecutivos"; 
																		break;
																	}
																$Ant=$i;
																}
															}
														}
													} //Fin del for
													$Consulta="SELECT sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
													$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
													$Consulta.=" and t1.num_paquete=t2.num_paquete ";
													$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$FechaConsulta."'";
													$Consulta.=" and t1.cod_estado='a' and t2.cod_estado='a'";
													$Resp8=mysqli_query($link, $Consulta);
													$Fil8=mysqli_fetch_array($Resp8);
													$SumaTotal2=$Fil8[suma_paquetes];//peso de paquetes
													if (($PesoProgramado-$SumaTotal2)<500)
													{
														$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T' where corr_enm='".$ENM."' and ";
														$Actualizar.=" cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and LEFT(fecha_creacion_lote,4)='".$FechaConsulta."'  ";
														mysqli_query($link, $Actualizar);
														
														$Mensaje10="El Lote Se ha Terminado de Pesar con ".$SumaTotal2."  , Kilos ";
													}
												}
											}
											else
											{
												$Consulta="SELECT distinct cod_bulto,num_bulto from sec_web.lote_catodo ";
												$Consulta.=" where corr_enm='".$ENM."' 	";
												$Resp21=mysqli_query($link, $Consulta);
												$Fil21=mysqli_fetch_array($Resp21);
												$Mensaje12="La Ins.Embarque esta asignada a otro Lote,".$Fil21["cod_bulto"]."-".$Fil21["num_bulto"];
											}					
										$EncontroIns=1;
										}
									}
							}//fin de la marca
							else
							{
								$Mensaje="S";
							}
						}//fin del paquete final que esta asignado al lote
					}//fin del paquete inicial que esta asignado al lote
				}//fin del else que el paquete final no existe
				else
				{
					$Mensaje4="S";
				}
			}//Fin del else  que el paquete inicial no existe
			else
			{
				$Mensaje1="S";
			}
			header("location:sec_conf_inicial_lotes_ep.php?Ver=N&Mes01=".$CodBultoAux."&Mostrar=S&Mes02=".$CodPaqueteIAux."&NumBulto01=".$NumBulto."&NumPaqueteI01=".$NumPaqueteI."&NumPaqueteF01=".$NumPaqueteF."&Marquita=".$Marca."&Mensaje=".$Mensaje."&Mensaje1=".$Mensaje1."&Mensaje4=".$Mensaje4."&Mensaje5=".$Mensaje5."&Mensaje6=".$Mensaje6."&Mensaje7=".$Mensaje7."&Mensaje8=".$Mensaje8."&EncontroIns=".$EncontroIns."&Mensaje9=".$Mensaje9."&CmbCodBulto=".$CodBultoAux."&NumBulto=".$NumBulto."&Mensaje11=".$Mensaje11."&Mensaje10=".$Mensaje10."&Mensaje12=".$Mensaje12);	
		break;
		case "Asignar":
			$Consulta="SELECT * from sec_web.lote_catodo ";
			$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto = '".$NumBulto."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$datos = explode("@@",$Valores);//Separa los parametros en un array.	
			reset($datos); 
			foreach($datos as $clave => $valor)
			{
				$arreglo=explode("//",$valor);//CodBulto//NumBulto
				$insertar="insert into sec_web.lote_catodo  ";
				$insertar.="(cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,  ";
				$insertar.=" cod_marca,corr_enm,cod_estado)";
				$insertar.= " values ('".$CodBulto."','".$NumBulto."','".$arreglo[0]."',";
				$insertar.=" '".$arreglo[1]."','".$Fila["fecha_creacion_lote"]."','".$Fila["cod_marca"]."','".$Fila["corr_enm"]."','A')";
				mysqli_query($link, $insertar);
			}
					
		break;
		case "AsignarCliente":
			$Actualizar="UPDATE sec_web.lote_catodo set cod_cliente ='".$Cliente."' where substring(fecha_creacion_lote,1,4)='".$Ano."'";
			$Actualizar.=" and cod_bulto='".$Codigo."' and num_bulto='".$Numero."' ";
			mysqli_query($link, $Actualizar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_adm_lotes_ep.php?CmbAno=".$Ano."&CodBulto=".$Codigo."&NumBulto=".$Numero."&Mostrar=S';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		break;
		case "C":
			header ("location:sec_conf_inicial_lotes_ep.php");
		break;
		case "EliminarLote":
			$Consulta="SELECT distinct corr_enm from sec_web.lote_catodo	";
			$Consulta.=" where substring(fecha_creacion_lote,1,4)='".$Ano."'";
			$Consulta.=" and cod_bulto='".$Codigo."' and num_bulto='".$Numero."'  ";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Consulta="SELECT * from sec_web.programa_enami ";
			$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'";
			$Respuesta1=mysqli_query($link, $Consulta);
			if ($Fila1=mysqli_fetch_array($Respuesta1))
			{
				if ($Fila1["estado2"]!='C')
				{
					$Actualizar="UPDATE sec_web.programa_enami set ='P' ";
					$Actualizar.=" where corr_enm='".$Fila["corr_enm"]."'			";
					mysqli_query($link, $Actualizar);
					$Eliminar="delete from lote_catodo where cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and "; 
					$Eliminar.=" substring(fecha_creacion_lote,1,4)='".$Ano."'	";
					mysqli_query($link, $Eliminar);
				}
				else
				{
					$Mensaje="S";
				}
			}
			else
			{
				$Consulta="SELECT * from sec_web.programa_codelco ";
				$Consulta.=" where corr_codelco='".$Fila["corr_enm"]."'";
				$Respuesta2=mysqli_query($link, $Consulta);
				if ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					if ($Fila2[estado2]!='C')
					{
						$Actualizar="UPDATE sec_web.programa_codelco set ='P' ";
						$Actualizar.=" where corr_codelco='".$Fila["corr_enm"]."'			";
						mysqli_query($link, $Actualizar);
						$Eliminar="delete from lote_catodo where cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and "; 
						$Eliminar.=" substring(fecha_creacion_lote,1,4)='".$Ano."'	";
						mysqli_query($link, $Eliminar);
					}
					else
					{
						$Mensaje="S";
					}
				}
			}
			header("location:sec_adm_lotes.php?CmbAno=".$Ano."&Mostrar=S&CodBulto=".$Codigo."&NumBulto=".$Numero."&Mensaje=".$Mensaje);
		break;
		case "EliminarPaquete":
		$Consulta="SELECT * from sec_web.relacion_lote_enami_codelco where "; 
		$Consulta.=" cod_lote='".$CodigoLote."' and num_lote='".$NumeroLote."'	";
		$Respuesta1=mysqli_query($link, $Consulta);
		if($Fila1=mysqli_fetch_array($Respuesta1))
		{
			$Mensaje="S";	
			header ("location:sec_detalle_paquete.php?Codigo=".$CodigoLote."&Numero=".$NumeroLote."&Ano=".$Ano."&Mensaje=".$Mensaje."&NumI=".$NumI."&NumF=".$NumF."&MesI=".$MesI);
		}
		else
		{
			$datos = explode("@@",$Valores);
			reset($datos); 
			foreach($datos as $clave => $valor)//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
			{
				$arreglo=explode("//",$valor);
				$Actualizar="UPDATE sec_web.paquete_catodo set cod_estado='a'  ";			
				$Actualizar.="	where cod_paquete='".$arreglo[0]."' and num_paquete='".$arreglo[1]."' and fecha_creacion_paquete='".$arreglo[2]."'	";
				mysqli_query($link, $Actualizar);
				$Eliminar="delete from sec_web.lote_catodo ";
				$Eliminar.=" where cod_bulto='".$CodigoLote."' and num_bulto='".$NumeroLote."' ";
				$Eliminar.=" and cod_paquete='".$arreglo[0]."' and num_paquete='".$arreglo[1]."' and 	";
				$Eliminar.=" substring(fecha_creacion_lote,1,4)='".$Ano."' ";
				mysqli_query($link, $Eliminar);		
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_adm_lotes.php?CmbAno=".$Ano."&CodBulto=".$CodigoLote."&NumBulto=".$NumeroLote."&Mostrar=S';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";	
		}	
		break;
		case "MarcaCatodos":
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_conf_inicial_lotes_ep.php?Mostrar=S&Marquita=".$Marca."&Mes01=".$Mes01."&NumBulto01=".$NumBulto01."&Mes02=".$Mes02."&NumPaqueteI01=".$NumPaqueteI01."&NumPaqueteF01=".$NumPaqueteF01."&Ver=N';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		break;
	}		
?>