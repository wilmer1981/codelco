<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$CookieRut = $_COOKIE["CookieRut"];	
	$RutOperador=$CookieRut;

	$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Bloq1 = isset($_REQUEST["Bloq1"])?$_REQUEST["Bloq1"]:"";
	$Bloq2 = isset($_REQUEST["Bloq2"])?$_REQUEST["Bloq2"]:"";
	
	$TxtBasculaAux = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$TxtPesoBruto  = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$CmbUltRecargo = isset($_REQUEST["CmbUltRecargo"])?$_REQUEST["CmbUltRecargo"]:"";
	$TxtRecargo  = isset($_REQUEST["TxtRecargo"])?$_REQUEST["TxtRecargo"]:"";
	$TxtPatente  = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtGuia     = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$CmbClase    = isset($_REQUEST["CmbClase"])?$_REQUEST["CmbClase"]:"";
	$CmbConjunto = isset($_REQUEST["CmbConjunto"])?$_REQUEST["CmbConjunto"]:"";
	$TxtObs      = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$TxtHumedad  = isset($_REQUEST["TxtHumedad"])?$_REQUEST["TxtHumedad"]:"";
	$TxtLeyes    = isset($_REQUEST["TxtLeyes"])?$_REQUEST["TxtLeyes"]:"";
	$TxtImpurezas = isset($_REQUEST["TxtImpurezas"])?$_REQUEST["TxtImpurezas"]:"";
	$TxtNumRomana = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtLote        = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$CmbProveedor = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtNombrePrv = isset($_REQUEST["TxtNombrePrv"])?$_REQUEST["TxtNombrePrv"]:"";
	$TxtPesoTara  = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPesoNeto  = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$TxtHoraS = isset($_REQUEST["TxtHoraS"])?$_REQUEST["TxtHoraS"]:"";
	$TxtHoraE = isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:"";
	$TxtFecha = isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:"";

	$Consultar="SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp=mysqli_query($link, $Consultar);
	if ($Row=mysqli_fetch_array($Resp))
	{
		$OperSalida = strtoupper(substr($Row["nombres"],0,1)).strtoupper(substr($Row["apellido_paterno"],0,1)).strtoupper(substr($Row["apellido_materno"],0,1));
	}
	//echo "---".$RutOperador."---".$OperSalida;
	switch($Proceso)
	{
		case "E"://ACTUALIZAR RECEPCION
			$Actualizar="UPDATE sipa_web.recepciones set bascula_entrada='$TxtBasculaAux',peso_bruto='".$TxtPesoBruto."',ult_registro='".$CmbUltRecargo."',recargo='".$TxtRecargo."',patente='".trim($TxtPatente)."',";
			$Actualizar.="guia_despacho='".$TxtGuia."',cod_clase='".$CmbClase."',conjunto='".$CmbConjunto."',observacion='".$TxtObs."',humedad='".$TxtHumedad."', ";
			$Actualizar.="leyes='$TxtLeyes',impurezas='$TxtImpurezas',romana_entrada='$TxtNumRomana' where correlativo='".$TxtCorrelativo."' and lote='".$TxtLote."'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			if($CmbProveedor!=''&&$TxtNombrePrv!='')
			{
				$Insertar="INSERT INTO sipa_web.proveedores(rut_prv,nombre_prv) values('".str_pad($CmbProveedor,10,"0",STR_PAD_LEFT)."','$TxtNombrePrv')";
				mysqli_query($link, $Insertar);
			}
		    header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula."&Bloq1=".$Bloq1."&Bloq2=".$Bloq2);
			break;
		case "S"://ACTUALIZAR SALIDA
			//$CodMina=explode('~',$CmbMinaPlanta);
			//$SuBProd=explode('~',$CmbSubProducto);
			$Datos=explode('~',$TxtCorrelativo);
			CrearArchivoResp('R','S',$Datos[2],$TxtLote,$TxtRecargo,$CmbUltRecargo,$RutOperador,'',$TxtBasculaAux,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,$CmbClase,$CmbConjunto,$TxtObs,'',$TxtLeyes,$TxtImpurezas,$TxtHumedad,'');			
			$Actualizar="UPDATE sipa_web.recepciones set bascula_salida='$TxtBasculaAux',ult_registro='".$CmbUltRecargo."', peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',hora_salida='".$TxtHoraS."',";
			$Actualizar.="cod_clase='".$CmbClase."',conjunto='".$CmbConjunto."',observacion='".$TxtObs."',humedad='".$TxtHumedad."', ";
			$Actualizar.="leyes='$TxtLeyes',impurezas='$TxtImpurezas',romana_salida='$TxtNumRomana' where correlativo='".$Datos[2]."' and lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			ImprimirRecepcion($Datos[2],$TxtNumRomana,$OperSalida,$link);
			$Consulta="SELECT rut_prv as proveedor,cod_producto,cod_subproducto from sipa_web.recepciones where correlativo='".$Datos[2]."' and lote='".$TxtLote."'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
		
			$Consulta="SELECT cod_grupo from sipa_web.grupos_prod_subprod where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."'";
			$RespGrupo=mysqli_query($link, $Consulta);
			if($FilaGrupo=mysqli_fetch_array($RespGrupo))
			{			
				$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase ='24004' and valor_subclase1 ='".$FilaGrupo["cod_grupo"]."' and valor_subclase2='S'";
				//echo $Consulta;
				$RespGrupo=mysqli_query($link, $Consulta);
				if($FilaGrupo=mysqli_fetch_array($RespGrupo))
				{
					$Entrar='S';
					if($FilaGrupo["valor_subclase3"]!='' && $FilaGrupo["valor_subclase3"]!='0')
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
						//echo "ENTRAR ".$Entrar."<BR>";
					}
					//echo "CREA SA<br>";
					if($Entrar=='S')
						CrearSA($TxtLote,$TxtRecargo,$Fila["proveedor"],$CmbUltRecargo,$Fila["cod_producto"],$Fila["cod_subproducto"],$TxtLeyes,$TxtImpurezas,$RutOperador,$link);			
				}
			}
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula."&Bloq1=".$Bloq1."&Bloq2=".$Bloq2);
			break;
		case "A"://ANULAR
			$Datos=explode('~',$TxtCorrelativo);
			$Actualizar="UPDATE sipa_web.recepciones set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$Datos[2]."' and lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula."&Bloq1=".$Bloq1."&Bloq2=".$Bloq2);
			break;	
		case "C"://CANCELAR
			$Eliminar="delete from sipa_web.recepciones ";
			$Eliminar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Eliminar);
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula."&Bloq1=".$Bloq1."&Bloq2=".$Bloq2);
			break;	
		case "M"://MODIFICAR
			header('location:rec_recepcion.php');
			break;	
	}
?>