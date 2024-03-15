<?php
	include("../principal/conectar_principal.php");
	require "includes/class.phpmailer.php";

	$CookieRut=$_COOKIE["CookieRut"];
	$RutOperador=$CookieRut;

	//Proceso=E&TxtValores=464434&TipoRegistro=R

	$Proceso          = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TipoConsulta     = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";
	$TxtValores       = isset($_REQUEST["TxtValores"])?$_REQUEST["TxtValores"]:"";
	$TipoRegistro     = isset($_REQUEST["TipoRegistro"])?$_REQUEST["TipoRegistro"]:"";
	$TxtConjunto      = isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$CmbEstadoLote    = isset($_REQUEST["CmbEstadoLote"])?$_REQUEST["CmbEstadoLote"]:"";
	$CmbClaseProducto = isset($_REQUEST["CmbClaseProducto"])?$_REQUEST["CmbClaseProducto"]:"";
	$TxtNumRomana     = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";

	$TxtCorr 		 = isset($_REQUEST["TxtCorr"])?$_REQUEST["TxtCorr"]:"";
	$CmbTipoDespacho = isset($_REQUEST["CmbTipoDespacho"])?$_REQUEST["CmbTipoDespacho"]:"";

	$TxtLote = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$CmbGrupoProd = isset($_REQUEST["CmbGrupoProd"])?$_REQUEST["CmbGrupoProd"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$CmbMinaPlanta = isset($_REQUEST["CmbMinaPlanta"])?$_REQUEST["CmbMinaPlanta"]:"";
	$CmbClase = isset($_REQUEST["CmbClase"])?$_REQUEST["CmbClase"]:"";
	$TxtAsignacion = isset($_REQUEST["TxtAsignacion"])?$_REQUEST["TxtAsignacion"]:"";
	$TxtRecargo = isset($_REQUEST["TxtRecargo"])?$_REQUEST["TxtRecargo"]:"";
	$TxtFechaRecep = isset($_REQUEST["TxtFechaRecep"])?$_REQUEST["TxtFechaRecep"]:"";
	$TxtPatente = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtGuia = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$TxtObs = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$ChkFinLote = isset($_REQUEST["ChkFinLote"])?$_REQUEST["ChkFinLote"]:"";
	$TxtPesoBruto = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoTara = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPesoNeto = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";

	$TxtFechaIni = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:"";
	$TxtFechaFin = isset($_REQUEST["TxtFechaFin"])?$_REQUEST["TxtFechaFin"]:"";
	$LimitIni    = isset($_REQUEST["LimitIni"])?$_REQUEST["LimitIni"]:0;
	$LimitFin    = isset($_REQUEST["LimitFin"])?$_REQUEST["LimitFin"]:999;
	$TxtLoteIni = isset($_REQUEST["TxtLoteIni"])?$_REQUEST["TxtLoteIni"]:"";
	$TxtLoteFin = isset($_REQUEST["TxtLoteFin"])?$_REQUEST["TxtLoteFin"]:"";



	$Consultar="SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp=mysqli_query($link, $Consultar);
	if ($Row=mysqli_fetch_array($Resp))
	{
		$OperSalida = strtoupper(substr($Row["nombres"],0,1)).strtoupper(substr($Row["apellido_paterno"],0,1)).strtoupper(substr($Row["apellido_materno"],0,1));
	}
	switch ($Proceso)
	{
		case "M": //MODIFICA LOTE
			switch($TipoRegistro)
			{
				case "R":
					$ProdSubProd=explode('~',$CmbSubProducto);
					$MinaPlanta=explode('~',$CmbMinaPlanta);
					//AGREGA DVS LFARA 11-10-2013
					$Consulta="SELECT ult_registro,cod_producto,cod_subproducto from sipa_web.recepciones where lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
					$RespLote=mysqli_query($link, $Consulta);
					$FilaLote=mysqli_fetch_array($RespLote);
					if(trim($FilaLote["ult_registro"])!=trim($ChkFinLote))
					{
						$Consulta="SELECT cod_grupo from sipa_web.grupos_prod_subprod where cod_producto='".$FilaLote["cod_producto"]."' and cod_subproducto='".$FilaLote["cod_subproducto"]."'";
						$RespGrupo=mysqli_query($link, $Consulta);
						if($FilaGrupo=mysqli_fetch_array($RespGrupo))
						{			
							$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase ='24004' and valor_subclase1 ='".$FilaGrupo["cod_grupo"]."' and valor_subclase2='S'";
							//echo $Consulta;
							$RespGrupo=mysqli_query($link, $Consulta);
							if($FilaGrupo=mysqli_fetch_array($RespGrupo))
							{
								$Entrar='S';
								if($FilaGrupo["valor_subclase3"]!=''&&$FilaGrupo["valor_subclase3"]!='0')
								{
									$Entrar='N';
									$ArraySubprod=explode(',',$FilaGrupo["valor_subclase3"]);
									foreach($ArraySubprod as $c => $v)
									{
										if ($v==$Fila["cod_subproducto"])
										{
											$Entrar='S';
										}
									}
								}
								//echo "MODIFICA SA<br>";
								if($Entrar=='S')
									ModificacionSA($TxtLote,$TxtRecargo,$CmbProveedor,$ChkFinLote,$ProdSubProd[0],$ProdSubProd[1],$Proceso,$link);			
							}
						}
					}
					//FIN AGREGA DVS LFARA 11-10-2013	
					//echo $ProdSubProd[0];
					if($ProdSubProd[0]=='1')//CUANDO PRODUCTO SEA MINERO (1)
					{
						$Consulta="SELECT * from sipa_web.recepciones where correlativo='".$TxtCorr."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							$LoteAnt=$Fila["lote"];
							$RutPrvAnt=$Fila["rut_prv"];
							$ProductoAnt=$Fila["cod_producto"];
							$DatosAnteriores=$Fila["lote"]."~".$Fila["recargo"]."~".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["cod_grupo"]."~".$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["fecha"]."~".$Fila["cod_clase"]."~".$Fila["conjunto"]."~".$Fila["estado"]."~".$Fila["ult_registro"]."~".$Fila["patente"]."~".$Fila["guia_despacho"]."~".$Fila["peso_bruto"]."~".$Fila["peso_tara"]."~".$Fila["peso_neto"]."~".$Fila["observacion"];					
						}
						if($DatosAnteriores!='')
							$DatosAnteriores=substr($DatosAnteriores,0,strlen($DatosAnteriores)-1);
					}
					//echo "EStado:".$CmbEstadoLote."<br>";
					$Actualizar = "UPDATE sipa_web.recepciones set ";
					$Actualizar.= " lote='".trim($TxtLote)."'";
					$Actualizar.= " ,recargo='".trim($TxtRecargo)."'";
					$Actualizar.= " ,cod_producto='".$ProdSubProd[0]."'";
					$Actualizar.= " ,cod_subproducto='".$ProdSubProd[1]."'";
					$Actualizar.= " ,cod_grupo='".$CmbGrupoProd."' ";
					$Actualizar.= " ,rut_prv='".$CmbProveedor."'";
					$Actualizar.= " ,cod_mina='".$MinaPlanta[1]."'";
					$Actualizar.= " ,fecha='".$TxtFechaRecep."'";
					$Actualizar.= " ,cod_clase='".$CmbClase."'";
					$Actualizar.= " ,conjunto='".$TxtConjunto."'";
					$Actualizar.= " ,estado='".$CmbEstadoLote."'";
					$Actualizar.= " ,ult_registro='".$ChkFinLote."' ";
					$Actualizar.= " ,patente='".trim($TxtPatente)."' ";
					$Actualizar.= " ,guia_despacho='".$TxtGuia."' ";
					$Actualizar.= " ,peso_bruto='".$TxtPesoBruto."' ";
					$Actualizar.= " ,peso_tara='".$TxtPesoTara."' ";
					$Actualizar.= " ,peso_neto='".$TxtPesoNeto."' ";
					$Actualizar.= " ,observacion='".$TxtObs."' ";
					$Actualizar.= " where correlativo='".$TxtCorr."'";
					//echo $Actualizar;
					//exit();
					mysqli_query($link, $Actualizar);
					
					//BUSCO LOS DATOS YA ACTUALIZADOS
					if($ProdSubProd[0]=='1')//CUANDO PRODUCTO SEA MINERO (1)
					{
						$Consulta="SELECT * from sipa_web.recepciones where correlativo='".$TxtCorr."'";
						$Respuesta = mysqli_query($link, $Consulta);
						if ($Fila=mysqli_fetch_array($Respuesta))
						{
							$LoteAct=$Fila["lote"];
							$RutPrvAct=$Fila["rut_prv"];
							$ProductoAct=$Fila["cod_producto"];
							$DatosActualizados=$Fila["lote"]."~".$Fila["recargo"]."~".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."~".$Fila["cod_grupo"]."~".$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["fecha"]."~".$Fila["cod_clase"]."~".$Fila["conjunto"]."~".$Fila["estado"]."~".$Fila["ult_registro"]."~".$Fila["patente"]."~".$Fila["guia_despacho"]."~".$Fila["peso_bruto"]."~".$Fila["peso_tara"]."~".$Fila["peso_neto"]."~".$Fila["observacion"];					
						}
						if($DatosActualizados!='')
							$DatosActualizados=substr($DatosActualizados,0,strlen($DatosActualizados)-1);

						$DATOSANT=explode("~",$DatosAnteriores);
						$DATOSACT=explode("~",$DatosActualizados);
						$DatosMod='';//WSO
						foreach($DATOSANT as $c => $v)
						{
							if($DATOSANT[$c]!=$DATOSACT[$c])
								$DatosMod = $DatosMod.$c."~".$DATOSANT[$c]."~".$DATOSACT[$c]."//";
						}
						if($DatosMod!='')
						{
							$DatosMod=substr($DatosMod,0,strlen($DatosMod)-2);						
							FuncionEnvioCorreo($LoteAnt,$LoteAct,$DatosMod,$RutPrvAnt,$RutPrvAct,$ProductoAnt,$ProductoAct,$link);						
						}
					}	
					//rec_adm_lote02.php?TipoConsulta=CF&Proc=M&TxtCorr=464845				
				    header("location:rec_adm_lote02.php?TipoConsulta=".$TipoConsulta."&Proc=M&TxtCorr=".$TxtCorr."&TxtRecargo=".$TxtRecargo."&EstOpe=".$EstOpe."&Mensaje=".$Mensaje);
					break;
				case "D":
					$Actualizar = "UPDATE sipa_web.despachos set ";
					if(isset($TxtLote))
					{
						$ProdSubProd=explode('~',$CmbSubProducto);
						$Actualizar.= " cod_producto='".$ProdSubProd[0]."'";
						$Actualizar.= " ,cod_subproducto='".$ProdSubProd[1]."'";
						$Actualizar.= " ,rut_prv='".$CmbProveedor."'";
						$Actualizar.= " ,ult_registro='".$ChkFinLote."'";
						$Actualizar.= " ,cod_grupo='".$CmbGrupoProd."', ";
					}
					$Actualizar.= " lote='".trim($TxtLote)."'";	
					$Actualizar.= " ,recargo='".trim($TxtRecargo)."'";
					$Actualizar.= " ,fecha='".$TxtFechaRecep."'";
					$Actualizar.= " ,cod_despacho='".$CmbTipoDespacho."'";
					$Actualizar.= " ,estado='".$CmbEstadoLote."' ";
					$Actualizar.= " ,patente='".trim($TxtPatente)."' ";
					$Actualizar.= " ,guia_despacho='".$TxtGuia."' ";
					$Actualizar.= " ,peso_bruto='".$TxtPesoBruto."' ";
					$Actualizar.= " ,peso_tara='".$TxtPesoTara."' ";
					if(intval($TxtPesoNeto)==0&&intval($TxtPesoBruto)>0)
						$TxtPesoNeto=intval($TxtPesoBruto)-intval($TxtPesoTara);
					$Actualizar.= " ,peso_neto='".$TxtPesoNeto."' ";
					$Actualizar.= " ,cod_mop='".$CmbCodMop."' ";
					$Actualizar.= " ,correlativo='".$TxtCorrelativo."' ";
					$Actualizar.= " ,hora_entrada='".$TxtHoraE.":".$TxtMinE.":00'";
					$Actualizar.= " ,observacion='".$TxtObs."' ";
					$Actualizar.= " ,num_sello='".$TxtSello."' ";
					$Actualizar.= " where correlativo='".$TxtCorr."'";
					//echo $Actualizar;
					mysqli_query($link, $Actualizar);
					$Actualizar ="UPDATE sipa_web.datos_ejes set numtarjeta='$TxtTarjeta',tipo_camion='$CmbCodMop' where folio='".$TxtCorr."'";
					mysqli_query($link, $Actualizar);
					header("location:rec_adm_lote04.php?Proc=M&TxtCorr=".$TxtCorrelativo."&EstOpe=".$EstOpe."&Mensaje=".$Mensaje);				
					break;
				case "O":
					$Actualizar = "UPDATE sipa_web.otros_pesaje set ";
					$Actualizar.= " fecha='".$TxtFechaRecep."'";
					$Actualizar.= " ,conjunto='".$TxtConjunto."'";
					$Actualizar.= " ,nombre='".$TxtNombre."'";
					$Actualizar.= " ,descripcion='".$TxtDescripcion."'";
					$Actualizar.= " ,estado='".$CmbEstadoLote."' ";
					$Actualizar.= " ,patente='".trim($TxtPatente)."' ";
					$Actualizar.= " ,guia_despacho='".$TxtGuia."' ";
					$Actualizar.= " ,peso_bruto='".$TxtPesoBruto."' ";
					$Actualizar.= " ,peso_tara='".$TxtPesoTara."' ";
					$Actualizar.= " ,peso_neto='".$TxtPesoNeto."' ";
					$Actualizar.= " ,cod_mop='".$CmbCodMop."' ";
					$Actualizar.= " ,correlativo='".$TxtCorrelativo."' ";
					$Actualizar.= " ,hora_entrada='".$TxtHoraE.":".$TxtMinE.":00'";
					$Actualizar.= " ,observacion='".$Obs."'";
					$Actualizar.= " where correlativo='".$TxtCorr."'";
					//echo $Actualizar;
					mysqli_query($link, $Actualizar);
					header("location:rec_adm_lote05.php?Proc=M&TxtCorr=".$TxtCorrelativo."&EstOpe=".$EstOpe."&Mensaje=".$Mensaje);				
					break;						
			}		
			
			break;
		case "E":
			$Datos = explode("//",$TxtValores);
			//echo "ENTROOOO a ELIMINAR";
			//echo "TipoConsulta:".$TipoConsulta;
			//exit();
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("-",$v);
				$Corr = $Datos2[0];
				switch($TipoRegistro)
				{
					case "R":
						$Consulta="SELECT * from sipa_web.recepciones where correlativo='".$Corr."'";
						$RespLote=mysqli_query($link, $Consulta);
						$FilaLote=mysqli_fetch_array($RespLote);
						$SA=isset($FilaLote["sa_asignada"])?$FilaLote["sa_asignada"]:"";
						$Lote=isset($FilaLote["lote"])?$FilaLote["lote"]:"";
						$Recargo=isset($FilaLote["recargo"])?$FilaLote["recargo"]:"";
						$Producto=isset($FilaLote["cod_producto"])?$FilaLote["cod_producto"]:"";
						$SubProducto=isset($FilaLote["cod_subproducto"])?$FilaLote["cod_subproducto"]:"";
						$UltRec=isset($FilaLote["ult_registro"])?$FilaLote["ult_registro"]:"";
						if($UltRec=='S')
						{	
							EliminarSARec($SA,$Lote,0,$Producto,$SubProducto,$UltRec,$link);
							EliminarSARec($SA,$Lote,$Recargo,$Producto,$SubProducto,$UltRec,$link);
						}	
						else
							EliminarSARec($SA,$Lote,$Recargo,$Producto,$SubProducto,$UltRec,$link);
						$Eliminar = "delete from sipa_web.recepciones";
						$Eliminar.= " where correlativo='".$Corr."'";
						break;
					case "D":
						$Eliminar = "delete from sipa_web.despachos";
						$Eliminar.= " where correlativo='".$Corr."'";
						break;
					case "O":
						$Eliminar = "delete from sipa_web.otros_pesaje";
						$Eliminar.= " where correlativo='".$Corr."'";
						break;
				}		
				mysqli_query($link, $Eliminar);
				//echo $Eliminar."<br>";
			}
			echo "<script language='JavaScript'>";
			//echo "window.location='rec_adm_lote.php?CmbTipoRegistro=".$TipoRegistro."&TxtFechaIni=".$TxtFechaIni."&TxtFechaFin=".$TxtFechaFin."&TxtLoteIni=".$TxtLoteIni."&TxtLoteFin=".$TxtLoteFin."&CmbSubProducto=".$CmbSubProducto."&LimitFin=".$LimitFin."';";
			
			echo "window.location='rec_adm_lote.php?TipoCon=".$TipoConsulta."';";	

			//echo "window.opener.document.frmPrincipal.action='rec_adm_lote.php?TipoCon=".$TipoConsulta."';";
			//echo "window.opener.document.frmPrincipal.submit();";
			//echo "window.close();";
			echo "</script>";			
			break;
		case "OM": //OPERACIONES MASIVAS
			$Datos = explode("//",$TxtValores);
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("-",$v);
				switch($TipoRegistro)
				{
					case "R":
						$Actualizar="UPDATE sipa_web.recepciones set conjunto='$TxtConjunto' ";
						if($CmbEstadoLote!='S')
							$Actualizar.=" ,estado='$CmbEstadoLote' ";
						if($CmbClaseProducto!='S')
							$Actualizar.=" ,cod_clase='$CmbClaseProducto' ";
						$Actualizar.=" where correlativo='".$Datos2[0]."'";
						break;				
					case "D":
						$Actualizar="UPDATE sipa_web.despachos set conjunto='$TxtConjunto' ";
						if($CmbEstadoLote!='S')
							$Actualizar.=" ,estado='$CmbEstadoLote' ";
						if($CmbTipoDespacho!='S')
							$Actualizar.=" ,cod_clase='$CmbTipoDespacho' ";
						$Actualizar.=" where correlativo='".$Datos2[0]."'";
						break;				
				}
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}			
			echo "<script language='JavaScript'>";
			//echo "window.opener.document.frmPrincipal.action='rec_adm_lote.php';";
			echo "window.opener.document.frmPrincipal.action='rec_adm_lote.php?TipoCon=".$TipoConsulta."';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "I"://IMPRESION DE BOLETA
			include("funciones.php");
			$Datos = explode("//",$TxtValores);
			foreach($Datos as $k => $v)
			{
				$Datos2 = explode("-",$v);
				switch($TipoRegistro)
				{
					case "R":
						ImprimirRecepcion($Datos2[0],$TxtNumRomana,$OperSalidaz,$link);
						break;				
					case "D":
						ImprimirDespachos($Datos2[0],$TxtNumRomana,$OperSalida,$link);
						break;				
					case "O":
					case "C":
						ImprimirOtrosPesajes($Datos2[0],$TxtNumRomana,$OperSalida,$link);
						break;				
				}
			}
			header("location:rec_adm_lote.php?CmbTipoRegistro=".$TipoRegistro."&TxtFechaIni=".$TxtFechaIni."&TxtFechaFin=".$TxtFechaFin."&TxtLoteIni=".$TxtLoteIni."&TxtLoteFin=".$TxtLoteFin."&CmbSubProducto=".$CmbSubProducto."&LimitFin=".$LimitFin);			
			//header("location:rec_adm_lote.php?CmbTipoRegistro=".$TipoRegistro."&LimitFin=".$LimitFin."&TipoCon=CF");			
			break;	
}

function ModificacionSA($Lote,$Recargo,$Proveedor,$UltRec,$Producto,$SubProducto,$Proceso,$link)
{
	$FechaHora=date('Y-m-d H:i');
	$Consulta2 = "SELECT valor1, valor2 from proyecto_modernizacion.clase where cod_clase = '1012' ";
	$Respuesta2 = mysqli_query($link, $Consulta2);
	if ($Fila2=mysqli_fetch_array($Respuesta2))
	{
		$CC=$Fila2["valor1"];
		$Area=$Fila2["valor2"];	
	}
	
	$Consulta ="SELECT * from cal_web.solicitud_analisis where id_muestra = '".$Lote."' and cod_producto ='".$Producto."' ";
	$Consulta.="and cod_subproducto='".$SubProducto."' and tipo_solicitud = 'A' and ((nro_solicitud is not null) or (nro_solicitud <> ''))";
	//echo $Consulta."<br><BR>";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Respuesta))
	{
		$SA=$Fila["nro_solicitud"];
		$Consulta="SELECT * from sipa_web.recepciones where lote='".$Lote."' and recargo='".$Recargo."'";
		$RespLote=mysqli_query($link, $Consulta);
		$FilaLote=mysqli_fetch_array($RespLote);
		$Leyes=$FilaLote["leyes"];
		$Impurezas=$FilaLote["impurezas"];
		$RutOperador=$FilaLote["rut_operador"];
		if($UltRec=='S')
		{
			$Insertar2="INSERT INTO cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values (";
			$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','0','1','".$Fila["FECHA_HORA"]."','N','".$Fila["rut_funcionario"]."')";
			//echo $Insertar2."<br><BR>";
			mysqli_query($link, $Insertar2);
			$LeyesSA='';$LeyesImp='';					
			$CodLeyes=$Leyes."~".$Impurezas;
			$Leyes=explode('~',$CodLeyes);
			//echo $CodLeyes."<br>";
			foreach($Leyes as  $c =>$v)
			{
				$Consulta="SELECT cod_unidad from proyecto_modernizacion.leyes where cod_leyes='$v'";
				$RespUnidad=mysqli_query($link, $Consulta);
				$FilaUnidad=mysqli_fetch_array($RespUnidad);
				if($v!='01')
				{
					$Insertar2="INSERT INTO cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values (";
					$Insertar2.="'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','".$Fila["nro_solicitud"]."','0','$v','".$FilaUnidad["cod_unidad"]."','".$Producto."','$SubProducto','".$Lote."')";
					//echo $Insertar2."<br><BR>";
					mysqli_query($link, $Insertar2);
				}
				if(($v=='02')||($v=='03')||($v=='04')||($v=='05'))
					$LeyesSA=$LeyesSA.$v."~~".$FilaUnidad["cod_unidad"]."//";
				else
				{
					if($v!='01')
						$LeyesImp=$LeyesImp.$v."~~".$FilaUnidad["cod_unidad"]."//";
				}
			}
			$Insertar="INSERT INTO cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
			$Insertar.="leyes,impurezas,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,";
			$Insertar.="rut_proveedor,observacion,agrupacion,fecha_muestra) values (";
			$Insertar.= "'".$Fila["rut_funcionario"]."','".$Fila["FECHA_HORA"]."','".$Lote."','0','".$Producto."','$SubProducto','$LeyesSA','$LeyesImp','1',";			
			$Insertar.= "'3','A','".$Fila["nro_solicitud"]."','$Area','$CC','1','1','$Proveedor','','1','$FechaHora')";
			//echo $Insertar."<br><BR>";
			mysqli_query($link, $Insertar);
		}
		else
			EliminarSARec($SA,$Lote,0,$Producto,$SubProducto,$UltRec,$link);
	}
}	

function EliminarSARec($SA,$Lote,$Recargo,$Producto,$SubProducto,$UltRec,$link)
{
	$Consulta ="SELECT estado_actual from cal_web.solicitud_analisis where nro_solicitud='".$SA."' and id_muestra = '".$Lote."' and cod_producto ='".$Producto."' ";
	$Consulta.="and cod_subproducto='".$SubProducto."' and tipo_solicitud = 'A' and ((nro_solicitud is not null) or (nro_solicitud <> ''))";
	//echo $Consulta."<br><BR>";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Respuesta))
	{
		if($Fila["estado_actual"]!='5'&&$Fila["estado_actual"]!='6'&&$Fila["estado_actual"]!='32')
		{
			$Eliminar="delete from cal_web.solicitud_analisis where nro_solicitud='".$SA."' and id_muestra='".$Lote."' and recargo='".$Recargo."' and cod_producto ='".$Producto."' ";	
			$Eliminar.="and cod_subproducto='".$SubProducto."' and tipo_solicitud = 'A' and ((nro_solicitud is not null) or (nro_solicitud <> ''))";
			mysqli_query($link, $Eliminar);
			//echo $Eliminar."<br>";
			$Eliminar="delete from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and recargo='".$Recargo."'";
			mysqli_query($link, $Eliminar);
			//echo $Eliminar."<br>";
			$Eliminar="delete from cal_web.estados_por_solicitud where nro_solicitud='".$SA."' and recargo='".$Recargo."'";
			mysqli_query($link, $Eliminar);
			//echo $Eliminar."<br>";
		}
	}
}

function FuncionEnvioCorreo($LoteAnt,$LoteAct,$DatosModificados,$RutAnt,$RutAct,$ProAnt,$ProAct,$link)
{
	$ConsultaCorreo="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='8005'";
	$RespCorreo=mysqli_query($link, $ConsultaCorreo);
	if($Fila=mysqli_fetch_array($RespCorreo))
	{
		$Correos=$Fila["nombre_subclase"];
		$ArrayCorreos=explode(",",$Correos);
	}
	foreach($ArrayCorreos as $C =>$Correo2)	
	{
		$DatosMod=explode("//",$DatosModificados);
		$Asunto='Modificaci�n Datos Recepci�n Producto Minero, Lote N� '.$LoteAnt.'';
		$Titulo='Modificacion Datos Recepci�n Lote N� '.$LoteAnt.'';
		$Mensaje='<font face="Arial" size="2">Modificaci�n de Recepci�n Realizada</b><br>';
		$Mensaje.='<br>';
		$Mensaje.='Los Datos Modificados para Lote N� '.$LoteAnt.' Son:<br><br>';
		
		foreach($DatosMod as  $c =>$v)
		{
			$DatosMod1=explode("~",$v);	
			switch($DatosMod1[0])
			{
				case "0";
					$LoteAnt=$DatosMod1[1];
					$LoteAct=$DatosMod1[2];
					$Mensaje.='Lote Anterior: N� '.$LoteAnt;
					$Mensaje.='<br>';
					$Mensaje.='Lote Actual: N� '.$LoteAct;
					$Mensaje.='<br><br>';
				break;
				case "1";
					$RecargoAnt=$DatosMod1[1];
					$RecargoAct=$DatosMod1[2];
					$Mensaje.='Recargo Anterior: N� '.$RecargoAnt;
					$Mensaje.='<br>';
					$Mensaje.='Recargo Actual: N� '.$RecargoAct;
					$Mensaje.='<br><br>';
				break;
				case "2";
					$ProAnt=$DatosMod1[1];
					$ProAct=$DatosMod1[2];
					$ConsAnt="SELECT * from proyecto_modernizacion.productos where cod_producto='".$ProAnt."'";
					$RespAnt = mysqli_query($link, $ConsAnt);
					if ($FilaAnt=mysqli_fetch_array($RespAnt))
						$Mensaje.='Producto Anterior: '.$FilaAnt["descripcion"];
					$Mensaje.='<br>';
					$ConsAct="SELECT * from proyecto_modernizacion.productos where cod_producto='".$ProAct."'";
					$RespAct = mysqli_query($link, $ConsAct);
					if ($FilaAct=mysqli_fetch_array($RespAct))
						$Mensaje.='Producto Actual: '.$FilaAct["descripcion"];
					$Mensaje.='<br><br>';
				break;
				case "3";
					$ProAnt=$ProAnt;
					$ProAct=$ProAct;
					$SubProAnt=$DatosMod1[1];
					$SubProAct=$DatosMod1[2];
					$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto='".$ProAnt."' and cod_subproducto='".$SubProAnt."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Sub-Producto Anterior: '.$Fila["descripcion"];
					$Mensaje.='<br>';
					$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto='".$ProAct."' and cod_subproducto='".$SubProAct."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Sub-Producto Actual: '.$Fila["descripcion"];
					$Mensaje.='<br><br>';
				break;
				case "4";
					$GrupoAnt=$DatosMod1[1];
					$GrupoAct=$DatosMod1[2];
					$Consulta="SELECT * from sipa_web.grupos_productos where cod_grupo='".$GrupoAnt."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Grupo Anterior: '.$Fila["descripcion_grupo"];
					$Mensaje.='<br>';
					$Consulta="SELECT * from sipa_web.grupos_productos where cod_grupo='".$GrupoAct."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Grupo Actual: '.$Fila["descripcion_grupo"];
					$Mensaje.='<br><br>';
				break;
				case "5";//PROVEEDOR
					$RutPrvAnt=$DatosMod1[1];
					$RutPrvAct=$DatosMod1[2];
					$Consulta="SELECT * from sipa_web.proveedores where rut_prv='".$RutPrvAnt."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Proveedor Anterior: '.$Fila["nombre_prv"];
					$Mensaje.='<br>';
					$Consulta="SELECT * from sipa_web.proveedores where rut_prv='".$RutPrvAct."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Proveedor Actual:  '.$Fila["nombre_prv"];
					$Mensaje.='<br><br>';
				break;
				case "6";//MINA
					$RutAnt=$RutAnt;
					$RutAct=$RutAct;
					$MinaAnt=$DatosMod1[1];
					$MinaAct=$DatosMod1[2];
					$Consulta="SELECT * from sipa_web.minaprv where rut_prv='".$RutAnt."' and cod_mina='".$MinaAnt."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Mina Anterior: '.$Fila["nombre_mina"];
					$Mensaje.='<br>';
					$Consulta="SELECT * from sipa_web.minaprv where rut_prv='".$RutAct."' and cod_mina='".$MinaAct."'";
					$Resp = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Resp))
						$Mensaje.='Mina Actual: '.$Fila["nombre_mina"];
					$Mensaje.='<br><br>';
				break;
				case "7";//FECHA
					$FechaAnt=$DatosMod1[1];
					$FechaAct=$DatosMod1[2];
					$Mensaje.='Fecha Anterior: '.$FechaAnt;
					$Mensaje.='<br>';
					$Mensaje.='Fecha Actual: '.$FechaAct;
					$Mensaje.='<br><br>';
				break;
				case "8";//CLASE
					$ClaseAnt=$DatosMod1[1];
					$ClaseAct=$DatosMod1[2];
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15001' and nombre_subclase='".$ClaseAnt."' ";
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysqli_fetch_array($Resp))				
						$Mensaje.='Clase Anterior: '.$Fila["valor_subclase1"];
					$Mensaje.='<br>';
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15001' and nombre_subclase='".$ClaseAct."' ";
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysqli_fetch_array($Resp))				
						$Mensaje.='Clase Actual: '.$Fila["valor_subclase1"];
					$Mensaje.='<br><br>';
				break;
				case "9";//CONJUNTO
					$ConjAnt=$DatosMod1[1];
					$ConjAct=$DatosMod1[2];
					$Mensaje.='Conjunto Anterior: '.$ConjAnt;
					$Mensaje.='<br>';
					$Mensaje.='Conjunto Actual: '.$ConjAct;
					$Mensaje.='<br><br>';
				break;
				case "10";
					$EstaAnt=$DatosMod1[1];
					$EstaAct=$DatosMod1[2];
					$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24001' and valor_subclase1='".$EstaAnt."'";
					$Resp = mysqli_query($link, $Consulta);
					if($Fila = mysqli_fetch_array($Resp))
						$Mensaje.='Estado Anterior: '.$Fila["nombre_subclase"];
					$Mensaje.='<br>';
					$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24001' and valor_subclase1='".$EstaAct."'";
					$Resp = mysqli_query($link, $Consulta);
					if($Fila = mysqli_fetch_array($Resp))
						$Mensaje.='Estado Actual: '.$Fila["nombre_subclase"];
					$Mensaje.='<br><br>';
				break;
				case "11";
					$RegisAnt=$DatosMod1[1];
					$RegisAct=$DatosMod1[2];
					$Mensaje.='Ultimo Registro  Anterior: '.$RegisAnt;
					$Mensaje.='<br>';
					$Mensaje.='Ultimo Registro Actual: '.$RegisAct;
					$Mensaje.='<br><br>';
				break;
				case "12";
					$PatenAnt=$DatosMod1[1];
					$PatenAct=$DatosMod1[2];
					$Mensaje.='Patente Anterior: '.$PatenAnt;
					$Mensaje.='<br>';
					$Mensaje.='Patente Actual: '.$PatenAct;
					$Mensaje.='<br><br>';
				break;
				case "13";
					$GuiaAnt=$DatosMod1[1];
					$GuiaAct=$DatosMod1[2];
					$Mensaje.='Guia Despacho Anterior: '.$GuiaAnt;
					$Mensaje.='<br>';
					$Mensaje.='Guia Despacho Actual: '.$GuiaAct;
					$Mensaje.='<br><br>';
				break;
				case "14";
					$BrutoAnt=$DatosMod1[1];
					$BrutoAct=$DatosMod1[2];
					$Mensaje.='Peso Bruto Anterior: '.$BrutoAnt;
					$Mensaje.='<br>';
					$Mensaje.='Peso Bruto: '.$BrutoAct;
					$Mensaje.='<br><br>';
				break;
				case "15";
					$TaraAnt=$DatosMod1[1];
					$TaraAct=$DatosMod1[2];
					$Mensaje.='Peso Tara Anterior: '.$TaraAnt;
					$Mensaje.='<br>';
					$Mensaje.='Peso Tara Actual: '.$TaraAct;
					$Mensaje.='<br><br>';
				break;
				case "16";
					$NetoAnt=$DatosMod1[1];
					$NetoAct=$DatosMod1[2];
					$Mensaje.='Peso Neto Anterior: '.$NetoAnt;
					$Mensaje.='<br>';
					$Mensaje.='Peso Neto Actual: '.$NetoAct;
					$Mensaje.='<br><br>';
				break;
				case "17";
					$ObsAnt=$DatosMod1[1];
					$ObsAct=$DatosMod1[2];
					$Mensaje.='Observacion Anterior: '.$ObsAnt;
					$Mensaje.='<br>';
					$Mensaje.='Observacion Actual: '.$ObsAct;
					$Mensaje.='<br><br>';
				break;
			}
		}
		
		$cuerpoMsj = '<html>';
		$cuerpoMsj.= '<head>';
		$cuerpoMsj.= '<title>'.$Titulo.'</title>';
		$cuerpoMsj.= '</head>';
		$cuerpoMsj.= '<body>';
		$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
		$cuerpoMsj.= '<tr><td>';
		$cuerpoMsj.= ''.$Mensaje.'';
		$cuerpoMsj.= "<br>";
		$cuerpoMsj.="Por Su Atenci�n Muchas Gracias";
		$cuerpoMsj.= "<br>";
		$cuerpoMsj.="Servicio Automatico de Sistema de Pesaje 'SIPA'";
		$cuerpoMsj.= "<br>";
		$cuerpoMsj.= '</td></tr>';
		$cuerpoMsj.= '</table>';
		$cuerpoMsj.= '</body></html>';
		
		$mail = new phpmailer();
		//$mail->AddEmbeddedImage("includes/logo_seti.jpg","logo","includes/logo_seti.jpg","base64","image/jpg");
		$mail->PluginDir = "includes/";
		//$mail->Mailer = "smtp";
		$mail->Host = "VEFVEX03.codelco.cl";
		$mail->From = "SIPA";
		$mail->FromName = "SIPA - Sistemas Pesaje 'SIPA' ";
		$mail->Subject = $Asunto;
		$mail->Body=$cuerpoMsj;
		$mail->IsHTML(true);
		$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
		$mail->AddAddress($Correo2);
		$mail->Timeout=120;
		//$mail->AddAttachment($Doc,$Doc);
		$exito = $mail->Send();
		$intentos=1; 
		while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
		sleep(5);
		$exito = $mail->Send();
		$intentos=$intentos+1;				
		}
		$mail->ClearAddresses();
	}
}
?>
