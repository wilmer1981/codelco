<?php
	include("../principal/conectar_principal.php");
	include("funciones_2402.php");
	$RutOperador=$CookieRut;
	$Consultar="SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp=mysqli_query($link, $Consultar);
	if ($Row=mysqli_fetch_array($Resp))
	{
		$OperSalida=strtoupper(substr($Row["nombres"],0,1)).strtoupper(substr($Row["apellido_paterno"],0,1)).strtoupper(substr($Row["apellido_materno"],0,1));		
	}
	switch($Proceso)
	{
		case "E"://ACTUALIZAR RECEPCION
			CrearArchivoResp('O','E',$TxtCorrelativo,'','','',$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_entrada='$TxtNumBascula',peso_bruto='".$TxtPesoBruto."',patente='".strtoupper($TxtPatente)."',nombre='".$TxtNombre."',";
			$Actualizar.="guia_despacho='".$TxtGuia."',conjunto='".$TxtConjunto."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_entrada='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
      		header('location:rec_otros_pesajes_2402.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "S"://ACTUALIZAR SALIDA
			CrearArchivoResp('O','S',$TxtCorrelativo,'','','',$RutOperador,'',$TxtNumBascula,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$TxtNombre,'','',$TxtDescripcion,'',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');			
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_salida='$TxtNumBascula',peso_bruto='".$TxtPesoBruto."',peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',hora_salida='".$TxtHoraS."',";
			$Actualizar.="nombre='".$TxtNombre."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			ImprimirOtrosPesajes($TxtCorrelativo,$TxtNumRomana,$OperSalida);
			header('location:rec_otros_pesajes_2402.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "A"://ANULAR
			$Actualizar="UPDATE sipa_web.otros_pesaje set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			header('location:rec_otros_pesajes_2402.php?TxtNumBascula='.$TxtNumBascula);
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
			header('location:rec_otros_pesajes_2402.php?TxtNumBascula='.$TxtNumBascula);
			break;	
	}
?>