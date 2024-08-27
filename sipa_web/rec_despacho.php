<?php
	//echo "ESTOY MODIFICANDO LA PANTALLA(INFO-FARA)";
	$CodigoDeSistema=24;
	$CodigoDePantalla=4;
	include("../principal/conectar_principal.php");
	include("funciones.php");
	
	$SERVER_NAME  = $_SERVER['SERVER_NAME']; //nombre del servidor : localhost
	$REMOTE_ADDR  = gethostbyaddr($_SERVER['REMOTE_ADDR']); //Nombnre completro de la PC : WSALDANA-PERU.sml.sermaluc.cl
	$COMPUTERNAME =  getenv("COMPUTERNAME"); //nombre de la PC : WSALDANA-PERU
	$IP           = getenv("REMOTE_ADDR"); //Obtiene la IP de cada equipo: ::1 
	
	//echo date_default_timezone_get()."<br>";
	//echo date('d-m-y H:i:s');
	$CookieRut = $_COOKIE["CookieRut"];

	$RNA     = isset($_REQUEST["RNA"])?$_REQUEST["RNA"]:"";
	$Bloq1   = isset($_REQUEST["Bloq1"])?$_REQUEST["Bloq1"]:"";
	$Bloq2   = isset($_REQUEST["Bloq2"])?$_REQUEST["Bloq2"]:"";
	$ObjFoco = isset($_REQUEST["ObjFoco"])?$_REQUEST["ObjFoco"]:"";

	$TxtNumBascula  = isset($_REQUEST["TxtNumBascula"])?$_REQUEST["TxtNumBascula"]:"";
	$TxtBasculaAux  = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$TipoProceso    = isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:'';
	$Proceso        = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";

	$TxtPatente = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$Bloqueo    = isset($_REQUEST["Bloqueo"])?$_REQUEST["Bloqueo"]:"";
	$BloqueoTxt = isset($_REQUEST["BloqueoTxt"])?$_REQUEST["BloqueoTxt"]:"";	 
	$TotPesEjes = isset($_REQUEST["TotPesEjes"])?$_REQUEST["TotPesEjes"]:"";
	$LimpiaPag  = isset($_REQUEST["LimpiaPag"])?$_REQUEST["LimpiaPag"]:"";

	$TxtFecha   = isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:date("Y-m-d");
	$TxtCorrel  = isset($_REQUEST["TxtCorrel"])?$_REQUEST["TxtCorrel"]:"";
	$TitCmbCorr = isset($_REQUEST["TitCmbCorr"])?$_REQUEST["TitCmbCorr"]:"";
	$TxtPesoHistorico = isset($_REQUEST["TxtPesoHistorico"])?$_REQUEST["TxtPesoHistorico"]:"";
	$TxtPesoBruto = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:0;
	$TxtPesoTara  = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtHoraS     = isset($_REQUEST["TxtHoraS"])?$_REQUEST["TxtHoraS"]:"";	
	$TxtHoraE     = isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:"";
	$TxtPesoNeto  = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$TxtGuia      = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$CmbGrupoProd = isset($_REQUEST["CmbGrupoProd"])?$_REQUEST["CmbGrupoProd"]:"";
	$CmbSubProducto  = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";	
	$CmbProveedor    = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$CmbTipoDespacho = isset($_REQUEST["CmbTipoDespacho"])?$_REQUEST["CmbTipoDespacho"]:"";
	$CmbLotes   = isset($_REQUEST["CmbLotes"])?$_REQUEST["CmbLotes"]:"";
	$TxtLote    = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$TxtRecargo = isset($_REQUEST["TxtRecargo"])?$_REQUEST["TxtRecargo"]:"";
	$CmbUltRecargo = isset($_REQUEST["CmbUltRecargo"])?$_REQUEST["CmbUltRecargo"]:"";	
	$TxtObs        = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$TxtRutChofer  = isset($_REQUEST["TxtRutChofer"])?$_REQUEST["TxtRutChofer"]:"";
	$TxtNomChofer  = isset($_REQUEST["TxtNomChofer"])?$_REQUEST["TxtNomChofer"]:"";
	$CmbCodMop = isset($_REQUEST["CmbCodMop"])?$_REQUEST["CmbCodMop"]:"";
	$TxtTarjeta = isset($_REQUEST["TxtTarjeta"])?$_REQUEST["TxtTarjeta"]:"";
	$TxtPesoTotalNeto = isset($_REQUEST["TxtPesoTotalNeto"])?$_REQUEST["TxtPesoTotalNeto"]:0;
	$TxtPNetoTot = isset($_REQUEST["TxtPNetoTot"])?$_REQUEST["TxtPNetoTot"]:0;
	$OrigenDatosGuia = isset($_REQUEST["OrigenDatosGuia"])?$_REQUEST["OrigenDatosGuia"]:"";
	$TxtPorcRango = isset($_REQUEST["TxtPorcRango"])?$_REQUEST["TxtPorcRango"]:"";
	$DifLimitePeso = isset($_REQUEST["DifLimitePeso"])?$_REQUEST["DifLimitePeso"]:"";
	$TxtNumRomana = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";

	$bascula_entrada = isset($_REQUEST["bascula_entrada"])?$_REQUEST["bascula_entrada"]:"";
	$bascula_salida = isset($_REQUEST["bascula_salida"])?$_REQUEST["bascula_salida"]:"";
	$TxtNombrePrv = isset($_REQUEST["TxtNombrePrv"])?$_REQUEST["TxtNombrePrv"]:"";
	$Valor = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	$TxtDirec = isset($_REQUEST["TxtDirec"])?$_REQUEST["TxtDirec"]:"";
	$TxtSello = isset($_REQUEST["TxtSello"])?$_REQUEST["TxtSello"]:"";
	$TxtTransp = isset($_REQUEST["TxtTransp"])?$_REQUEST["TxtTransp"]:"";
  
	if(isset($RNA) && $RNA!='')	
	{	
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}
	if($TxtNumRomana=='')
		$TxtNumRomana=isset($_COOKIE["ROMANA"])?$_COOKIE["ROMANA"]:"";

	CerrarLotesMensuales('D',$link);
	
	if ($LimpiaPag=='S')
	{
			$TxtCorrelativo='';
			$TxtPatente='';
			$TxtGuia='';
			$TxtFecha='';
			$TxtHoraE='';
			$TxtHoraS='';
			$TxtPesoTara='';
			$TxtPesoNeto='';
			$CmbCodMop='';
			$TxtTarjeta='';
	}
	$EstadoInput='';$EstPatente='';$EstBtnPBruto='';$EstBtnPTara='';$EstPesoOk='';
	$EstBtnGrabar='disabled';$EstBtnAnular='disabled';$EstBtnImprimir='disabled';$EstBtnModificar='disabled';
	$HabilitarCmb='';
	//$HabilitarCmb2='';
	$Class="";
	switch($TxtNumBascula)
	{
		case "1":
			$EstOptBascula='checked';
			$EstOptBascula2='';
			break;
		case "2":
			$EstOptBascula='';
			$EstOptBascula2='checked';
			break;
		default:
			$EstOptBascula='checked';
			$EstOptBascula2='';
			$TxtNumBascula='1';
			break;		
	}
	$RutOperador=$CookieRut;
	$Mensaje='';$TotalLote=0;
	if($ObjFoco=="")
		$ObjFoco="TxtPatente";
	
//DETERMINAR SI ES ENTRADA O SALIDA
	if($TipoProceso=='' && $TxtPatente<>"")
	{
		$Consulta="SELECT * from sipa_web.despachos where patente = '".$TxtPatente."' and peso_bruto='0' and estado<>'A' order by fecha desc";
		$Respuesta=mysqli_query($link, $Consulta);
		if(!$Fila=mysqli_fetch_array($Respuesta))
		{
				$TipoProceso='E';
		}
		else
		{	
			$Consulta="SELECT * from sipa_web.despachos where patente = '".$TxtPatente."' and peso_bruto='0' and ";
			$Consulta.="peso_tara<>'0' and peso_neto='0' and estado<>'A'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$TipoProceso='S';
			}
			else
			{

				$TipoProceso='E';
				
			}
		}
	}	
	$Mostrar='N';
	$HabilitarText='';
	function PatenteValida($Patente,$PatenteOk,$EstPatente,$Mensaje)
	{
			/*$Consulta="SELECT * from sipa_web.camion where patente='".$Patente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{	
				$PatenteOk=true;
				$EstPatente='readonly';
			}	
			else
			{	
				$PatenteOk=false;
				$Mensaje='Patente Camion No Registrada';
			}*/
			$PatenteOk=true;
			$Mensaje='';
			return $PatenteOk;
	}
	//echo "TipoProceso ".$TipoProceso."<br>";
	//DEFINE SI ES ENTRADA O SALIDA
	switch($TipoProceso)
	{
		case "E":
			$EstBtnGrabar='';
			$PatenteOk='';
			if($TxtPesoNeto=='')
				$TxtPesoNeto=0;
			if($TxtPesoTara=='')
				$TxtPesoTara=0;			
			
			$PatenteOk= PatenteValida($TxtPatente,$PatenteOk,$EstPatente,$Mensaje);
			if($PatenteOk==true && $TxtCorrelativo=='')
			{
				PesoHistorico('D',$TxtPatente,$TxtPesoHistorico,$TxtPorcRango,'E','','',$link);

				//$Consultad="SELECT patente ";
				//$Consultad.="from despachos where lote='' and recargo='' and bascula_entrada='' and bascula_salida ='' and patente ='".$TxtPatente."' ";

				$Consultad="SELECT correlativo,fecha,hora_entrada ";
				$Consultad.="from sipa_web.despachos where lote='' and recargo='' and bascula_entrada='' and bascula_salida ='' and  estado<>'A' and patente ='".$TxtPatente."' ";
				$Respuestad=mysqli_query($link, $Consultad);
				$Fila=mysqli_fetch_array($Respuestad);

				mysqli_num_rows($Respuestad);
				$cantidad=mysqli_num_rows($Respuestad);
				if($cantidad >=1)
				{
                      $TxtCorrelativo=$Fila["correlativo"];
					  $TxtFecha=$Fila["fecha"];
					  $TxtHoraE=$Fila["hora_entrada"];
					  $HabilitarCmb='disabled';
					  $ObjFoco='CmbCodMop';
					  //echo $Fila["correlativo"];
				}else{
				
					$Consulta="SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.despachos where correlativo < 1000000";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					$TxtCorrelativo=$Fila["correlativo"];
					$TxtFecha=date('Y-m-d');
					$TxtHoraE=date('G:i:s');
					CrearArchivoResp('D','E',$TxtCorrelativo,'','','',$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'','',$TxtPesoTara,'','','','','','','',$TxtPatente,'','',$TxtObs,'','','','','');
					$Insertar="INSERT INTO sipa_web.despachos (correlativo,rut_operador,bascula_entrada,bascula_salida,fecha,";
					$Insertar.="hora_entrada,peso_tara,patente) values(";
					$Insertar.="'$TxtCorrelativo','".$RutOperador."','$bascula_entrada','$bascula_salida','$TxtFecha',";
					$Insertar.="'$TxtHoraE','$TxtPesoTara','".strtoupper(trim($TxtPatente))."')";
					$HabilitarCmb='disabled';
					//echo $Insertar;
					mysqli_query($link, $Insertar);
					$ObjFoco='CmbCodMop';
				}			
								
			}
			else
				//$ObjFoco='TxtPatente'; 
				$ObjFoco='TxtGuia';// por WSO
			break;
		case "S"://SALIDA DEL CAMION
			$EstBtnGrabar='';
			$EstBtnAnular='';
			$EstBtnImprimir='';
			$PatenteOk = '';
			$PatenteOk = PatenteValida($TxtPatente,$PatenteOk,$EstPatente,$Mensaje);
			if($PatenteOk==true)
			{
				$TitCmbCorr="Seleccionar";
				switch($Proceso)
				{
					case "BC"://BUSCAR CORRELATIVO
						$Datos=explode('~',$TxtCorrelativo);
						//echo '*** Datos = ' . $Datos[0] . ' - ' . $Datos[1] . ' - ' . $Datos[2] . ' - ' . $Datos[3];
						$OrigenDatosGuia=isset($Datos[2])?$Datos[2]:"";
						$Consulta ="SELECT distinct t1.lote,t1.recargo,t1.patente,t1.correlativo,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.conjunto,";
						$Consulta.="t1.cod_despacho,t1.cod_mop,t1.peso_bruto,t1.peso_tara,t1.observacion, t1.rut_chofer, t1.nombre_chofer from sipa_web.despachos t1 ";
						$Consulta.="where correlativo='".$Datos[0]."'";
						$Resp2 = mysqli_query($link, $Consulta);
					   // echo "Consulta 1 ".$Consulta."<br>";
						while($Fila = mysqli_fetch_array($Resp2))
						{
							$TxtCorrelativo=$Fila["correlativo"];
							$TxtPatente=$Fila["patente"];
							$TxtGuia=isset($Datos[1])?$Datos[1]:"";
							$TxtLote=$Fila["lote"];
							$TxtRecargo=$Fila["recargo"];
							$TxtFecha=$Fila["fecha"];
							$TxtHoraE=$Fila["hora_entrada"];
							$TxtHoraS=date('G:i:s');
							$TxtPesoTara=isset($Fila["peso_tara"])?$Fila["peso_tara"]:0;
							$TxtPesoNeto=abs($TxtPesoBruto - $TxtPesoTara);
							$CmbTipoDespacho=$Fila["cod_despacho"];
							$CmbConjunto=$Fila["conjunto"];
							$TxtObs=$Fila["observacion"];
							$CmbCodMop=$Fila["cod_mop"];
							$Consulta ="SELECT numtarjeta,pestotejes from sipa_web.datos_ejes where folio='".$Datos[0]."'";
							$RespEjes = mysqli_query($link, $Consulta);
							$FilaEjes = mysqli_fetch_array($RespEjes);
							$TxtTarjeta=isset($FilaEjes["numtarjeta"])?$FilaEjes["numtarjeta"]:"";
							$TotPesEjes = isset($FilaEjes["pestotejes"])?$FilaEjes["pestotejes"]:"";
							$TxtRutChofer = $Fila["rut_chofer"];
							$TxtNomChofer = $Fila["nombre_chofer"];
						//	echo "OrigenDatosGuia ".$OrigenDatosGuia."<br>"; 
							switch($OrigenDatosGuia)
							{
								case "C":
								$BloqueoTxt='';
								$Bloqueo='';
								//DATOS CATODOS
									$TitCmbCorr="Corr  -  Guia";
									$FechaInicio=date('Y-m-d');
									$FechaTermino=date('Y-m-d');
									$Consulta ="SELECT t3.cod_sub_cliente,t3.cod_acopio,t3.cod_estiba,t3.tipo_embarque,t3.cod_nave,t3.cod_cliente,t3.cod_sub_cliente,t1.num_guia,t3.cod_producto,t3.cod_subproducto,t3.cod_cliente,";
									$Consulta.="t1.peso_bruto,t1.rut_chofer,t4.nombre_persona as nombre_chofer,t5.descripcion as marca,t3.rut_cliente from sec_web.guia_despacho_emb t1 ";
									$Consulta.="inner join sec_web.embarque_ventana t3 on t3.num_envio=t1.num_envio and t3.cod_bulto=t1.cod_bulto and t3.num_bulto=t1.num_bulto ";
									$Consulta.="left join sec_web.persona t4 on  t1.rut_chofer=t4.rut_persona ";
									$Consulta.="left join sec_web.marca_catodos t5 on t3.cod_marca=t5.cod_marca ";
									$Consulta.="where t1.num_secuencia='".$TxtCorrelativo."' and t1.num_guia='".$Datos[1]."' and t1.cod_estado <> 'A' ";
									//$Consulta.="and substring(t1.fecha_guia,1,4)=substring('".$FechaTermino."',1,4) ";
									$Consulta.="group by t3.cod_producto,t3.cod_subproducto	";
									$RespSec=mysqli_query($link, $Consulta);
									$FilaSec=mysqli_fetch_array($RespSec);
									$CmbSubProducto=$FilaSec["cod_producto"]."~".$FilaSec["cod_subproducto"];
									//SE RECUPERA EL GRUPO A PARTIR DEL PRODUCTO Y SUBPRODUCTO OBTENIDOS DEL ORIGEN
									$Consulta="SELECT distinct cod_grupo from sipa_web.grupos_prod_subprod where cod_producto='".$FilaSec["cod_producto"]."' and cod_subproducto='".$FilaSec["cod_subproducto"]."'";
									$RespGrupo=mysqli_query($link, $Consulta);
									$FilaGrupo=mysqli_fetch_array($RespGrupo);
									$CmbGrupoProd=$FilaGrupo["cod_grupo"];
									switch($FilaSec["tipo_embarque"])
									{
										case "E":
											if($FilaSec["cod_estiba"]!='')
												$CodPrestador=$FilaSec["cod_estiba"];
											else
												$CodPrestador=$FilaSec["cod_acopio"];
											$Consulta="SELECT rut from sec_web.prestador where cod_prestador_servicio='$CodPrestador'";
											$RespE=mysqli_query($link, $Consulta);
											if($FilaE=mysqli_fetch_array($RespE))
												$CmbProveedor=$FilaE["rut"];
											break;
										case "A":
											if($FilaSec["cod_acopio"]!='')
												$CodPrestador=$FilaSec["cod_acopio"];
											else
												$CodPrestador=$FilaSec["cod_estiba"];
											$Consulta="SELECT rut from sec_web.prestador where cod_prestador_servicio='$CodPrestador'";
											$RespA=mysqli_query($link, $Consulta);
											if($FilaA=mysqli_fetch_array($RespA))
												$CmbProveedor=$FilaA["rut"];
											break;
										case "T":
											if($FilaSec["cod_sub_cliente"]=='*')
											{
												$Consulta="SELECT rut from sec_web.cliente_venta where cod_cliente='".$FilaSec["cod_cliente"]."'";
												$RespC=mysqli_query($link, $Consulta);
												if($FilaC=mysqli_fetch_array($RespC))
													$CmbProveedor=$FilaC["rut"];
											}
											else
												$CmbProveedor=$FilaSec["rut_cliente"];
											break;	
										default:
											$CmbProveedor=$FilaSec["rut_cliente"];
											break;	
									}
									$TxtPesoNetoSec=0;
									$CmbTipoDespacho='V';
									$TxtMarca=$FilaSec["marca"];
									$TxtRutChofer=$FilaSec["rut_chofer"];
									$TxtNomChofer=$FilaSec["nombre_chofer"];
									$TxtCorrelativo=$TxtCorrelativo."~".$FilaSec["num_guia"]."~C";
									$Consulta = "SELECT count(*) as tot_paquetes ";
									$Consulta.= " from sec_web.paquete_catodo t2  inner join sec_web.lote_catodo t3 ";
									$Consulta.= " on t2.fecha_creacion_paquete = t3.fecha_creacion_paquete and t2.cod_paquete = t3.cod_paquete and t2.num_paquete = t3.num_paquete ";
									$Consulta.= " where  t2.num_guia = '".$Datos[1]."' ";
									$Consulta.= " group by t2.num_guia";
									
									$RespPaq=mysqli_query($link, $Consulta);
									if($FilaPaq=mysqli_fetch_array($RespPaq))
									{
										
										$TxtPesoNetoSec=abs($FilaSec["peso_bruto"]+$FilaPaq["tot_paquetes"]+$TxtPesoTara);
									}
									//$TxtPesoNetoSec=abs($FilaSec["peso_bruto"];									
									$ObjFoco='TxtObs';//TxtPesoNetoSec
									break;
								case "A"://DATOS ACIDO
								//echo "DATOS ".var_dump($Datos)."<br>";
									$TitCmbCorr="Corr  -  Guia";
									$Consulta ="SELECT t3.cod_sipa,t1.rut_transportista,t1.descripcion,t1.sellos,t1.num_guia,t1.corr_interno_cliente,t1.nro_patente,t1.rut_chofer,t2.nombre,t1.rut_cliente from pac_web.guia_despacho t1 ";
									$Consulta.="left join pac_web.choferes t2 on t1.rut_chofer=t2.rut_chofer ";									
									$Consulta.="left join pac_web.pac_productos t3 on t1.cod_producto=t3.cod_producto ";									
									$Consulta.="where t1.num_guia='".$Datos[1]."' and t1.nro_patente ='".$TxtPatente."'  order by fecha_hora desc";
									$RespPac=mysqli_query($link, $Consulta);
									$FilaPac=mysqli_fetch_array($RespPac);
									$CmbSubProducto=$FilaPac["cod_sipa"];
										
									if(strpos($FilaPac["cod_sipa"],'~'))
									{
										$CmbSubProducto=$FilaPac["cod_sipa"];
										$CodProd=$Codigos[0];
										$CodSub=$Codigos[1];
									}
									//$CmbSubProducto='46~1';
									//SE RECUPERA EL GRUPO A PARTIR DEL PRODUCTO Y SUBPRODUCTO OBTENIDOS DEL ORIGEN
									$TxtGuia=$FilaPac["num_guia"];
									if($TxtGuia=='')
										$TxtGuia='GDE';
									$Consulta="SELECT distinct cod_grupo from sipa_web.grupos_prod_subprod  where cod_producto='46' and cod_subproducto='1'";
									$RespGrupo=mysqli_query($link, $Consulta);
									$FilaGrupo=mysqli_fetch_array($RespGrupo);
									$CmbGrupoProd=$FilaGrupo["cod_grupo"];
									$CmbProveedor=$FilaPac["rut_cliente"].'~'.$FilaPac["corr_interno_cliente"];
									$CmbTipoDespacho='V';
									$TxtRutChofer=$FilaPac["rut_chofer"];
									$TxtNomChofer=$FilaPac["nombre"];
									$TxtCorrelativo=$TxtCorrelativo."~".$FilaPac["num_guia"]."~A";
									$TxtSello=isset($FilaPac["sellos"])?$FilaPac["sellos"]:"";
									$TxtObs=$FilaPac["descripcion"];
									$Class=" style='background-color:#F9F8F3'";
									$Bloqueo="disabled ";
									$BloqueoTxt="readonly ";
									$Consulta ="SELECT numtarjeta from sipa_web.datos_ejes where folio='".$Datos[0]."'";
									$RespEjes = mysqli_query($link, $Consulta);
									$FilaEjes = mysqli_fetch_array($RespEjes);
									$TxtTarjeta=$FilaEjes["numtarjeta"];
									
									$Consulta ="SELECT nombre from pac_web.transportista where rut_transportista='".$FilaPac["rut_transportista"]."'";
									$RespTransP = mysqli_query($link, $Consulta);
									$FilaTransP = mysqli_fetch_array($RespTransP);
									$TxtTransp= isset($FilaTransP["nombre"])?$FilaTransP["nombre"]:"";
									$ObjFoco='TxtObs';
									break;	
								default:
									$ObjFoco='TxtGuia';
									break;	
							}
							$HabilitarCmb='';
							$HabilitarText='readonly';
						}	
						break;
					case "B1"://LOTE NUEVO
						$AnoMes=substr(date('Y'),2,2).date('m');
						//CREAR RECARGO 1
						//$Consulta="SELECT ifnull(max(lote)+1,'".$AnoMes."5001') as lote_nuevo from sipa_web.despachos where lote like '$AnoMes%'";
						$Consulta="SELECT ifnull(max(lote)+1,'".$AnoMes."6001') as lote_nuevo from sipa_web.correlativo_lote where cod_proceso='D' and lote like '$AnoMes%'";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$TxtLote=str_pad($Fila["lote_nuevo"],8,'0',STR_PAD_LEFT);
						$TxtRecargo=1;
						$CmbLotes=$TxtLote;
						$SubProd=explode('~',$CmbSubProducto);
						$Datos=explode('~',$TxtCorrelativo);
						//SE ACTUALIZA EL CORRELATIVO CON DATOS OBTENIDOS
						CrearArchivoResp('D','S',$Datos[0],$TxtLote,$TxtRecargo,$CmbUltRecargo,$RutOperador,'',$TxtNumBascula,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$CmbProveedor,'',$CmbGrupoProd,$SubProd[0],$SubProd[1],$TxtGuia,$TxtPatente,'','',$TxtObs,$CmbTipoDespacho,'','','','');
						$Actualizar="UPDATE sipa_web.despachos set peso_bruto='".$TxtPesoBruto."',ult_registro='".$CmbUltRecargo."',recargo='".$TxtRecargo."',patente='".strtoupper(trim($TxtPatente))."',";
						$Actualizar.="cod_grupo='".$CmbGrupoProd."',cod_producto='".$SubProd[0]."',cod_subproducto='".$SubProd[1]."',rut_prv='".$CmbProveedor."',";
						$Actualizar.="hora_salida='".$TxtHoraS."',lote='".$TxtLote."',cod_despacho='".$CmbTipoDespacho."',guia_despacho='".$TxtGuia."',conjunto='',observacion='".$TxtObs."' ";
						$Actualizar.="where correlativo='".$Datos[0]."'";
						mysqli_query($link, $Actualizar);
						//echo "Actualizar ".$Actualizar."<br>";
						$Actualizar="UPDATE sipa_web.correlativo_lote set lote='$TxtLote' where cod_proceso='D'";
						mysqli_query($link, $Actualizar);
						$ObjFoco='TxtGuia';
						$EstPesoOk='checked';
						break;
					case "B2"://LOTE EXISTENTE ABIERTO
						$AnoMes=substr(date('Y'),3,1).date('m');
						//BUSCAR RECARGO NUEVO
						$Consulta="SELECT  max(lpad(recargo,2,'0'))+1 as recargo_nuevo,cod_producto,cod_subproducto,cod_despacho,rut_prv,correlativo,fecha,hora_entrada,hora_salida,conjunto ";
						$Consulta.="from sipa_web.despachos where lote = '$CmbLotes' group by lote";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$TxtLote=$CmbLotes;
						$TxtRecargo=$Fila["recargo_nuevo"];
						//BUSCAR DATOS DE RECARGO 1 QUE DEBEN SER LOS MISMOS PARA LOS DEMAS
						$Consulta="SELECT cod_producto,cod_subproducto,cod_despacho,rut_prv,correlativo,fecha,hora_entrada,hora_salida,conjunto ";
						$Consulta.="from sipa_web.despachos where lote = '$CmbLotes' and recargo='1'";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$CmbSubProducto=$Fila["cod_producto"]."~".$Fila["cod_subproducto"];
						$CmbProveedor=$Fila["rut_prv"];
						$CmbConjunto=$Fila["conjunto"];
						$CmbTipoDespacho=$Fila["cod_despacho"];
						//SE ACTUALIZA EL CORRELATIVO CON DATOS OBTENIDOS
						$SubProd=explode('~',$CmbSubProducto);
						$Datos=explode('~',$TxtCorrelativo);
						CrearArchivoResp('D','S',$Datos[0],$TxtLote,$TxtRecargo,$CmbUltRecargo,$RutOperador,'',$TxtNumBascula,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$CmbProveedor,'',$CmbGrupoProd,$SubProd[0],$SubProd[1],$TxtGuia,$TxtPatente,'','',$TxtObs,$CmbTipoDespacho,'','','','');
						$Actualizar="UPDATE sipa_web.despachos set peso_bruto='".$TxtPesoBruto."',ult_registro='".$CmbUltRecargo."',recargo='".$TxtRecargo."',patente='".strtoupper(trim($TxtPatente))."',";
						$Actualizar.="cod_grupo='".$CmbGrupoProd."',cod_producto='".$SubProd[0]."',cod_subproducto='".$SubProd[1]."',rut_prv='".$CmbProveedor."',";
						$Actualizar.="hora_salida='".$TxtHoraS."',lote='".$TxtLote."',cod_despacho='".$CmbTipoDespacho."',guia_despacho='".$TxtGuia."',conjunto='',observacion='".$TxtObs."' ";
						$Actualizar.="where correlativo='".$Datos[0]."'";
						mysqli_query($link, $Actualizar);
						$ObjFoco='TxtObs';
						$EstPesoOk='checked';
						break;	
				}	
			}
			else
				$ObjFoco='TxtPatente';				
			break;	
	}
	if($CmbSubProducto!="" && $CmbProveedor!="")
	{
		$Consulta = "SELECT leyes,impurezas from age_web.relaciones ";
		$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."' and rut_proveedor='".$CmbProveedor."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtLeyes=$Fila["leyes"];
			$TxtImpurezas=$Fila["impurezas"];
		}					
	}
	if(isset($BuscarPrv)&&$BuscarPrv=='S')
	{
		$Consulta = "SELECT * from sipa_web.proveedores where rut_prv='$CmbProveedor'";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtNombrePrv=$Fila["nombre_prv"];
			$TxtDirec=isset($Fila["direccion"])?$Fila["direccion"]:"";
			$ObjFoco='TxtObs';
		}	
		else
			$ObjFoco='TxtNombrePrv';	
	}
	if(isset($BuscarChofer)&&$BuscarChofer=='S')
	{
		$Consulta = "SELECT * from sipa_web.choferes where rut_chofer='$TxtRutChofer'";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtNomChofer=$Fila["nombre_chofer"];
			$ObjFoco='CmbCodMop';	
		}	
		else
		{	$ObjFoco='TxtNomChofer';	
			$TxtNomChofer="";
		}
	}
	
 /*   
   if(isset($DifLimitePeso)&&$DifLimitePeso!="")
    {
 	echo " *** valor de dif  " . substr ($DifLimitePeso,0,2);
	    if ($DifLimitePeso != "")
		{
			EnviaCorreo($TxtPatente,$DifLimitePeso,$TxtGuia,$TxtPesoBruto,$TxtPesoNetoSec,$CmbSubProducto,$TxtNumRomana,$RutOperador);
		}
     }
	*/
if($Bloqueo!='')									
	$Class=" style='background-color:#F9F8F3'";
if($BloqueoTxt!='')									
	$Class=" style='background-color:#F9F8F3'";	
									
								
?>	
<html><head>
<title>Despacho V20220317. GDE</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>

<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
var digitos=20 //cantidad de digitos buscados 
var puntero=0 
var buffer=new Array(digitos) //declaraci�n del array Buffer 
var cadena="" 
/*
function LeerRomana(Rom)
{
	var ubicacion = "C:\\PesaMatic\\ROMANA.txt";
	var valor="";
	var fso, f1, ts, s,retorno; 
	var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion))
	{
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
    }
	else
	{
       alert("No Existe archivo en :"+ubicacion);
	}
	return(valor); 
}
*/
//var ROMA=LeerRomana('');
//var ROMA= '<?php echo LeerArchivo('PesaMatic','ROMANA.txt'); ?>';
var ROMA = '<?php echo LeerRomana($REMOTE_ADDR,$link); ?>'; 
/*
 function LeerArchivo(valor)
{
	var ubicacion = "C:\\PesoMatic.txt";
var valor="";
	var fso, f1, ts, s,retorno; 
		var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion)){
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
        } else {
       alert("No Existe archivo en: "+ubicacion ) 
	
	   }
	  
		return(valor); 
}
*/
/*

function LeerArchivo2(valor)
{
	var ubicacion = "C:\\PesoMatic2.txt";
	var valor="";
	var fso, f1, ts, s,retorno; 
	var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion)){
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
        } else {
       alert("No Existe archivo en: "+ubicacion ) 
	
	   }
	 	return(valor); 
}
*/

function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.top = 80 ");
			eval("Txt" + numero + ".style.left = 250 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function PesoAutomatico()
{
	setTimeout("CapturaPeso()",500);
}	
/*****************/
function SeleccionRomana(tipo)
{
	var f = document.FrmDespacho;
	f.BtnPBruto.disabled=true;
	f.BtnPTara.disabled=true;
	window.open("rec_seleccion_romana.php?tipo="+tipo+"&Frm="+f.name,"","top=210,left=200,width=400,height=200,scrollbars=no,resizable=no,status=yes");
	
}
function CapturaPeso(tipo)
{
	var f = document.FrmDespacho;
	var PesoRangoIni =0;
	var PesoRangoFin =0;
	var PorcPeso =0;
	
	switch(tipo)
	{
		case "PB":
			//f.TipoProceso.value="S";
			 if(f.TxtNumBascula.value=='1')
			 	{
					//f.TxtPesoBruto.value = LeerArchivo2(f.TxtPesoBruto.value);
					//f.TxtPesoBruto.value = f.TxtPesoBruto.value;
					//f.TxtPesoBruto.value = '<?php echo LeerArchivo('','PesoMatic2.txt'); ?>';
					f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt'); ?>';
				}
				
			   else
				{
					//f.TxtPesoBruto.value = LeerArchivo(f.TxtPesoBruto.value);
					//.TxtPesoBruto.value = f.TxtPesoBruto.value;
					//f.TxtPesoBruto.value = '<?php echo LeerArchivo('','PesoMatic.txt'); ?>';
					f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
				}
		//if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
			//	f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
			// f.TxtPesoBruto.value = 44910; // yo
			RevisaPesos()
			CalculaPNeto()
			CalculaPNetoTotal()
			ValidarPesoNeto();		
			//**** mfm *** 
			
			if(f.CmbLotes.disabled==true)
				f.BtnGrabar.focus();	
			else
				f.CmbLotes.focus();	
			break;
		case "PT":
			//f.TipoProceso.value="E";
			 if(f.TxtNumBascula.value=='1'){
				//f.TxtPesoTara.value = LeerArchivo2(f.TxtPesoTara.value);
				//f.TxtPesoTara.value = '<?php echo LeerArchivo('','PesoMatic2.txt'); ?>';
				f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt'); ?>';
			 }else{
				//f.TxtPesoTara.value = LeerArchivo(f.TxtPesoTara.value);
				//f.TxtPesoTara.value = '<?php echo LeerArchivo('','PesoMatic.txt'); ?>';
				f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
			 }
			//f.TxtPesoTara.value = 13400;
			if(parseInt(f.TxtPesoHistorico.value)!=0)
			{	
				PorcPeso=parseInt((f.TxtPorcRango.value*f.TxtPesoHistorico.value)/100);
				//alert(PorcPeso);
				PesoRangoIni=parseInt(parseInt(f.TxtPesoHistorico.value)-PorcPeso);
				PesoRangoFin=parseInt(parseInt(f.TxtPesoHistorico.value)+PorcPeso);
				//alert('Rangos Taras:'+PesoRangoIni+' '+PesoRangoFin);
				if((parseInt(f.TxtPesoTara.value)<PesoRangoIni)||(parseInt(f.TxtPesoTara.value)>PesoRangoFin))			
				{
					alert('ATENCION!!!! Peso Tara no esta dentro del Rango de Peso Tara Historico');
				}
			}	
			//if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
			//	f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
			CalculaPNetoTotal()
			f.BtnGrabar.focus();	
			break;
	}	
	//setTimeout("CapturaPeso()",200);
	f.TxtPatente.disabled='';
	//f.TxtPatente.focus();
		
}

function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmDespacho;
   var letra = String.fromCharCode(event.keyCode) 
   if(puntero >= digitos){ 
       cadena=""; 
       puntero=0; 
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto... 
   if (event.keyCode == 13||event.keyCode == 27)
   { 
       borrar_buffer(); 
       if(event.keyCode != 27&&objfoco!=0) //evita foco a otro objeto si objfoco=0 
		if(Recargar=='S')
			Recarga(objfoco);	   
		else
		   objfoco.focus(); 
    } 
   //sino busco la cadena tipeada dentro del combo... 
   else{ 
       buffer[puntero]=letra; 
       //guardo en la posicion puntero la letra tipeada 
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array 
       puntero++; 

       //barro todas las opciones que contiene el combo y las comparo la cadena... 
       for (var opcombo=0;opcombo < obj.length;opcombo++){ 
          if(obj[opcombo].text.substr(InicioBusq,puntero).toLowerCase()==cadena.toLowerCase()){ 
          obj.SelectedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter 

} 
function RevisaPesos()
{	var f = document.FrmDespacho;

	
	if (f.TxtPesoBruto.value > 0 && f.TotPesEjes.value > 0)
	{
		var Dif=0;
		var ValorPorc = 0;
		var PEjes = f.TotPesEjes.value;
		var PBasc = f.TxtPesoBruto.value;
		var PesoB = 0;
		Dif=parseInt(f.TxtPesoBruto.value)-parseInt(f.TotPesEjes.value);
		if(!(isNaN(Dif)))
		{		
			ValorPorc = parseInt((Dif / f.TxtPesoBruto.value) * 10000);
			ValorPorc = (ValorPorc / 100);
			if(ValorPorc > 3 || ValorPorc < -3)
			{
				if(confirm("Tolerancia = " + ValorPorc +" %  mayor que  Rango Permitido, (+ - 3%), Desea Continuar" ))
				{
					PesoB = f.TxtPesoBruto.value;
				}
				else
				{
					f.TxtPesoBruto.value = 0;
					f.action = "rec_despacho.php?LimpiaPag=S&TxtNumBascula="+f.TxtNumBascula.value;
					f.submit();		
				}	
			}
		}
	}

}
function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
function Proceso(opt,ObjFoco,opt2)
{
	var f = document.FrmDespacho;
	var Valores='';
	
	switch (opt)
	{
		case "G"://ACTUALIZAR DESPACHOS
			if(ValidarCampos())
			{
				f.BtnGrabar.disabled=true;
				f.action = "rec_despacho01.php?Proceso="+f.TipoProceso.value;
				f.submit();	
			}
			break;
		case "B"://BUSCA LOTE NUEVO O LOTE EXISTENTE
			if(f.TxtLote.value==''&&f.TxtRecargo.value=='')
			{
				if(ValidarCampos())
				{				
					if(f.CmbLotes.value=='-1')//ES LOTE NUEVO
						f.action = "rec_despacho.php?Proceso=B1";
					else
						f.action = "rec_despacho.php?Proceso=B2";//LOTE INGRESADO
					f.submit();	
				}else{
					f.CmbLotes.value='S';
					f.TxtLote.value='';
					f.TxtRecargo.value='';
				}	
			}	
			break;
		case "BC":
			if(f.TxtCorrelativo.value!='S')
			{
				f.action = "rec_despacho.php?Proceso=BC&ObjFoco="+ObjFoco.name;//BUSCAR CORRELATIVO
				f.submit();	
			}	
			break;	
		case "I"://IMPRIMIR
			if(f.TxtLote.value=='')
			{
				alert('No hay Correlativo para Modificar');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_despacho01.php?Proceso=I";
				f.submit();	
			}					
			break;	
		case "S"://SALIR
			FrmDespacho.action = "../principal/sistemas_usuario.php?CodSistema=24";
			FrmDespacho.submit();
			break;
		case "C"://CANCELAR
			f.action = "rec_despacho01.php?Proceso=C";
			f.submit();	
			break;
		case "M"://MODIFICAR
			f.TipoProceso.value="S";
			if(f.TxtLote.value=='')
			{
				alert('No hay Correlativo para Modificar');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_despacho01.php?Proceso=M";
				f.submit();	
			}	
			break;
		case "A"://ANULAR
		
		
			if(f.TxtCorrelativo.value=='S')
			{
				alert('No hay Correlativo para Anular');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				if(confirm("¿Esta seguro que desea anular el registro correlativo "+f.TxtCorrelativo.value+"?"))
				{
				f.action = "rec_despacho01.php?Proceso=A";
				f.submit();	
				}
				
			}	
			break;
	}
}
function Recarga(ObjFoco,Tipo)
{
	var f = document.FrmDespacho;
	var ProdSubProd='';
	
	if(f.TxtPatente.value==''&&Tipo=='S')
		return;
	ProdSubProd=f.CmbSubProducto.value.split('~');
	if(ProdSubProd[0]=='18' || ProdSubProd[0]=='19' || ProdSubProd[0]=='48' || (ProdSubProd[0]=='64' && ProdSubProd[1]=='6'))
		f.action = "rec_despacho.php?ObjFoco=TxtPesoNetoSec";
	else
		f.action = "rec_despacho.php?ObjFoco="+ObjFoco.name;
	f.submit();		
}
function ValidarCampos()
{
	var f = document.FrmDespacho;
	var Validado=true;
	
	if(f.TxtCorrelativo.value==''||f.TxtCorrelativo.value=='S')
	{
		alert('No hay Correlativo para Grabar');
		f.TxtCorrelativo.focus();
		Validado=false;
		return;
	}
	if(f.TxtGuia.value==''&&f.TipoProceso.value=='S')
	{
		alert('Debe Ingresar Guia de Despacho');
		f.TxtGuia.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.CmbGrupoProd.value=='S')
	{
		alert('Debe Seleccionar el Producto');
		f.CmbGrupoProd.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.CmbSubProducto.value=='S')
	{
		alert('Debe Seleccionar el SubProducto');
		f.CmbSubProducto.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && (f.CmbProveedor.value=='S'||f.CmbProveedor.value==''))
	{
		alert('Debe Seleccionar Proveedor');
		f.CmbProveedor.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.CmbTipoDespacho.value=='S')
	{
		alert('Debe Seleccionar el Tipo Despacho');
		f.CmbTipoDespacho.focus();
		Validado=false;
		return;
	}
	if(f.TxtPatente.value=='')
	{
		alert('Debe Ingresar Patente');
		f.TxtPatente.focus();
		Validado=false;
		return;
	}
	
	if(f.TipoProceso.value=='S' && f.TxtPesoBruto.value=='')
	{
		alert('Debe Ingresar Peso Bruto');
		f.BtnPBruto.focus();
		f.CmbLotes.SELECTedIndex=0; 
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && (f.TxtPesoNeto.value==''||f.TxtPesoNeto.value=='0'))
	{
		alert('Peso Neto Invalido');
		f.BtnPBruto.focus();
		f.CmbLotes.SELECTedIndex=0; 
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && (f.CmbProveedor.value=='S'||f.CmbProveedor.value==''))
	{
		alert('Debe Seleccionar Proveedor');
		f.CmbProveedor.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.CmbLotes.value=='S')
	{
		alert('Debe Seleccionar Lote');
		f.CmbLotes.focus();
		Validado=false;
		return;
	}
	

	if(f.TipoProceso.value=='S' && f.TxtRutChofer.value=='')
	{
		alert('Debe Ingresar rut chofer ');
		f.TxtRutChofer.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.TxtNomChofer.value=='')
	{
		alert('Debe Ingresar nombre chofer ');
		f.TxtNomChofer.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='E' && (f.TxtPesoTara.value=='' || f.TxtPesoTara.value== '0') )
	{
		alert('El Peso Tara no puede quedar vacio o en 0');
		f.BtnGrabar.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='E' && f.CmbCodMop.value=='S')
	{
		alert('Debe Ingresar Codigo MOP');
		f.CmbCodMop.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='E' && f.TxtTarjeta.value=='')
	{
		alert('Debe Ingresar Tarjeta Pesaje Dinamico');
		f.TxtTarjeta.focus();
		Validado=false;
		return;
	}

	if(f.TipoProceso.value=='E' && f.TxtRutChofer.value=='')
	{
		alert('Debe Ingresar Rut Chofer');
		f.TxtRutChofer.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='E' && f.TxtNomChofer.value=='')
	{
		alert('Debe Ingresar nombre chofer ');
		f.TxtNomChofer.focus();
		Validado=false;
		return;
	}
	
	return(Validado);
}
function MM_jumpMenu(targ,selObj,restore)
{ //v3.0
  eval(targ+".location='"+selObj.options[selObj.SELECTedIndex].value+"'");
  if (restore) selObj.SELECTedIndex=0;
}
function BuscarProveedor()
{
	var f = document.FrmDespacho;
	
	if(f.CmbProveedor.value!='S'&&f.CmbProveedor.value!='')
	{
		f.action = "rec_despacho.php?BuscarPrv=S";
		f.submit();		
	}	
}
function BuscarChofer()
{
	var f = document.FrmDespacho;
	
	if(f.TxtRutChofer.value!='')
	{
		f.action = "rec_despacho.php?BuscarChofer=S";
		f.submit();		
	}	
}
function ValidarPesoNeto()
{
	var f = document.FrmDespacho;
	var Dif=0;
	f.DifLimitePeso.value='';
	if(f.TxtPesoBruto.value==''&&f.TxtPesoNetoSec.value=='')
		return;
	f.TxtPesoNetoSec.readOnly=true;	
	if(f.PesoNetoSec.value=='S'&&(f.TxtPesoNetoSec.value<0||f.TxtPesoNetoSec.value=='0'||f.TxtPesoNetoSec.value==''))
	{
		f.TxtPesoBruto.value='';
		alert('Debe Ingresar Peso Bruto Guia SEC');
		f.TxtPesoNetoSec.readOnly=false;
		f.TxtPesoNetoSec.focus();
		return;
	}
		
	//var ProdSubProd='';
	//ProdSubProd=f.CmbSubProducto.value.split('~');
	//if(ProdSubProd[0]=='18' || ProdSubProd[0]=='19' || ProdSubProd[0]=='48' || (ProdSubProd[0]=='64' && ProdSubProd[1]=='6'))
	//{
		//Dif=Math.abs(parseInt(f.TxtPesoBruto.value)-parseInt(f.TxtPesoNetoSec.value)); // ***mfm 

		Dif=parseInt(f.TxtPesoBruto.value)-parseInt(f.TxtPesoNetoSec.value);		
		if(!(isNaN(Dif)))
		{
			if ((Dif>parseInt(f.TxtLimitePeso.value)) || (Dif<(parseInt(f.TxtLimitePeso.value)*-1)))
			{
				//Dif=Math.abs(Dif-parseInt(f.TxtLimitePeso.value)) //***** mafumo
				
				if(confirm('Hay una Diferencia de Peso de '+Dif+' Kg, Desea Continuar'))
				{
					f.CmbTipoDespacho.focus();
					f.PesoOk.checked=true;
					f.DifLimitePeso.value="A~"+Dif;
					
     				//f.action = "rec_despacho.php?Proceso=BC&ObjFoco=TxtObs"
	     			f.submit();
					
				}	

				else
				{		
				f.TxtPesoBruto.value='';			
			//f.DifLimitePeso.value='C~'+Dif;
			//		Proceso('C');
				}	
			}
			else
				f.CmbTipoDespacho.focus();	
	  	}
		else
		{					
			if(f.TxtPesoBruto.value==''||f.TxtPesoBruto.value=='0')
			{
				alert('Debe Ingresar Peso Bruto');
				f.BtnPBruto.focus();
			}
		}
	//}		
}
function SeleccionBascula(NumBascula)
{
	var f = document.FrmDespacho;
	f.TxtNumBascula.value=NumBascula;
	if(f.TxtNumRomana.value=='1' && f.TxtNumBascula.value=='1')	
	{	f.TxtBasculaAux.style.background='#FF0000';
		f.TxtBasculaAux.value=1;
	}
	if(f.TxtNumRomana.value=='1' && f.TxtNumBascula.value=='2')	
	{	f.TxtBasculaAux.style.background='#009933';
		f.TxtBasculaAux.value=2;
	}
	if(f.TxtNumRomana.value=='2' && f.TxtNumBascula.value=='1')	
	{	f.TxtBasculaAux.style.background='#FF0000';
		f.TxtBasculaAux.value=3;
	}
	if(f.TxtNumRomana.value=='2' && f.TxtNumBascula.value=='2')	
	{	f.TxtBasculaAux.style.background='#009933';
		f.TxtBasculaAux.value=4;
	}
}
function CalculaPNeto()
{
	var f = document.FrmDespacho;
	if(f.TxtPesoBruto.value!=''&&f.TxtPesoTara.value!='')
		f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
	CalculaPNetoTotal();	
}
function CalculaPNetoTotal()
{
	var f = document.FrmDespacho;
	if(f.TxtPesoTotalNeto.value!=''&&f.TxtPesoNeto.value!='')
		f.TxtPNetoTot.value=parseInt(f.TxtPesoTotalNeto.value)+parseInt(f.TxtPesoNeto.value);
	else
		if(f.TxtPesoTotalNeto.value!='')
			f.TxtPNetoTot.value=parseInt(f.TxtPesoTotalNeto.value);
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo2 {color: #FF0000}
</style></head>
<body <?php echo 'onload=window.document.FrmDespacho.'.$ObjFoco.'.focus()'?>>
<form action="" method="post" name="FrmDespacho" >

<input type="hidden" name="HabilitarCmb" id="HabilitarCmb" value="<?php echo $HabilitarCmb;?>">
<input type="hidden" name="Bloqueo" id="Bloqueo" value="<?php echo $Bloqueo;?>">
<input type="hidden" name="BloqueoTxt" id="BloqueoTxt" value="<?php echo $BloqueoTxt;?>">

 <?php
	echo "<input type='hidden' name='TotPesEjes' value='$TotPesEjes'>";
	$TxtCorrel = substr($TxtCorrelativo,0,6);
	echo "<input type='hidden' name='TxtCorrel' value='$TxtCorrel'>";
	if($TipoProceso=='')
		echo "<input type='hidden' name='TipoProceso' value=''>";
	else
		echo "<input type='hidden' name='TipoProceso' value='$TipoProceso'>";
?>

<?php include("../principal/encabezado.php") ?>
<table class="TablaPrincipal" width="770" height="330" cellpadding="0" cellspacing="0" >
	<tr>
	  <td width="760" height="330" align="center" valign="top"><br>
	    <table width="720"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
	      <tr class="ColorTabla01">
    <td colspan="6"><strong>DESPACHOS:
	<?php
		if($TipoProceso!='S')
		{	//echo "ENTRADA DEL CAMION";
		$Testo="ENTRADA";
		}else
		{	//echo "SALIDA DEL CAMION";
		$Testo="SALIDA";
		}?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PESANDO EN BASCULA DE <?php echo $Testo;?> :
<input type="hidden" name="TxtNumBascula" class="InputCen" value="<?php echo $TxtNumBascula;?>" size="2" > 
<?php
switch($TxtNumRomana)
		{
			case 1:
				$BasculaA='1';
				$BasculaB='2';
			break;
			case 2:
				$BasculaA='3';
				$BasculaB='4';
			break;
			default:
					$BasculaA='S/N';
					$BasculaB='S/N';
			break;
		}	
		$Color='000000';
		//echo "TxtNumRomana :".$TxtNumRomana;
		//echo "<br>TxtNumBascula:".$TxtNumBascula;
	    if($TxtNumRomana==1 && $TxtNumBascula==1)	
		{$Valor=1;$Color='FF0000';}
		if($TxtNumRomana==1 && $TxtNumBascula==2)	
		{$Valor=2;$Color='009933';}
			if($TxtNumRomana==2 && $TxtNumBascula==1)	
		{$Valor=3;$Color='FF0000';}
			if($TxtNumRomana==2 && $TxtNumBascula==2)	
		{$Valor=4;$Color='009933';}
			
		
	?>
	<input type="text" name="TxtBasculaAux" class="InputCen" value="<?php echo $Valor;?>" size="2" readonly style="background:#<?php echo $Color;?>">	
	<?php	

	
	echo $BasculaA;?>
	<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('1')" <?php echo $EstOptBascula;?>>
	<?php echo $BasculaB;?>
	<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('2')" <?php echo $EstOptBascula2;?>>
    <input type="hidden" name="TxtNumRomana" class="InputCen" value="<?php echo $TxtNumRomana;?>" size="2" readonly >
<input name="TxtPesoHistorico" type="text" class="InputCen" value="<?php echo $TxtPesoHistorico; ?>" size="8" readonly>
<input name="TxtPorcRango" type="hidden" value="<?php echo $TxtPorcRango; ?>" size="2">
<!-- <input name="DifLimitePeso" type="text" value="<?php echo $DifLimitePeso; ?>"> -->

<input name="DifLimitePeso" type="hidden" onChange="<?php if ($DifLimitePeso != "" )
{ EnviaCorreo($TxtPatente,$DifLimitePeso,$TxtGuia,$TxtPesoBruto,$TxtPesoNetoSec,$CmbSubProducto,$TxtNumBascula,$RutOperador); ?>" value="<?php echo $DifLimitePeso;} ?>">

</strong></td>
  </tr>
  <tr>
    <td width="91" align="right" class="ColorTabla02">Patente:</td>
    <td width="156" class="ColorTabla02" >
	<input name="TxtPatente" type="text" class="InputCen" id="TxtPatente" value="<?php echo strtoupper($TxtPatente); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtCorrelativo');" onBlur="Recarga('TxtCorrelativo','S')" <?php echo $EstPatente;?>>    
    <td width="91" align="right" class="ColorTabla02">Fecha:</td>
    <td width="106" class="ColorTabla02" ><input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="12" maxlength="10" readonly ></td>
    <td width="111" align="right" class="ColorTabla02">Peso Bruto :
	</td>	
    <td width="111" class="ColorTabla02">
	<input name="TxtPesoBruto" id="TxtPesoBruto" type="text" class="InputCen" value="<?php echo $TxtPesoBruto; ?>" size="10" maxlength="10" onBlur="CalculaPNeto()" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Correlativo:</td>
	<td class="ColorTabla02">
	<?php
	if($TipoProceso=='' || $TipoProceso=='E')
	{
	?>
	  <input <?php echo $EstadoInput; ?> name="TxtCorrelativo" type="text" class="InputCen" id="TxtCorrelativo" value="<?php echo $TxtCorrelativo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>      
    <?php
	}
	else
	{
	?>
    <SELECT name="TxtCorrelativo" onChange="Proceso('BC',TxtObs)" onkeypress="buscar_op(this,TxtCorrelativo,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" >
    <option value="S" Selected class="NoSelec"><?php echo $TitCmbCorr;?></option>
    <?php
		$AnoMes=substr(date('Y'),2,2).date('m');
		$OrigenGuia='';
		//GUIA DE DESPACHOS DE SISTEMA DE CATODOS
		$FechaGuia=date('Y-m-d');
		//$Consulta ="SELECT t1.correlativo,t2.num_guia,max(t2.hora_guia) from sipa_web.despachos t1 ";
		$Consulta ="SELECT t1.correlativo,max(t2.num_guia) as num_guia from sipa_web.despachos t1 ";
		$Consulta.="inner join sec_web.guia_despacho_emb t2 on t1.correlativo= t2.num_secuencia and trim(t1.patente)=trim(t2.patente_guia) ";
		$Consulta.="where t1.patente='".strtoupper(trim($TxtPatente))."' and t1.peso_neto=0 and t1.estado<>'A' and t2.cod_estado<>'A' ";
		$Consulta.="group by correlativo order by t1.correlativo desc ";
		//$Consulta.="group by patente order by t1.correlativo desc ";
		$RespCorr=mysqli_query($link, $Consulta);
		while($FilaCorr=mysqli_fetch_array($RespCorr))
		{
			$OrigenGuia='C';
			$Datos=explode('~',$TxtCorrelativo);
			if($Datos[0]==$FilaCorr["correlativo"]&&$Datos[1]==$FilaCorr["num_guia"]&&$Datos[2]=='C')
				echo "<option value='".$FilaCorr["correlativo"]."~".$FilaCorr["num_guia"]."~C' SELECTed>".str_pad($FilaCorr["correlativo"],6,0,STR_PAD_LEFT)." - ".str_pad($FilaCorr["num_guia"],6,0,STR_PAD_LEFT)."</option>";
			else
				echo "<option value='".$FilaCorr["correlativo"]."~".$FilaCorr["num_guia"]."~C'>".str_pad($FilaCorr["correlativo"],6,0,STR_PAD_LEFT)." - ".str_pad($FilaCorr["num_guia"],6,0,STR_PAD_LEFT)."</option>";			
		}
		//GUIA DE DESPACHOS DE SISTEMA DE ACIDO
		$Consulta2 ="SELECT t1.correlativo,t2.num_guia,t2.fecha_hora from sipa_web.despachos t1 ";
		$Consulta2.="inner join pac_web.guia_despacho t2 on t1.patente=t2.nro_patente and t1.correlativo=t2.corr_romana ";
		$Consulta2.="where t1.patente='".strtoupper($TxtPatente)."' and t1.peso_neto=0 and t1.estado<>'A' ";
		$Consulta2.="and substring(t1.fecha,1,10)=substring(t2.fecha_hora,1,10) group by t1.correlativo order by t1.correlativo desc ";
		$RespCorr=mysqli_query($link, $Consulta2);
		//$OrigenGuia='';
		while($FilaCorr=mysqli_fetch_array($RespCorr))
		{
			$OrigenGuia='A';
			$Datos=explode('~',$TxtCorrelativo);
			if($Datos[0]==$FilaCorr["correlativo"]&&$Datos[1]==$FilaCorr["num_guia"]&&$Datos[2]=='A')
				echo "<option value='".$FilaCorr["correlativo"]."~".$FilaCorr["num_guia"]."~A' SELECTed>".str_pad($FilaCorr["correlativo"],6,0,STR_PAD_LEFT)." - ".str_pad($FilaCorr["num_guia"],6,0,STR_PAD_LEFT)."</option>";
			else
				echo "<option value='".$FilaCorr["correlativo"]."~".$FilaCorr["num_guia"]."~A'>".str_pad($FilaCorr["correlativo"],6,0,STR_PAD_LEFT)." - ".str_pad($FilaCorr["num_guia"],6,0,STR_PAD_LEFT)."</option>";			
		}
		if($OrigenGuia=='')
		{
			$Consulta3 ="SELECT correlativo,fecha from sipa_web.despachos ";
			//$Consulta3.="inner join pac_web.guia_despacho t2 on t1.patente=t2.nro_patente and t1.correlativo=t2.corr_romana ";
			$Consulta3.="where patente='".strtoupper($TxtPatente)."' and peso_neto=0 and estado<>'A' order by correlativo desc";
			$RespCorr=mysqli_query($link, $Consulta3);
			while($FilaCorr=mysqli_fetch_array($RespCorr))
			{
				echo "Correlativo:".$TxtCorrelativo;
				$Datos=explode('~',$TxtCorrelativo);
				//if($Datos[0]==$FilaCorr["correlativo"]&&$Datos[1]==$FilaCorr["num_guia"])
				if($Datos[0]==$FilaCorr["correlativo"])
					echo "<option value='".$FilaCorr["correlativo"]."' SELECTed>".str_pad($FilaCorr["correlativo"],6,0,STR_PAD_LEFT)." | ".$FilaCorr["fecha"]."</option>";
				else
					echo "<option value='".$FilaCorr["correlativo"]."'>".str_pad($FilaCorr["correlativo"],6,0,STR_PAD_LEFT)." | ".$FilaCorr["fecha"]."</option>";			
			}
		
		}
		$OrigenDatosGuia=$OrigenGuia;
				
	?></SELECT>
	<?php
		}
	?>
	</td>
	<td align="right" class="ColorTabla02">Hora Entrada:</td>
    <td class="ColorTabla02"><input name="TxtHoraE" type="text" class="InputCen" value="<?php echo $TxtHoraE; ?>" size="10" maxlength="10" readonly ></td>
    <td align="right" class="ColorTabla02">Peso Tara :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoTara" type="text" class="InputCen" id="TxtPesoTara" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10" onBlur="CalculaPNeto()" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Guia&nbsp;Despacho :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtGuia" type="text" class="InputCen" <?php echo $BloqueoTxt.$Class; ?> id="TxtGuia" value="<?php echo $TxtGuia; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'TxtGuia2');">
      <input <?php echo $EstadoInput; ?> name="TxtGuia2" type="text" class="Ghost" size='1' onKeypress="TeclaPulsada2('S',true,this.form,'CmbGrupoProd');" readonly></td>
    <td align="right" class="ColorTabla02">Hora Salida:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtHoraS" type="text" class="InputCen" id="TxtHoraS2" value="<?php echo $TxtHoraS; ?>" size="10" maxlength="10" readonly></td>
    <td align="right" class="ColorTabla02">Peso Neto:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoNeto" type="text" class="InputCen" id="TxtNeto" value="<?php echo $TxtPesoNeto; ?>" size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Producto: </td>
    <td colspan="5" class="ColorTabla02">
    <?php
	if($Bloqueo!='')
	{
		$Consulta = "SELECT * from sipa_web.grupos_productos  where cod_grupo='".$CmbGrupoProd."' order by descripcion_grupo ";
	$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
		?><input  type="text"  class="InputIzq" <?php echo $BloqueoTxt.$Class;?> name="nn" value="<?php echo strtoupper($Fila["descripcion_grupo"]); ?>"> <?php
		}
		?>
		<input type="hidden" name="CmbGrupoProd" value="<?php echo $CmbGrupoProd; ?>"> 
		
		<?php
	}
	else
	{
	 ?>
    <SELECT name="CmbGrupoProd" style="width:150" <?php echo $Bloqueo.$Class;?> onChange="Recarga(CmbSubProducto)" onkeypress="buscar_op(this,CmbSubProducto,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb; ?>>
      <option value="S" SELECTed class="NoSelec">Seleccionar</option>
      <?php
				$Consulta = "SELECT * from sipa_web.grupos_productos order by descripcion_grupo ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbGrupoProd == $Fila["cod_grupo"])
					{	
						echo "<option SELECTed value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
					}	
					else
						echo "<option value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
				}
			  ?>
    </SELECT>
    <?php 
	}
	?>
    </td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">SubProducto: </td>
    <td colspan="5" class="ColorTabla02">
	
    <?php
	if($Bloqueo!='')
	{
		$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
		$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
		$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
		$Consulta.="where t1.cod_grupo='".$CmbGrupoProd."' order by nom_subprod";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
			{?><input  size="60" type="text"  class="InputIzq" <?php echo $BloqueoTxt.$Class;?> name="nnn" value="<?php echo str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"]); ?>"> <?php
			break;
			}
		}
		
		?>
		<input type="hidden" name="CmbSubProducto" value="<?php echo $CmbSubProducto; ?>"> 
		
		<?php
	}
	else
	{
	 ?>
    <SELECT name="CmbSubProducto" style="width:300" onChange="Recarga(CmbProveedor)" onkeypress="buscar_op(this,CmbProveedor,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?>>
      <option value="S" SELECTed class="NoSelec">Seleccionar</option>
      <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='".$CmbGrupoProd."' order by nom_subprod";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
						echo "<option SELECTed value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
					else
						echo "<option value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
				}
			  ?>
    </SELECT>
	<?php
	
	}
	if($TipoProceso=='S'&&$CmbSubProducto!='S')
	{
		$ProdSubProd=explode('~',$CmbSubProducto);
		$Consulta="SELECT valor_subclase1 from proyecto_modernizacion.sub_clase where cod_clase='3105' and valor_subclase2='".$ProdSubProd[0]."' and valor_subclase3='".$ProdSubProd[1]."'";
		$RespSec=mysqli_query($link, $Consulta);
		if($FilaSec=mysqli_fetch_array($RespSec))
		{
			//if($OrigenDatosGuia=='')
				echo "&nbsp;Peso Bruto Sec:<input name='TxtPesoNetoSec' type='text' class='InputCen' value='".$TxtPesoNetoSec."' size='10' style='background:yellow' readonly><input name='PesoNetoSec' type='hidden' value='S' size='4'>";
			//else
			//	echo "&nbsp;Peso Bruto Sec:<input name='TxtPesoNetoSec' type='text' class='InputCen' value='".$TxtPesoNetoSec."' size='10' style='background:yellow' >";
			$LimitePeso=$FilaSec["valor_subclase1"];
			echo "&nbsp;&nbsp;Limite Peso:<input name='TxtLimitePeso' type='text' class='InputDer' value='".$LimitePeso."' style='background:yellow'  size='4' readonly>&nbsp;Kg.";
			
			echo "<input type='checkbox' name='PesoOk' $EstPesoOk disabled>";
		}
		else
			echo "<input name='TxtPesoNetoSec' type='hidden' class='InputCen' value='' size='10'><input name='PesoNetoSec' type='hidden' value='N' size='4'>";
	
			
	}
	?>
	</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Rut&nbsp;Destinatario:</td>
    <td colspan="5" class="ColorTabla02">
	  <?php
		switch($OrigenDatosGuia)
		{
			case "C":
					echo "<SELECT name='CmbProveedor' style='width:300' onkeypress=buscar_op(this,CmbTipoDespacho,0,'S') onBlur='borrar_buffer()' onclick='borrar_buffer()' $HabilitarCmb>";
					echo "<option class='NoSelec' value='S'>Seleccionar</option>";
					$Consulta = "SELECT distinct rut as rut_cliente,sigla_cliente from sec_web.cliente_venta ";
					$Consulta.= "where rut not in ('.') and length(rut) <=10 and not isnull(sigla_cliente) and sigla_cliente not in ('','0') order by sigla_cliente";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						$pos = strpos($Fila["rut_cliente"],'-');
						if ($pos === false)
							echo "EN CASO QUE RUT NO CONTENGA GUION O SE RUT MAL INGRESADO";
						else
							if (strtoupper($CmbProveedor) == strtoupper($Fila["rut_cliente"]))
								echo "<option SELECTed value='".$Fila["rut_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["sigla_cliente"]."</option>\n";
							else
								echo "<option value='".$Fila["rut_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["sigla_cliente"]."</option>\n";
					}
					
						echo "<option value='S'>&nbsp;</option>";
						echo "<option value='S'>------NACIONALES-------</option>";
						$Consulta = "SELECT distinct t2.rut_cliente,nombre_nave as sigla_cliente from sec_web.nave t1 inner join sec_web.sub_cliente_vta t2 on t1.cod_nave=t2.cod_cliente where rut_cliente <>'' group by rut_cliente";
						$Resp = mysqli_query($link, $Consulta);
						while ($Fila = mysqli_fetch_array($Resp))
						{
							$pos = strpos($Fila["rut_cliente"],'-');
							if ($pos === false)
								echo "EN CASO QUE RUT NO CONTENGA GUION O SE RUT MAL INGRESADO";
							else
								if (strtoupper($CmbProveedor) == strtoupper($Fila["rut_cliente"]))
									echo "<option SELECTed value='".$Fila["rut_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["sigla_cliente"]."</option>\n";
								else
									echo "<option value='".$Fila["rut_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["sigla_cliente"]."</option>\n";
						}
						echo "<option value='S'>&nbsp;</option>";
						echo "<option value='S'>------PRESTADOR-------</option>";
						echo "<option value='S'>&nbsp;</option>";
						if(isset($CodPrestador))
							$Consulta = "SELECT rut as rut_cliente,sigla as sigla_cliente from sec_web.prestador where cod_prestador_servicio='$CodPrestador' and rut='$CmbProveedor' ";
						else
							$Consulta = "SELECT rut as rut_cliente,sigla as sigla_cliente from sec_web.prestador order by sigla";
						$Resp = mysqli_query($link, $Consulta);
						while ($Fila = mysqli_fetch_array($Resp))
						{
							if (strtoupper($CmbProveedor) == strtoupper($Fila["rut_cliente"]))
								echo "<option SELECTed value='".$Fila["rut_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["sigla_cliente"]."</option>\n";
							else
								echo "<option value='".$Fila["rut_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["sigla_cliente"]."</option>\n";
						}
						echo " </SELECT>";//$Consulta;
				$EstadoInputChofer='readonly';
				break;
			case "A":
			
			
					if($Bloqueo!='')
					{
						
						$Consulta = "SELECT distinct rut_cliente,indicador_traslado,corr_interno_cliente,nombre from pac_web.clientes order by nombre";
								$Resp = mysqli_query($link, $Consulta);
								while ($Fila = mysqli_fetch_array($Resp))
								{
									if (strtoupper($CmbProveedor) == strtoupper($Fila["rut_cliente"].'~'.$Fila["corr_interno_cliente"]))
									{
										$TipoDespacho=$Fila["indicador_traslado"];
										?><input  size="60" type="text"  class="InputIzq" <?php echo $BloqueoTxt.$Class;?> name="nnnn" value="<?php echo str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre"]; ?>"> <?php 
										break;
									}     
								}
								
								switch($TipoDespacho)
								{
									case '1':
										$CmbTipoDespacho='V';
									break;
									case '5':
										$CmbTipoDespacho='F';
									break;
									default:
										$CmbTipoDespacho='T';
									break;
									}
								
						?><input type="hidden" name="CmbProveedor" value="<?php echo $CmbProveedor; ?>"><?php
					}
					else
					{
							
							
							
								echo "<SELECT name='CmbProveedor' style='width:300' onkeypress=buscar_op(this,CmbTipoDespacho,11,'S') onBlur='borrar_buffer()' onclick='borrar_buffer()' $Bloqueo $HabilitarCmb>";
								echo "<option class='NoSelec' value='S'>Seleccionar</option>";
								$Consulta = "SELECT distinct rut_cliente,corr_interno_cliente,nombre from pac_web.clientes order by nombre";
								$Resp = mysqli_query($link, $Consulta);
								while ($Fila = mysqli_fetch_array($Resp))
								{
									$pos = strpos($Fila["rut_cliente"],'-');
									if ($pos === false)
										echo "EN CASO QUE RUT NO CONTENGA GUION O SE RUT MAL INGRESADO";
									else
										if (strtoupper($CmbProveedor) == strtoupper($Fila["rut_cliente"].'~'.$Fila["corr_interno_cliente"]))
											echo "<option SELECTed value='".$Fila["rut_cliente"].'~'.$Fila["corr_interno_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre"]."</option>\n";
										else
											echo "<option value='".$Fila["rut_cliente"].'~'.$Fila["corr_interno_cliente"]."'>".str_pad($Fila["rut_cliente"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre"]."</option>\n";
								}
								echo " </SELECT>";
								$EstadoInputChofer='readonly';
					}
				break;	
			default:
			   if($TipoProceso=='S')
			   {
				 if($CmbProveedor=='S')
				 	$CmbProveedor='';
				 echo "<input name='CmbProveedor' type='textbox' class='InputIzq' value='$CmbProveedor' size='14' maxlength='10' onKeyDown=\"TeclaPulsada2('N',true,this.form,'TxtNombrePrv');\" onblur='BuscarProveedor()'>&nbsp;"; 
				 echo "<input name='TxtNombrePrv' type='textbox' class='InputIzq' value='$TxtNombrePrv' size='40' maxlength='25' onKeyDown=\"TeclaPulsada2('N',true,this.form,'CmbTipoDespacho');\">";
				 if($CmbSubProducto!='S')
				 {
						$ProdSubProd=explode('~',$CmbSubProducto);
						if($ProdSubProd[1]!='18')
						{
							echo "&nbsp;Direc:&nbsp;";
							echo "<input name='TxtDirec' type='text' class='InputIzq' value='$TxtDirec' size='45' onKeyDown=TeclaPulsada2('N',true,this.form,'CmbCodMop')>";
						}	
				 }
			   }
			   else
			   {
					echo "<SELECT name='CmbProveedor' style='width:300' onkeypress=buscar_op(this,CmbTipoDespacho,11,'S') onBlur='borrar_buffer()' onclick='borrar_buffer()' $HabilitarCmb>";
					echo "<option class='NoSelec' value='S'>Seleccionar</option>";
					$Consulta = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores order by nombre_prv";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if (strtoupper($CmbProveedor) == strtoupper($Fila["rut_prv"]))
							echo "<option SELECTed value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"]."</option>\n";
						else
							echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)." - ".$Fila["nombre_prv"]."</option>\n";
					}
					echo " </SELECT>";
				}
				$EstadoInputChofer='';
				break;
		}	
	  ?>
	  </td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Tipo&nbsp;Despacho:</td>
    <td class="ColorTabla02">
     <?php
	if($Bloqueo!='')
	{
		$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24000' order by nombre_subclase";
		$RespTipo=mysqli_query($link, $Consulta);
		while($FilaTipo=mysqli_fetch_array($RespTipo))
		{
			if($FilaTipo["valor_subclase1"]==$CmbTipoDespacho)
			{
			?><input  type="text"  size="50" class="InputIzq" <?php echo $BloqueoTxt.$Class;?> name="nnws" value="<?php echo $FilaTipo["nombre_subclase"]; ?>"> <?php
			break;
			}
		}
		?>
		<input type="hidden" name="CmbTipoDespacho" value="<?php echo $CmbTipoDespacho; ?>"> 
		
		<?php
	}
	else
	{
	 ?> <SELECT name="CmbTipoDespacho" style="width:160" onkeypress="buscar_op(this,CmbLotes,0,'N')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb; echo $Bloqueo;?>>
        <option SELECTed value="S">Seleccionar</option>
      <?php
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24000' order by nombre_subclase";
			$RespTipo=mysqli_query($link, $Consulta);
			while($FilaTipo=mysqli_fetch_array($RespTipo))
			{
				if($FilaTipo["valor_subclase1"]==$CmbTipoDespacho)
					echo "<option value='".$FilaTipo["valor_subclase1"]."'SELECTed>".$FilaTipo["nombre_subclase"]."</option>";
				else
					echo "<option value='".$FilaTipo["valor_subclase1"]."'>".$FilaTipo["nombre_subclase"]."</option>";
			}
		?>
      </SELECT>
      <?php
      }?>
      </td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="left" class="ColorTabla02">&nbsp;
	</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="left" class="ColorTabla02">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Lote:</td>
    <td colspan="5" class="ColorTabla02">
	  <SELECT name="CmbLotes" style="width:100" onChange="Proceso('B',TxtLote)" <?php echo $HabilitarCmb;?>>
	    <option SELECTed value="S">Seleccionar</option>
		<option value="-1">Nuevo Lote</option>
		<?php
			//if(isset($CmbLotes))
			//{
				$SubProd=explode('~',$CmbSubProducto);
				$AnoMes=substr(date('Y'),2,2).date('m');
				$Consulta = "SELECT distinct t1.lote,t1.cod_subproducto,t1.rut_prv as rutprv from sipa_web.despachos t1 where ";
				$Consulta.="cod_subproducto='".$SubProd[1]."' and rut_prv='".$CmbProveedor."' and ";
				$Consulta.=" lote like '$AnoMes%' and ult_registro <> 'S' and ";
				$Consulta.="t1.recargo=(SELECT max((t2.recargo)*1) from sipa_web.despachos t2 where t2.lote=t1.lote) group by lote";
				//echo $Consulta;
				$Resp = mysqli_query($link, $Consulta);
				while ($FilaLote = mysqli_fetch_array($Resp))
				{
					if($FilaLote["lote"]==$CmbLotes)
						echo "<option value='".$FilaLote["lote"]."'SELECTed>".$FilaLote["lote"]."</option>";
					else
						echo "<option value='".$FilaLote["lote"]."'>".$FilaLote["lote"]."</option>";
				}
						
			//}
		?>
	  </SELECT>&nbsp;&nbsp;&nbsp;	
	<input <?php echo $EstadoInput; ?> name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>      &nbsp;&nbsp;Rec.:
      <input <?php echo $EstadoInput; ?> name="TxtRecargo" type="text" class="InputCen" id="TxtRecargo" value="<?php echo $TxtRecargo; ?>" size="4" maxlength="2" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>
      &nbsp;&nbsp;Ult.Rec.:
	  <SELECT name="CmbUltRecargo" style="width:35" >
		<?php 
			switch($CmbUltRecargo)
			{
				case "N":
					echo "<option value='N'SELECTed>N</option>";
					echo "<option value='S'>S</option>";
					break;
				case "S":
					echo "<option value='N'>N</option>";
					echo "<option value='S' SELECTed>S</option>";
					break;
				default:
					echo "<option value='N'SELECTed>N</option>";
					echo "<option value='S'>S</option>";
					break;
			}
		?>
	    </SELECT>	
		</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Observacion:</td>
    <td colspan="5" class="ColorTabla02">
    <input name="TxtObs" type="text" class="InputIzq" <?php echo $BloqueoTxt.$Class;?> id="TxtObs" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtRutChofer');" value="<?php echo $TxtObs; ?>" size="100" <?php echo $EstadoInput;  ?>></td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Rut Chofer:</td>
    <td colspan="2" class="ColorTabla02">
  
    <input name="TxtRutChofer" type="text"  <?php echo $BloqueoTxt.$Class; if($BloqueoTxt==''){echo 'onBlur="BuscarChofer()"';}?> class="InputCen" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtNomChofer');" value="<?php echo $TxtRutChofer; ?>" size="14" maxlength="10" <?php echo $EstadoInputChofer;  ?> >
      <input name="TxtNomChofer" type="text" <?php echo $BloqueoTxt.$Class; ?> class="InputIzq" id="TxtNomChofer" onKeyDown="TeclaPulsada2('N',true,this.form,'');" value="<?php echo $TxtNomChofer; ?>" size="42" <?php echo $EstadoInputChofer;  ?>>
	</td>
	 <td align="right" class="ColorTabla02">Sellos</td>
     <td  colspan="2" align="left" class="ColorTabla02">
<?php
	if($TipoProceso=='S'&&$CmbSubProducto!='S')
	{
		$ProdSubProd=explode('~',$CmbSubProducto);
		// modif. 03 - 2009
		if($ProdSubProd[0]!='18' && $ProdSubProd[0]!='19' && $ProdSubProd[0]!='48' && ($ProdSubProd[0]!='64' && $ProdSubProd[1]!='6'))
			echo "&nbsp;<input name='TxtSello' size='30' type='text' class='InputIzq' ".$BloqueoTxt.$Class." value='$TxtSello' size='10' onKeyDown=TeclaPulsada2('N',true,this.form,'TxtDirec')>";
	}
	?>	
	</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Cod. Mop:</td>
    <td class="ColorTabla02">
	<?php
	if($TipoProceso=='E')
	{
		$Consulta="SELECT * from sipa_web.tarjetas_permanentes where patente='".$TxtPatente."'";
		$RespTarj=mysqli_query($link, $Consulta);
		if($FilaTarj=mysqli_fetch_array($RespTarj))
		{
			$CmbCodMop=$FilaTarj["cod_mop"];
		}
	}
	?>	
	<SELECT name="CmbCodMop" style="width:85" onkeypress=buscar_op(this,BtnGrabar,0) >
      <option value='S' SELECTed>Seleccionar</option>
      <?php
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='8004' order by nombre_subclase";
			$RespMOP=mysqli_query($link, $Consulta);
			while($FilaMop=mysqli_fetch_array($RespMOP))
			{
				if(intval($FilaMop["valor_subclase1"])==intval($CmbCodMop))
					echo "<option value='".$FilaMop["valor_subclase1"]."' SELECTed>".$FilaMop["nombre_subclase"]."</option>";
				else
					echo "<option value='".$FilaMop["valor_subclase1"]."'>".$FilaMop["nombre_subclase"]."</option>";
			}
		?>
    </SELECT></td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">Num.Tarjeta
	</td>
    <td colspan="2" align="left" class="ColorTabla02">
	<?php
	if($TipoProceso=='E')
	{
		$Consulta="SELECT * from sipa_web.tarjetas_permanentes where patente='".$TxtPatente."'";
		$RespTarj=mysqli_query($link, $Consulta);
		if($FilaTarj=mysqli_fetch_array($RespTarj))
		{
			$TxtTarjeta=$FilaTarj["tarjeta"];
		}
	}
	?>
	<input name="TxtTarjeta" type="text" size="8" class="InputIzq" onKeyDown="TeclaPulsada2('S',true,this.form,'');" value="<?php echo $TxtTarjeta; ?>" maxlength="6">
	</td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">
	<?php 
	if($TipoProceso=='S'&&$CmbSubProducto!='S')
	{
		$ProdSubProd=explode('~',$CmbSubProducto);
		if($ProdSubProd[1]=='18')
			echo "Marca:";
		else
			echo "Transportista:";
	}		
	?>
	</td>
    <td colspan="3" class="ColorTabla02">
	<?php
	if($TipoProceso=='S'&&$CmbSubProducto!='S')
	{
		$ProdSubProd=explode('~',$CmbSubProducto);
		if($ProdSubProd[0]=='18')
			echo "<input $EstadoInput name='TxtMarca' type='text' class='InputIzq' value='$TxtMarca' size='70' >";
		else
			echo "<input name='TxtTransp' type='text' class='InputIzq'  ".$BloqueoTxt.$Class." value='$TxtTransp' size='70' >";
	}		
	?>
	</td>
	<?php
		//SE CALCULA EL PESO NETO DEL LOTE
		$TotalLote=0;
		$Consulta="SELECT sum(peso_neto) as total_neto from sipa_web.despachos where lote <>'' and lote ='$TxtLote' group by lote";
		//echo $Consulta;
		$Respuesta=mysqli_query($link, $Consulta);$TxtPesoTotalNeto=0;
		if($Fila=mysqli_fetch_array($Respuesta))
			$TxtPesoTotalNeto=$Fila["total_neto"];
	?>
    <td colspan="2" align="left" class="ColorTabla02"><span class="Estilo2">TOTAL PESO LOTE:</span>
	<input type="hidden" name="TxtPesoTotalNeto" value="<?php echo $TxtPesoTotalNeto;?>">
	<input type="text" name="TxtPNetoTot" readonly value="<?php echo $TxtPNetoTot;?>" size="8" class="InputDer">
	</td>
  </tr>
	</table>
	<br>
	<table width="720" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
	  <tr bgcolor="#FFFFFF">
	        <td align="center" class="ColorTabla02"> 
              <?php  switch($TipoProceso)
			{
				case "E":
					$EstBtnPBruto='disabled';
					$EstBtnPTara='';									
					break;
				case "S":
					$EstBtnPBruto='';
					$EstBtnPTara='disabled';									
					break;
				default:	
					$EstBtnPBruto='disabled';
					$EstBtnPTara='disabled';									
					break;
			}
		?>
        <input name="BtnPBruto" type="button" id="BtnPBruto" style="width:70px " onClick="CapturaPeso('PB')" value="P.Bruto" <?php echo $EstBtnPBruto;?>>
        <input name="BtnPTara" type="button" id="BtnPTara" style="width:70px " onClick="CapturaPeso('PT')" value="P.Tara" <?php echo $EstBtnPTara;?>>
		<input name="BtnGrabar" type="button" value="Grabar" style="width:70px " onClick="Proceso('G','','<?php echo $TipoProceso;?>')" <?php echo $EstBtnGrabar;?>>
		<input name="BtnModificar" type="button" id="BtnModificar" style="width:70px " onClick="Proceso('M')" value="Modificar" <?php echo $EstBtnModificar;?>>
		<input name="BtnCancelar" type="button" id="BtnCancelar" style="width:70px " onClick="Proceso('C')" value="Cancelar">
		<input name="BtnAnular" type="button" style="width:70px " onClick="Proceso('A')" value="Anular" <?php echo $EstBtnAnular;?>>
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')" <?php echo $EstBtnImprimir;?>>
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
	</table>  
<div id='TxtRomana' style='FILTER: alpha(opacity=100);  background-color:#fff4cf; VISIBILITY: hidden; WIDTH: 200px; POSITION: absolute; moz-opacity: .75; opacity: .75; border:solid 1px Black'>
<table width="298"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla01">
    <td width="289" colspan="2"><strong>
	SELECCION ROMANA </strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td colspan="2" class="Colum01">&nbsp;</td>
    </tr>
  <tr class="ColorTabla02">
    <td align="center" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar3" value="ROMANA1" style="width:70px " onClick="Proceso('R1')">      </td>
    <td align="center" class="Colum01"><input name="BtnSalir" type="button" id="BtnSalir3" value="ROMANA2" style="width:70px " onClick="Proceso('R2')"></td>
  </tr>
  <tr class="Colum01">
    <td colspan="2" class="Colum01">&nbsp;</td>
    </tr>
  <tr class="Colum01">
    <td colspan="2" class="Colum01">&nbsp;</td>
    </tr>
  <tr align="center" class="Colum01">
    <td height="30" colspan="2" class="Colum01">&nbsp;        </td>
  </tr>
</table>
</div>
</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php

$Romana = LeerRomana($REMOTE_ADDR,$link);
echo "<br>ROMANA: ".$Romana;

if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.FrmDespacho;";
	echo "f.TxtPatente.disabled='';";
	echo "f.TxtPatente.value='';";
	echo "</script>";
	$Mensaje='';
}
/*$ProdSubProd=explode('~',$CmbSubProducto);
if($ProdSubProd[0]=='18')
{	
	echo "<script language='JavaScript'>";
	echo "var f = document.FrmDespacho;";
	echo "if(f.PesoOk.checked==false)";
	echo "{";
	echo "ValidarPesoNeto()";
	echo "}";
	//echo "f.CmbTipoDespacho.focus()";
	echo "</script>";
}*/

echo "<script language='JavaScript'>";
echo "var f = document.FrmDespacho;";
//echo "f.TxtNumRomana.value = LeerRomana(f.TxtNumRomana.value);";
//$Romana = LeerArchivo('PesaMatic','ROMANA.txt');
//echo "f.TxtNumRomana.value=".$Romana.";";
echo "f.TxtNumRomana.value=".$Romana.";";
echo "CalculaPNetoTotal();";
echo "</script>";
	
?>