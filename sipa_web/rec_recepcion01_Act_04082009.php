<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$RutOperador=$CookieRut;
	switch($Proceso)
	{
		case "E"://ACTUALIZAR RECEPCION
			$Actualizar="UPDATE sipa_web.recepciones set bascula_entrada='$TxtNumBascula',peso_bruto='".$TxtPesoBruto."',ult_registro='".$CmbUltRecargo."',recargo='".$TxtRecargo."',patente='".trim($TxtPatente)."',";
			$Actualizar.="guia_despacho='".$TxtGuia."',cod_clase='".$CmbClase."',conjunto='".$CmbConjunto."',observacion='".$TxtObs."',humedad='".$TxtHumedad."', ";
			$Actualizar.="leyes='$TxtLeyes',impurezas='$TxtImpurezas',romana_entrada='$TxtNumRomana' where correlativo='".$TxtCorrelativo."' and lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			if($CmbProveedor!=''&&$TxtNombrePrv!='')
			{
				$Insertar="INSERT INTO sipa_web.proveedores(rut_prv,nombre_prv) values('".str_pad($CmbProveedor,10,"0",STR_PAD_LEFT)."','$TxtNombrePrv')";
				mysqli_query($link, $Insertar);
			}
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "S"://ACTUALIZAR SALIDA
			//$CodMina=explode('~',$CmbMinaPlanta);
			//$SuBProd=explode('~',$CmbSubProducto);
			$Datos=explode('~',$TxtCorrelativo);
			CrearArchivoResp('R','S',$Datos[2],$TxtLote,$TxtRecargo,$CmbUltRecargo,$RutOperador,'',$TxtNumBascula,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,$CmbClase,$CmbConjunto,$TxtObs,'',$TxtLeyes,$TxtImpurezas,$TxtHumedad,'');			
			$Actualizar="UPDATE sipa_web.recepciones set bascula_salida='$TxtNumBascula',ult_registro='".$CmbUltRecargo."', peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',hora_salida='".$TxtHoraS."',";
			$Actualizar.="cod_clase='".$CmbClase."',conjunto='".$CmbConjunto."',observacion='".$TxtObs."',humedad='".$TxtHumedad."', ";
			$Actualizar.="leyes='$TxtLeyes',impurezas='$TxtImpurezas',romana_salida='$TxtNumRomana' where correlativo='".$Datos[2]."' and lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			ImprimirRecepcion($Datos[2],$TxtNumRomana);
			$Consulta="SELECT rut_prv as proveedor,cod_producto,cod_subproducto from sipa_web.recepciones where correlativo='".$Datos[2]."' and lote='".$TxtLote."'";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			//CrearSA($TxtLote,$TxtRecargo,$Fila[proveedor],$CmbUltRecargo,$Fila["cod_producto"],$Fila["cod_subproducto"],$TxtLeyes,$TxtImpurezas,$RutOperador);			
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "A"://ANULAR
			$Datos=explode('~',$TxtCorrelativo);
			$Actualizar="UPDATE sipa_web.recepciones set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$Datos[2]."' and lote='".$TxtLote."'";
			mysqli_query($link, $Actualizar);
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula);
			break;	
		case "C"://CANCELAR
			$Eliminar="delete from sipa_web.recepciones ";
			$Eliminar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Eliminar);
			header('location:rec_recepcion.php?TxtNumBascula='.$TxtNumBascula);
			break;	
		case "M"://MODIFICAR
			header('location:rec_recepcion.php');
			break;	
	}
?>