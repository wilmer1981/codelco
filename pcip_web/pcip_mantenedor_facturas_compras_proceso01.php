<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO FACTURA PROVISORIA		    					
			$Consulta1=" select codigo,num_factura,cod_contrato from pcip_fac_compra where cod_contrato='".$CmbContrato."' and num_factura='".$TxtNuFact."'";
			$Resp1=mysql_query($Consulta1);
			if(!$Fila1=mysql_fetch_array($Resp1))
			{ 	
				$Consulta="select ifnull(max(codigo+1),1) as maximo from pcip_fac_compra ";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$TxtCodigo=$Fila["maximo"];
				}
				$Inserta="insert into pcip_fac_compra (codigo,num_factura,cod_contrato,fecha_emision,cuota,cod_producto,rut_proveedor,tipo,cod_mercado,estado_actual,observacion)";
				$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtNuFact)."','".$CmbContrato."','".$TxtFecha."','".$CmbCuota."','".$CmbProdMine."','".$CmbRutProveedor."','".$CmbTipoContrato."','".$CmbMercado."','".$EstadoFact."','".$TexObs."')";
				//echo "INserta Encabezado   ".$Inserta."<br>";
				mysql_query($Inserta);
				
				
				$Consulta="select ifnull(max(correlativo+1),1) as maximo from pcip_fac_compra_finos_relacion where codigo='".$TxtCodigo."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Correlativo=$Fila["maximo"];
				}			
				if($TxtTotal!='')
				{
				 $TxtTotal=str_replace('.','',$TxtTotal);
				 $TxtTotal=str_replace(',','.',$TxtTotal);
				} 
				if($TxtNeto!='')
				{
				 $TxtNeto=str_replace('.','',$TxtNeto);
				 $TxtNeto=str_replace(',','.',$TxtNeto);
				} 
				if($TxtIva!='')
				{
				 $TxtIva=str_replace('.','',$TxtIva);
				 $TxtIva=str_replace(',','.',$TxtIva);
				} 
				$Inserta="insert into pcip_fac_compra_finos_relacion (codigo,correlativo,numero,tipo_factura,estado,adjunto,valor_neto,iva,valor_total,tipo_neto,tipo_iva,tipo_total,fecha_debito_credito)";
				$Inserta.=" values('".$TxtCodigo."','".$Correlativo."','".strtoupper($TxtNuFact)."','1','A','','".str_replace(',','.',$TxtNeto)."','".str_replace(',','.',$TxtIva)."','".str_replace(',','.',$TxtTotal)."','','','','".$TxtFecha."')";
				//echo " Inserta Finos Relacion   ".$Inserta."<br>";
				mysql_query($Inserta);
				$Datos=explode('//',$Valores);
				while(list($c,$v)=each($Datos))
				{				   
					$Datos2=explode('||',$v);
					$Datos3=explode('~',$Datos2[0]);
					$CodContenido=$Datos3[1];
					$CodFino=$Datos3[2];
					$Valor=$Datos2[1];
					$Valor=str_replace('.','',$Valor);
					$Valor=str_replace(',','.',$Valor);
					$Unid=$Datos2[2];
					$Inserta="insert into pcip_fac_compra_finos (codigo,correlativo,numero,tipo_factura,cod_contenido,cod_fino,valor,cod_unidad)";
					$Inserta.=" values('".$TxtCodigo."','".$Correlativo."','".strtoupper($TxtNuFact)."','1','".$CodContenido."','".$CodFino."','".str_replace(',','.',$Valor)."','".$Unid."')";
					mysql_query($Inserta);
					//echo "Inserta Finos   ".$Inserta."<br><br>";				
				}
				
//				echo $Archivo_name."<br>";
				if($Archivo_name!='none')
				{
					$Extension=explode('.',$Archivo_name);
					if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
					{
						$Directorio='doc';
						//echo "nom".$Archivo_name."<br>";
						$Acento=false;
						for ($j = 0;$j <= strlen($Archivo_name); $j++)
						{
							switch(substr($Archivo_name,$j,1))
							{
								case "�":
									$Archivo_name=str_replace( "�","a",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","A",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","e",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","E",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","i",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","I",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","o",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","O",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","u",$Archivo_name);
								break;
								case "�":
									$Archivo_name=str_replace( "�","U",$Archivo_name);
								break;
								case "&":
									$Archivo_name=str_replace( "&","",$Archivo_name);
								break;
								case "$":
									$Archivo_name=str_replace( "$","",$Archivo_name);
								break;
								case "#":
									$Archivo_name=str_replace( "#","",$Archivo_name);
								break;
								case "'":
									$Archivo_name=str_replace( "'","",$Archivo_name);
								break;
							}
						}
						if($Acento==false)
						{
								//echo $TxtCodigo.$Correlativo.$TxtNuFact."_".$Archivo_name;
								$NombreArchivo="F".$TxtCodigo.$Correlativo.$TxtNuFact."_".$Archivo_name;
								if (copy($Archivo, $Directorio."/".$NombreArchivo))
								{
									$Actualizar1="UPDATE pcip_fac_compra_finos_relacion set adjunto='".$NombreArchivo."' where codigo='".$TxtCodigo."' and correlativo='1'";
									//echo $Actualizar1."<br>";
									mysql_query($Actualizar1);
									$Mensaje = "Archivo Copiado Exitosamente";
								}
								else
									$Mensaje = "FALLA al Copiar el Archivo";
						}
					}					
				}
				$Mensaje='Factura Provisoria Ingresada Correctamente';	
			}
			else
			{
				$TxtCodigo=$Fila1["codigo"];
				$Mensaje='Registro Existente';
			}
			header('location:pcip_mantenedor_facturas_compras_proceso.php?Opc=M&Cod='.$TxtCodigo.'&Mensaje='.$Mensaje);			
			break;
		    
		case "M"://MODIFICACION FACTURAS PROVISORIAS Y INGRESO Y MODIFICACION DE DEFINITIVAS
			if($CmbTipo!='2')//PROVISORIA
			{
				$Actualizar="UPDATE pcip_fac_compra set num_factura='".strtoupper($TxtNuFact)."',cod_contrato='".$CmbContrato."',fecha_emision='".$TxtFecha."',";
				$Actualizar.="cuota='".$CmbCuota."',cod_producto='".$CmbProdMine."',rut_proveedor='".$CmbRutProveedor."',tipo='".$CmbTipoContrato."',cod_mercado='".$CmbMercado."', observacion='".$TexObs."',estado_actual='".$EstadoFact."'";
				$Actualizar.=" where codigo='".$TxtCodigo."'";
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
				
				if($TxtTotal!='')
				{
				 $TxtTotal=str_replace('.','',$TxtTotal);
				 $TxtTotal=str_replace(',','.',$TxtTotal);
				} 
				if($TxtNeto!='')
				{
				 $TxtNeto=str_replace('.','',$TxtNeto);
				 $TxtNeto=str_replace(',','.',$TxtNeto);
				} 
				if($TxtIva!='')
				{
				 $TxtIva=str_replace('.','',$TxtIva);
				 $TxtIva=str_replace(',','.',$TxtIva);
				} 
				$Actualizar1="UPDATE pcip_fac_compra_finos_relacion set numero='".strtoupper($TxtNuFact)."',tipo_factura='1',estado='A',adjunto='',";
				$Actualizar1.=" valor_neto='".$TxtNeto."',iva='".$TxtIva."',valor_total='".$TxtTotal."',tipo_neto='',tipo_iva='',tipo_total='',fecha_debito_credito='".$TxtFecha."'";
				$Actualizar1.=" where codigo='".$TxtCodigo."' and correlativo='1'";
				echo $Actualizar1."<br>";
				mysql_query($Actualizar1);
				//echo " Inserta Finos Relacion   ".$Actualizar1."<br>";
				$Eliminar=" delete from pcip_fac_compra_finos where codigo='".$TxtCodigo."' and correlativo='1'";
				mysql_query($Eliminar);
				//echo $Eliminar."<br>";				  

				$Datos=explode('//',$Valores);
				while(list($c,$v)=each($Datos))
				{
					$Datos2=explode('||',$v);
					$Datos3=explode('~',$Datos2[0]);
					$CodContenido=$Datos3[1];
					$CodFino=$Datos3[2];
					$Valor=$Datos2[1];
					$Valor=str_replace('.','',$Valor);
					$Valor=str_replace(',','.',$Valor);
					$Unid=$Datos2[2];
					$Inserta="insert into pcip_fac_compra_finos (codigo,correlativo,numero,tipo_factura,cod_contenido,cod_fino,valor,cod_unidad)";
					$Inserta.=" values ('".$TxtCodigo."','1','".strtoupper($TxtNuFact)."','1','".$CodContenido."','".$CodFino."','".$Valor."','".$Unid."')";
					mysql_query($Inserta);
				    //echo $Inserta."<br>";
				}	    
					if($Archivo_name!='none')
					{
						$Extension=explode('.',$Archivo_name);
						if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
						{
							$Directorio='doc';
							//echo "nom".$Archivo_name."<br>";
							$Acento=false;
							for ($j = 0;$j <= strlen($Archivo_name); $j++)
							{
								switch(substr($Archivo_name,$j,1))
								{
									case "�":
										$Archivo_name=str_replace( "�","a",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","A",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","e",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","E",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","i",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","I",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","o",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","O",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","u",$Archivo_name);
									break;
									case "�":
										$Archivo_name=str_replace( "�","U",$Archivo_name);
									break;
									case "&":
										$Archivo_name=str_replace( "&","",$Archivo_name);
									break;
									case "$":
										$Archivo_name=str_replace( "$","",$Archivo_name);
									break;
									case "#":
										$Archivo_name=str_replace( "#","",$Archivo_name);
									break;
									case "'":
										$Archivo_name=str_replace( "'","",$Archivo_name);
									break;
								}
							}
							if($Acento==false)
							{
									$NombreArchivo="F".$TxtCodigo.$Correlativo.$TxtNuFact."_".$Archivo_name;
									if (copy($Archivo, $Directorio."/".$NombreArchivo))
									{
										$Actualizar1="UPDATE pcip_fac_compra_finos_relacion set adjunto='".$NombreArchivo."' where codigo='".$TxtCodigo."' and correlativo='1'";
										//echo $Actualizar1."<br>";
										mysql_query($Actualizar1);
										$Mensaje = "Archivo Copiado Exitosamente";
									}
									else
										$Mensaje = "FALLA al Copiar el Archivo";
							}
						}					
					}	
				$Mensaje='Factura Provisoria Modificada Exitosamente';				
			}		
			else//DEFINITIVA
			{
				if($CmbTipo=='2' && $CmbFactNot=='N')//NUEVA FACTURA DEFINITIVA
				{
					$Consulta="select ifnull(max(correlativo+1),1) as maximo from pcip_fac_compra_finos_relacion where codigo='".$TxtCodigo."'";
					$Resp=mysql_query($Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
						$Correlativo=$Fila["maximo"];
					}
					if($TxtTotal!='')
					{
					 $TxtTotal=str_replace('.','',$TxtTotal);
					 $TxtTotal=str_replace(',','.',$TxtTotal);
					} 
					if($TxtAfecto!='')
					{
					 $TxtAfecto=str_replace('.','',$TxtAfecto);
					 $TxtAfecto=str_replace(',','.',$TxtAfecto);
					} 
					if($TxtIva!='')
					{
					 $TxtIva=str_replace('.','',$TxtIva);
					 $TxtIva=str_replace(',','.',$TxtIva);
					} 
					if($TxtNeto!='')
					{
					 $TxtNeto=str_replace('.','',$TxtNeto);
					 $TxtNeto=str_replace(',','.',$TxtNeto);
					} 
					$Inserta="insert into pcip_fac_compra_finos_relacion (codigo,correlativo,numero,tipo_factura,estado,adjunto,valor_neto,iva,valor_total,tipo_neto,tipo_iva,tipo_total,fecha_debito_credito,tipo_nota,valor_neto2)";
					$Inserta.=" values('".$TxtCodigo."','".$Correlativo."','".strtoupper($TxtNuDeCr)."','2','A','','".$TxtAfecto."','".$TxtIva."','".$TxtTotal."','','','','".$TxtFechaDebitoCredito."','".$CmbDeCre."','".$TxtNeto."')";
					//echo $Inserta."<br>";
					mysql_query($Inserta);
										
					$Datos=explode('//',$Valores);
					while(list($c,$v)=each($Datos))
					{
						$Datos2=explode('||',$v);
						$Datos3=explode('~',$Datos2[0]);
						$CodContenido=$Datos3[1];
						$CodFino=$Datos3[2];
						$Valor=$Datos2[1];
						$Valor=str_replace('.','',$Valor);
						$Valor=str_replace(',','.',$Valor);
						$Unid=$Datos2[2];
						$Inserta1="insert into pcip_fac_compra_finos (codigo,correlativo,numero,tipo_factura,cod_contenido,cod_fino,valor,cod_unidad)";
						$Inserta1.=" values('".$TxtCodigo."','".$Correlativo."','".strtoupper($TxtNuDeCr)."','2','".$CodContenido."','".$CodFino."','".$Valor."','".$Unid."')";
						mysql_query($Inserta1);
						//echo $Inserta1."<br>";					
					}
					$Actualizar="UPDATE pcip_fac_compra set estado_actual='2' where codigo='".$TxtCodigo."'";
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);
					$CmbFactNot=strtoupper($TxtNuDeCr)."~".$Correlativo;
					$Mensaje='Factura Definitiva Ingresada Satisfactoriamente';
				}
				else//MODIFICACION DE FACTURA DEFINITVA
				{
				    $Corr=explode("~",$CmbFactNot);
					if($CmbTipo=='2' && $Corr[1]!='N')//es tipo 2 y != N
					{
					    $MensajeOpcion2CorreN=false;
						if($TxtTotal!='')
						{
						 $TxtTotal=str_replace('.','',$TxtTotal);
						 $TxtTotal=str_replace(',','.',$TxtTotal);
						} 
						if($TxtAfecto!='')
						{
						 $TxtAfecto=str_replace('.','',$TxtAfecto);
						 $TxtAfecto=str_replace(',','.',$TxtAfecto);
						} 
						if($TxtIva!='')
						{
						 $TxtIva=str_replace('.','',$TxtIva);
						 $TxtIva=str_replace(',','.',$TxtIva);
						} 
						if($TxtNeto!='')
						{
						 $TxtNeto=str_replace('.','',$TxtNeto);
						 $TxtNeto=str_replace(',','.',$TxtNeto);
						} 
						$Actualizar="UPDATE pcip_fac_compra_finos_relacion set numero='".strtoupper($TxtNuDeCr)."',estado='A',adjunto='',";
						$Actualizar.=" valor_neto='".$TxtAfecto."',iva='".$TxtIva."',tipo_factura='2',valor_total='".$TxtTotal."',tipo_neto='',tipo_iva='',tipo_total='',fecha_debito_credito='".$TxtFechaDebitoCredito."',tipo_nota='".$CmbDeCre."',valor_neto2='".$TxtNeto."'";
						$Actualizar.=" where codigo='".$TxtCodigo."' and correlativo='".$Corr[1]."'";
						//echo $Actualizar."<br>";
						mysql_query($Actualizar);
						
						$Eliminar=" delete from pcip_fac_compra_finos where codigo='".$TxtCodigo."' and correlativo='".$Corr[1]."'";
						mysql_query($Eliminar);
						//echo $Eliminar."<br>";									  
						
						$Datos=explode('//',$Valores);
						while(list($c,$v)=each($Datos))
						{
							$Datos2=explode('||',$v);
							$Datos3=explode('~',$Datos2[0]);
							$CodContenido=$Datos3[1];
							$CodFino=$Datos3[2];
							$Valor=$Datos2[1];
							$Valor=str_replace('.','',$Valor);
							$Valor=str_replace(',','.',$Valor);
							$Unid=$Datos2[2];
							$Inserta="insert into pcip_fac_compra_finos (codigo,correlativo,numero,tipo_factura,cod_contenido,cod_fino,valor,cod_unidad)";
							$Inserta.=" values ('".$TxtCodigo."','".$Corr[1]."','".strtoupper($TxtNuDeCr)."','2','".$CodContenido."','".$CodFino."','".$Valor."','".$Unid."')";
							mysql_query($Inserta);
							//echo $Inserta."<br>";
						}
						$CmbFactNot=strtoupper($TxtNuDeCr)."~".$Corr[1];
						$Actualizar="UPDATE pcip_fac_compra set estado_actual='2' where codigo='".$TxtCodigo."'";
						//echo $Actualizar."<br>";
						mysql_query($Actualizar);						
						$Mensaje='Factura Definitiva Modificada Satisfactoriamente';
					}	
				}			
			}
			header('location:pcip_mantenedor_facturas_compras_proceso.php?Opc=M&Cod='.$TxtCodigo.'&CmbTipo='.$CmbTipo.'&CmbFactNot='.$CmbFactNot.'&Mensaje='.$Mensaje);						
		   break;	
		case "E"://ELIMINACION FACTURA
			$Mensaje='N';
			$Datos = explode("//",$Cod);
			while (list($clave,$TxtCodigo)=each($Datos))
			{
								
				$Consulta="select * from pcip_fac_compra_finos_relacion where codigo='".$TxtCodigo."' and tipo_factura!='1'";
				$Respuesta=mysql_query($Consulta);
				//echo $Consulta;
				if(!$Fila=mysql_fetch_array($Respuesta))
				{							
					$Eliminar="delete from pcip_fac_compra where codigo='".$TxtCodigo."'";
					mysql_query($Eliminar);		   
					//echo $Eliminar;				
					$Eliminar1="delete from pcip_fac_compra_finos_relacion where codigo='".$TxtCodigo."'";
					mysql_query($Eliminar1);		   
					//echo $Eliminar."<br>";	
					$Eliminar2="delete from pcip_fac_compra_finos where codigo='".$TxtCodigo."' ";
					mysql_query($Eliminar2);		   
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
		    }
			header("location:pcip_mantenedor_facturas_compras.php?Mensaje=".$Mensaje."&Buscar=S");
			break;
			
		case "EI"://ELIMINACION DE RELACIONES NUMERO DE DEBITO CREDITO

			$Datos = explode("~",$Valores);			
			$Eliminar="delete from pcip_fac_compra_finos_relacion where codigo='".$Datos[0]."' and numero='".$Datos[1]."' and correlativo='".$Datos[2]."'";
			mysql_query($Eliminar);		   
			//echo $Eliminar."<br>";	
			
			$Eliminar1="delete from pcip_fac_compra_finos where codigo='".$Datos[0]."' and numero='".$Datos[1]."' and correlativo='".$Datos[2]."' ";
			mysql_query($Eliminar1);		   
			//echo $Eliminar1;
			$Consulta="select * from pcip_fac_compra_finos_relacion where codigo='".$Datos[0]."' and tipo_factura='2'";
			$Resp=mysql_query($Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
				$Actualizar="UPDATE pcip_fac_compra set estado_actual='1' where codigo='".$Datos[0]."'";
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);
			}	
			header("location:pcip_mantenedor_facturas_compras_proceso.php?Opc=M&Cod=".$TxtCodigo);		       		  
		    break;	

		case "NI":				
				header('location:pcip_mantenedor_facturas_compras_proceso.php?Opc=N');	
				break;		
			
	}
?>
