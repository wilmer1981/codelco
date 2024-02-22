<?  include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Fecha_Creacion= date("Y-m-d G:i:s");
	
	set_time_limit('10000');   
	switch($Opcion)
	{
		case "N"://NUEVO CONTRATO
			$Consulta="Select * from sget_contratos where cod_contrato='".$TxtContrato."' ";
			$Resp=mysql_query($Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
				if($TxtFechaSolp=='')
					$TxtFechaSolp='0000-00-00';
				if($TxtFechaGarantia=='')
					$TxtFechaGarantia='0000-00-00';	
				if($TxtFechaReajuste=='')	
					$TxtFechaReajuste='0000-00-00';  	
				if($TxtFechaReajusteResultado=='')	
					$TxtFechaReajusteResultado='0000-00-00';	
				if($TxtFechaPosterga=='')		
					$TxtFechaPosterga='0000-00-00';	
					
				$Insertar="Insert Into sget_contratos(cod_contrato,descripcion,cod_gerencia,cod_area,monto_ctto,rut_empresa,fecha_inicio,fecha_termino";
				$Insertar.=",cod_tipo_contrato,rut_adm_contrato,rut_adm_contratista,fecha_venc_bol_garantia,rut_prev,tipo_cambio,tipo_ctto,aviso_vencimiento,poliza,bono,reajuste,seguro,eco4,sobreTiempo,gratificacion,indemnizacion,estado,acuerdo_marco,periodo_facturacion,clasificacion,posterga,tipo_jornada,fecha_posterga)";
				$Insertar.="values('".$TxtContrato."','".strtoupper($TxtDescripcion)."','".$CmbGerencias."','".$CmbAreas."','".str_replace('.','',$TxtMontoCtto)."','".$CmbEmpresa."','".$TxtFechaInicio."','".$TxtFechaTermino."'";
				$Insertar.=",'".$CmbTipoCtto."','".$CmbAdmCtto."','".$CmbAdmContratista."','".$TxtFechaGarantia."','".$CmbPrevencionista."','".$CmbMoneda."','".$CmbTipoCttoPers."','".$CmbAvisoVenc."','".$TxtPoliza."','".$CmbBono."','".$CmbReaj."','".$CmbSeg."','".$CmbEco4."','".$CmbSobreT."','".$CmbGratif."','".$CmbIndem."','1','".$CmbAcuerdo."','".$CmbFacturacion."' ,'".$CmbClasificacion."','".$PostCont."','".$TxtJornada."','".$TxtFechaPosterga."')";
				mysql_query($Insertar);
				
				if($Form!='')
				{
			
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.$Form.action='$Pagina?Contrato=$TxtContrato&Empresa=$CmbEmpresa'; ";
					echo " window.opener.document.$Form.submit();";		
					echo " window.close();</script>";
				}
				else
				{
					//echo "hola11".$TxtContrato;
					//header("location:sget_mantenedor_contratos.php?Buscar=S&Mensaje=0&Opcion=M&TxtContrato=".$TxtContrato); 
					echo "<script languaje='JavaScript'>";
					
					//&TxtContrato2='+TxtContrato+'&TxtDescripcion2='+Descripcion+'&CmbEmpresa2='+Empresa;
					echo "window.opener.document.frmPrincipal.action='sget_mantenedor_contratos.php?Buscar=S&TxtContrato2='".$TxtContrato."'&TxtDescripcion2='".$Descripcion."'&CmbEmpresa2='".$Empresa."' ";
					echo "window.opener.document.frmPrincipal.submit();";
					echo "window.close();</script>";
				}
			}
			else
			{
			
				 header("location:sget_mantenedor_contratos_proceso.php?Mensaje=2&Opcion=M&TxtContrato=".$TxtContrato);
			}
			
			
		break;
	
		case "M"://MODIFICAR CONTRATO
				if($TxtFechaSolp=='')
					$TxtFechaSolp='0000-00-00';
				if($TxtFechaPosterga=='')		
					$TxtFechaPosterga='0000-00-00';	
					//echo "EE".$CmbFacturacion;
				$Actualizar="UPDATE  sget_contratos SET cod_contrato='".strtoupper($TxtContrato)."', descripcion='".strtoupper($TxtDescripcion)."',cod_gerencia='".$CmbGerencias."',cod_area='".$CmbAreas."',monto_ctto='".str_replace('.','',$TxtMontoCtto)."'";
				$Actualizar.=",rut_empresa='".$CmbEmpresa."',fecha_inicio='".$TxtFechaInicio."',fecha_termino='".$TxtFechaTermino."'";
				$Actualizar.=",cod_tipo_contrato='".$CmbTipoCtto."',rut_adm_contrato='".$CmbAdmCtto."',rut_adm_contratista='".$CmbAdmContratista."'";
				$Actualizar.=",fecha_venc_bol_garantia='".$TxtFechaGarantia."',rut_prev='".$CmbPrevencionista."',tipo_cambio='".$CmbMoneda."',tipo_ctto='".$CmbTipoCttoPers."',aviso_vencimiento='".$CmbAvisoVenc."',poliza='".$TxtPoliza."',estado='1' ";
				$Actualizar.=",bono='".$CmbBono."',reajuste='".$CmbReaj."',seguro='".$CmbSeg."',eco4='".$CmbEco4."',sobretiempo='".$CmbSobreT."',gratificacion='".$CmbGratif."',indemnizacion='".$CmbIndem."',acuerdo_marco='".$CmbAcuerdo."' ,periodo_facturacion = '".$CmbFacturacion."' ,clasificacion = '".$CmbClasificacion."',posterga='".$PostCont."',tipo_jornada='".$TxtJornada."',fecha_posterga='".$TxtFechaPosterga."'   ";
				if ($NewOpc =='S')
					$Actualizar.=" where cod_contrato='".$ContAnt."'";
				else
					$Actualizar.=" where cod_contrato='".$TxtContrato."'";
				//echo $Actualizar;
				mysql_query($Actualizar);
				
				if ($NewOpc=='S')
				{
					$Consulta1 ="SELECT * from des_sget.sget_bonos_contratistas where cod_contrato = '".$ContAnt."'";
					$Resp1=mysql_query($Consulta1);
					if ($Fila1=mysql_fetch_array($Resp1))
					{
						$Actualiza1="UPDATE des_sget.sget_bonos_contratistas set cod_contrato = '".$TxtContrato."' ";
						$Actualiza1.=" where cod_contrato = '".$ContAnt."'";
						mysql_query($Actualiza1);
					}

					$Consulta2 ="SELECT * from des_sget.sget_facturas_contrato where cod_contrato = '".$ContAnt."'";
					$Resp2=mysql_query($Consulta2);
					if ($Fila2=mysql_fetch_array($Resp2))
					{
						$Actualiza2="UPDATE des_sget.sget_facturas_contrato set cod_contrato = '".$TxtContrato."' ";
						$Actualiza2.=" where cod_contrato = '".$ContAnt."'";
						mysql_query($Actualiza2);
					}

					$Consulta3 ="SELECT * from des_sget.sget_hoja_ruta where cod_contrato = '".$ContAnt."'";
					$Resp3=mysql_query($Consulta3);
					if ($Fila3=mysql_fetch_array($Resp3))
					{
						$Actualiza3="UPDATE des_sget.sget_hoja_ruta set cod_contrato = '".$TxtContrato."' ";
						$Actualiza3.=" where cod_contrato = '".$ContAnt."'";
						mysql_query($Actualiza3);
					}

					$Consulta4 ="SELECT * from des_sget.sget_personal where cod_contrato = '".$ContAnt."'";
					$Resp4=mysql_query($Consulta4);
					if ($Fila4=mysql_fetch_array($Resp4))
					{
						$Actualiza4="UPDATE des_sget.sget_personal set cod_contrato = '".$TxtContrato."' ";
						$Actualiza4.=" where cod_contrato = '".$ContAnt."'";
						mysql_query($Actualiza4);
					}

					$Consulta5 ="SELECT * from des_sget.sget_personal_historia where cod_contrato = '".$ContAnt."'";
					$Resp5=mysql_query($Consulta5);
					if ($Fila5=mysql_fetch_array($Resp5))
					{
						$Actualiza5="UPDATE des_sget.sget_personal_historia set cod_contrato = '".$TxtContrato."' ";
						$Actualiza5.=" where cod_contrato = '".$ContAnt."'";
						mysql_query($Actualiza5);
					}

					$Consulta6 ="SELECT * from des_sget.sget_sub_contratistas where cod_contrato = '".$ContAnt."'";
					$Resp6=mysql_query($Consulta6);
					if ($Fila6=mysql_fetch_array($Resp6))
					{
						$Actualiza6="UPDATE des_sget.sget_sub_contratistas set cod_contrato = '".$TxtContrato."' ";
						$Actualiza6.=" where cod_contrato = '".$ContAnt."'";
						mysql_query($Actualiza6);
					}
				}
				
				if($Form!='')
				{
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.$Form.action='$Pagina?Contrato=$TxtContrato&Empresa=$CmbEmpresa'; ";
					echo " window.opener.document.$Form.submit();";		
					echo " window.close();</script>";
				}
				else
				{
				
			//	echo "RR".$TxtContrato;
				header("location:sget_mantenedor_contratos_proceso.php?Mensaje=3&Opcion=M&TxtContrato=".$TxtContrato."&CmbFacturacion=".$CmbFacturacion ."&CmbClasificacion=".$CmbClasificacion); 
																													
				}
				
		break;
		
		case "E"://ELIMINAR CONTRATO
			$Datos = explode("//",$Valores);
			while (list($clave,$Contrato)=each($Datos))
			{
				$Eliminar="delete from sget_contratos where cod_contrato='".$Contrato."'";
				mysql_query($Eliminar);	
			}
			header("location:sget_mantenedor_contratos.php?Mensaje=1&Buscar=S");
			
		break;
		
		case "GMC"://GRABAR MODIFICACIONES AL CONTRATO
			if($TxtFechaModCtto=='')
				$TxtFechaModCtto='0000-00-00';
			if($TxtMontoModCtto=='')
				$TxtMontoModCtto=0;	
				
			$Consulta="Select ifnull(max(num_modificacion)+1,1) as Cont from sget_modificaciones_contrato where cod_contrato='".$TxtContrato."'";
			$RespCorr=mysql_query($Consulta);
			if($FilaCorr=mysql_fetch_array($RespCorr))
			{
				$Correlativo=$FilaCorr[Cont];
			}	
			$Insertar="Insert Into sget_modificaciones_contrato(cod_contrato,num_modificacion,cod_tipo_modificacion,fecha,monto,fecha_sistema,observacion)";
			$Insertar.="values('".$TxtContrato."','".$Correlativo."','".$CmbTipoModificacion."','".$TxtFechaModCtto."','".$TxtMontoModCtto."','".$Fecha_Creacion."','".strtoupper($Obs)."')";
			mysql_query($Insertar);
			header("location:sget_mantenedor_contratos_proceso.php?Mensaje=4&Opcion=M&TxtContrato=".$TxtContrato);
						
		break;
		case "MMC"://MODIFICAR MODIFICACIONES AL CONTRATO
			if($TxtFechaModCtto=='')
				$TxtFechaModCtto='0000-00-00';
			if($TxtMontoModCtto=='')
				$TxtMontoModCtto=0;		
			$Actualizar="UPDATE  sget_modificaciones_contrato SET cod_tipo_modificacion='".$CmbTipoModificacion."',fecha='".$TxtFechaModCtto."',monto='".$TxtMontoModCtto."'";
			$Actualizar.=",fecha_sistema='".$Fecha_Creacion."',observacion='".strtoupper($Obs)."'";
			$Actualizar.=" where cod_contrato='".$TxtContrato."' and num_modificacion='".$Num."' ";
			mysql_query($Actualizar);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);
						
		break;
		
		case "GDF"://GRABAR MODIFICAR FACTURAS.
			if($TxtFechaIngDoc=='')
				$TxtFechaIngDoc='0000-00-00';
			if($TxtFechaIngContabilidad=='')
				$TxtFechaIngContabilidad='0000-00-00';
			if($TxtFechaIngLiberacion=='')
				$TxtFechaIngLiberacion='0000-00-00';
			if($TxtFechaEmiDoc=='')
				$TxtFechaEmiDoc='0000-00-00';
			if($Fecha=='')
				$Fecha=date("Y-m-d G:i:s");
			/*$Consulta="SELECT count(rut) as Cantidad from sget_personal where cod_contrato='".$TxtContrato."' and estado='A'";
			$RespCant=mysql_query($Consulta);
			if($FilaCant=mysql_fetch_array($RespCant))
			{	$Dota= $FilaCant[Cantidad];
			}
			else
			{	$Dota=0;
			}*/
			
			$Insertar="Insert Into sget_facturas_contrato(cod_contrato,fecha_hora,nro_factura,ano,mes,fecha_emi_doc,fecha_ing_doc,fecha_ing_cont,fecha_liber,dotacion)";
			$Insertar.="values('".$TxtContrato."','".$Fecha."','".$NFactura."','".$CmbAnoDF."','".$CmbMesDF."','".$TxtFechaEmiDoc."','".$TxtFechaIngDoc."','".$TxtFechaIngContabilidad."','".$TxtFechaIngLiberacion."','".$TxtDot."')";
			mysql_query($Insertar);	
			//echo $Insertar."<br>";
			if ($MasFac=="S")
				header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato."&CmbAnoDF=".$CmbAnodDF."&CmbMesDF=".$CmbMesDF."&TxtFechaIngDoc=".$TxtFechaIngDoc."&TxtFechaIngContabilidad=".$TxtFechaIngContabilidad."&TxtDot=".$TxtDot);
				else		
				header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);
		break;
		case "EDF"://MODIFICAR MODIFICACIONES AL CONTRATO
			
			$Delete="delete from sget_facturas_contrato where cod_contrato='".$TxtContrato."' and fecha_hora='".$Fecha."'";
			mysql_query($Delete);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);
						
		break;
		case "EMC"://ELIMINAR MODIFICACIONES AL CONTRATO
			$Eliminar="delete from sget_modificaciones_contrato where cod_contrato='".$TxtContrato."' and num_modificacion='".$num."'";
			mysql_query($Eliminar);		
			header("location:sget_mantenedor_contratos_proceso.php?Mensaje=5&Opcion=M&TxtContrato=".$TxtContrato);
						
		break;

		case "GSC"://GRABAR SUBCONTRATISTAS
			$Insertar="INSERT INTO sget_sub_contratistas(cod_contrato,rut_empresa,reunion_arranque) ";
			$Insertar.="values ('".$TxtContrato."','".$CmbSubEmpresa."','".$TxtReunnionASUB."') ";
			mysql_query($Insertar);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);
		
		break;
		case "MSubC":
			$Datos=explode('~',$Dato);
			$Insertar="UPDATE sget_sub_contratistas set reunion_arranque='".$DFecha."' ";
			$Insertar.=" where cod_contrato='".$Datos[1]."' and rut_empresa='".$Datos[0]."' ";
			mysql_query($Insertar);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato."&Mensaje=MSC");
		break;
		case "ESC"://ELIMINAR SUBCONTRATISTAS
			$Delete="delete from  sget_sub_contratistas where cod_contrato='".$TxtContrato."' and rut_empresa='".$Clave."'";
			mysql_query($Delete);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);

		break;
		case "GRC"://GRABAR REAJUSTE CONTRATOS
			//echo "Fecha Reajuste: ".$TxtFechaReajuste."<br>";
			//echo "Fecha Fin Ctto: ".$TxtFechaTermino."<br><br>";
			$FechaAux=$TxtFechaReajuste;
			$Dias=0;
			while($Dias<=0)
			{
				$FechaReaj=$FechaAux;
				$Fecha=explode('-',$FechaAux);
				$A�o=$Fecha[0];
				$Mes=$Fecha[1];
				$Dia=$Fecha[2];
				$FechaAux=date('Y-m-d',mktime(0,0,0,$Mes+$CmbReajuste,$Dia,$A�o,1));
				//echo $FechaAux."<br>";
				$Dias=resta_fechas($FechaAux,$TxtFechaTermino);
				if($Dias<=0)
				{
					$Insertar="INSERT INTO sget_reajustes_contratos(cod_contrato,tipo,fecha_reajuste,tipo_reajuste,fecha_reajustada,estado,monto,tipo_cambio) values ";
					$Insertar.="('".$TxtContrato."','C','".$FechaReaj."','".$CmbReajuste."','".$FechaAux."','P','".str_replace('.','',$TxtMontoCtto)."','".$CmbMoneda."')";
					mysql_query($Insertar);
				}
				//echo $Dias."<br>";
			}
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);

		break;
		case "ERC"://ELIMINAR REAJUSTE CONTRATOS
			$Delete="delete from  sget_reajustes_contratos where cod_contrato='".$TxtContrato."' and corr='".$Corr."'";
			mysql_query($Delete);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);

		break;
		case "GRS"://GRABAR REAJUSTE SUELDOS CONTRATISTAS
			$FechaAux=$TxtFechaReajuste2;
			$Dias=0;
			while($Dias<=0)
			{
				$FechaReaj=$FechaAux;
				$Fecha=explode('-',$FechaAux);
				$A�o=$Fecha[0];
				$Mes=$Fecha[1];
				$Dia=$Fecha[2];
				$FechaAux=date('Y-m-d',mktime(0,0,0,$Mes+$CmbReajuste2,$Dia,$A�o,1));
				//echo $FechaAux."<br>";
				$Dias=resta_fechas($FechaAux,$TxtFechaTermino);
				if($Dias<=0)
				{
					$Insertar="INSERT INTO sget_reajustes_contratos(cod_contrato,tipo,fecha_reajuste,tipo_reajuste,fecha_reajustada,estado,monto,tipo_cambio) values ";
					$Insertar.="('".$TxtContrato."','S','".$FechaReaj."','".$CmbReajuste2."','".$FechaAux."','P',0,'')";
					mysql_query($Insertar);
				}
				//echo $Dias."<br>";
			}
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);

		break;
		case "ERS"://ELIMINAR REAJUSTE SUELDOS CONTRATISTAS
			$Delete="delete from  sget_reajustes_contratos where cod_contrato='".$TxtContrato."' and corr='".$Corr."'";
			mysql_query($Delete);
			header("location:sget_mantenedor_contratos_proceso.php?Opcion=M&TxtContrato=".$TxtContrato);
		break;
		case "CDotacion"://CARGA DOTACION POR CONTRATO
					
			require_once 'reader.php';
			$Directorio='doc';
			
			$Elimina="delete from sget_contratos_dotacion_tmp where rut='".$CookieRut."'";
			mysql_query($Elimina);
		
			if($Archivo_name!='none')
			{
				$Extension=explode('.',$Archivo_name);
				if(strtoupper($Extension[1])=='XLS' || strtoupper($Extension[1])=='XLSX')
				{
					$Acento=false;
					for ($j = 0;$j <= strlen($Archivo_name[$Cont]); $j++)
					{
						switch(substr($Archivo_name[$Cont],$j,1))
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
						$NombreArchivo="carga_dotacion_contrato.".$Extension[1];
						//echo $NombreArchivo."<br>";
						if(file_exists($Directorio.'/'.$NombreArchivo))
						{
							unlink($Directorio.'/'.$NombreArchivo);
						}	
						if (copy($Archivo, $Directorio."/".$NombreArchivo))
						{
							$ProcesaArchivo = "S";
						}
						else
						{
							$ProcesaArchivo = "N";
							header('location:sget_mantenedor_contratos_proceso_carga_dota.php?Msj=NC');	
						}	
					}
				}
				else
				{
				  header('location:sget_mantenedor_contratos_proceso_carga_dota.php?Msj=NE');	
				}	
			}	
			if($ProcesaArchivo=='S')
			{
				$data = new Spreadsheet_Excel_Reader();
				$data->read($Directorio."/".$NombreArchivo);
				error_reporting(E_ALL ^ E_NOTICE);
				$Hoja=0;$Det='N';
				//$IniCol=1;
				//$IniCol=2;
				for ($i = 0; $i <= $data->sheets[$Hoja]['numRows']; $i++) 
				{
					if(is_numeric(trim($data->sheets[$Hoja]['cells'][$i][1]))==1)
					{
						//echo $data->sheets[$Hoja]['cells'][$i][6]."<br>";
						$ContratoExce=trim($data->sheets[$Hoja]['cells'][$i][6]);
						$CC=trim($data->sheets[$Hoja]['cells'][$i][8]);
						$TContrato=trim($data->sheets[$Hoja]['cells'][$i][14]);
						if($TContrato=='')
							$TContrato=0;
						$TSubContrato=trim($data->sheets[$Hoja]['cells'][$i][15]);
						if($TSubContrato=='')
							$TSubContrato=0;
						$DotaH=trim($data->sheets[$Hoja]['cells'][$i][16]);
						if($DotaH=='')
							$DotaH=0;
						$DotaM=trim($data->sheets[$Hoja]['cells'][$i][17]);
						if($DotaM=='')
							$DotaM=0;
						$Dias='';
						for($D = 18;$D <= 48; $D++)
						{
							if(trim($data->sheets[$Hoja]['cells'][$i][$D])=='')
								$Numero=0;
							else
								$Numero=trim($data->sheets[$Hoja]['cells'][$i][$D]);	
							$Dias=$Dias.$Numero."~";
						}
					    if($Dias !='')
						 	$Dias=substr($Dias,0,strlen($Dias)-1);	
						
						$Insertar="INSERT INTO sget_contratos_dotacion_tmp (cod_contrato,ano,mes,tot_contra,tot_sub_contra,tot_dota_h,tot_dota_m,distribucion_dias,rut,cc)";
						$Insertar.=" values('".$ContratoExce."','".$CmbAno."','".$CmbMes."','".$TContrato."','".$TSubContrato."','".$DotaH."','".$DotaM."','".$Dias."','".$CookieRut."','".$CC."')";
						//echo $Insertar."<br>";
						mysql_query($Insertar);
					}
				}			
			}
			header('location:sget_mantenedor_contratos_proceso_carga_dota.php?Opc=M&TxtContrato='.$TxtContrato.'&CmbMes='.$CmbMes.'&CmbAno='.$CmbAno.'&Msj=DotaC');
		break;
		case "GDotacion":
			$Datos=explode('~',$ContratosGuarda);
			foreach($Datos as $c => $v)
			{
				$Consulta="SELECT * from sget_contratos_dotacion_tmp where cod_contrato='".$v."' and rut='".$CookieRut."' and ano='".$CmbAno."' and mes='".$CmbMes."'";
				$Resp=mysql_query($Consulta);
				while($Filas=mysql_fetch_array($Resp))
				{
					$ConExis="SELECT * from sget_contratos_dotacion where cod_contrato='".$Filas["cod_contrato"]."' and ano='".$Filas["ano"]."' and mes='".$Filas[mes]."'";
					$RExis=mysql_query($ConExis);
					if(!$FExis=mysql_fetch_array($RExis))
					{
						$Inserta="INSERT INTO sget_contratos_dotacion (cod_contrato,ano,mes,tot_contra,tot_sub_contra,tot_dota_h,tot_dota_m,distribucion_dias,cc)";
						$Inserta.=" values('".$Filas["cod_contrato"]."','".$Filas["ano"]."','".$Filas[mes]."','".$Filas[tot_contra]."','".$Filas[tot_sub_contra]."','".$Filas[tot_dota_h]."','".$Filas[tot_dota_m]."','".$Filas[distribucion_dias]."','".$Filas[cc]."')";
						mysql_query($Inserta);
					}
					else
					{
						$Actualiza="UPDATE sget_contratos_dotacion set tot_contra='".$Filas[tot_contra]."',tot_sub_contra='".$Filas[tot_sub_contra]."',tot_dota_h='".$Filas[tot_dota_h]."',tot_dota_m='".$Filas[tot_dota_m]."',distribucion_dias='".$Filas[distribucion_dias]."',cc='".$Filas[cc]."'";
						$Actualiza.=" where cod_contrato='".$Filas["cod_contrato"]."' and ano='".$Filas["ano"]."' and mes='".$Filas[mes]."'";
						mysql_query($Actualiza);
					}
				}
			}
			$Msj='DotaNG';
			$Consulta="SELECT * from sget_contratos_dotacion where cod_contrato='".$TxtContrato."' and ano='".$CmbAno."' and mes='".$CmbMes."'";
			//echo $Consulta;
			$Resp=mysql_query($Consulta);
			if($Filas=mysql_fetch_array($Resp))
				$Msj='DotaG';
			if($Msj=='DotaG')
			{			
				$Elimina="delete from sget_contratos_dotacion_tmp where rut='".$CookieRut."'";
				mysql_query($Elimina);
			}
			header('location:sget_mantenedor_contratos_proceso_carga_dota.php?Opc=M&TxtContrato='.$TxtContrato.'&CmbMes='.$CmbMes.'&CmbAno='.$CmbAno.'&Msj='.$Msj);
		break;
		case "EDotacion":
			$Eliminar="delete from sget_contratos_dotacion where ano='".$AnoE."' and mes='".$MesE."'";
			mysql_query($Eliminar);
			header('location:sget_mantenedor_contratos_proceso_carga_dota.php?Opc=M&TxtContrato='.$TxtContrato.'&CmbMes='.$CmbMes.'&CmbAno='.$CmbAno.'&Msj=EDOta');
		break;
	}
?>
