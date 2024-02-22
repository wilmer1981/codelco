<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$RutOperador=$CookieRut;
	switch($Proceso)
	{
		case "E"://ACTUALIZAR RECEPCION
			CrearArchivoResp('O','E',$TxtCorrelativo,'','','',$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_entrada='$TxtNumBascula',peso_bruto='".$TxtPesoBruto."',patente='".strtoupper($TxtPatente)."',nombre='".$TxtNombre."',";
			$Actualizar.="guia_despacho='".$TxtGuia."',conjunto='".$TxtConjunto."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_entrada='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			header('location:rec_otros_pesajes.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "S"://ACTUALIZAR SALIDA
			CrearArchivoResp('O','S',$TxtCorrelativo,'','','',$RutOperador,'',$TxtNumBascula,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$TxtNombre,'','',$TxtDescripcion,'',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');			
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_salida='$TxtNumBascula',peso_bruto='".$TxtPesoBruto."',peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',hora_salida='".$TxtHoraS."',";
			$Actualizar.="nombre='".$TxtNombre."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			ImprimirOtrosPesajes($TxtCorrelativo,$TxtNumRomana);
			header('location:rec_otros_pesajes.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "A"://ANULAR
			$Actualizar="UPDATE sipa_web.otros_pesaje set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			header('location:rec_otros_pesajes.php?TxtNumBascula='.$TxtNumBascula);
			break;	
		case "C"://CANCELAR
			if($TipoProceso=='E')
			{
				if($TxtCorrelativo!='')
				{
					$Eliminar="delete from sipa_web.otros_pesaje where correlativo='".$TxtCorrelativo."' and patente='".trim($TxtPatente)."' and peso_bruto='0' and peso_tara='0' and peso_neto='0' ";
					mysqli_query($link, $Eliminar);			
				}	
			}
			header('location:rec_otros_pesajes.php?TxtNumBascula='.$TxtNumBascula);
			break;	
	}
?>