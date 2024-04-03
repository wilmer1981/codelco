<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");

	$CookieRut    = $_COOKIE["CookieRut"];
	$RutOperador  = $CookieRut;
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";

	$TxtNumBascula  = isset($_REQUEST["TxtNumBascula"])?$_REQUEST["TxtNumBascula"]:"";
	$TxtBasculaAux  = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$TipoProceso    = isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:'';
	$OptBascula = isset($_REQUEST["OptBascula"])?$_REQUEST["OptBascula"]:"";
	$TxtNumRomana = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";
	$TxtPatente = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$EstPatente = isset($_REQUEST["EstPatente"])?$_REQUEST["EstPatente"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TitCmbCorr = isset($_REQUEST["TitCmbCorr"])?$_REQUEST["TitCmbCorr"]:"";
	$TxtFecha   = isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:"";
	$TxtCorrel  = isset($_REQUEST["TxtCorrel"])?$_REQUEST["TxtCorrel"]:"";
	$TitCmbCorr = isset($_REQUEST["TitCmbCorr"])?$_REQUEST["TitCmbCorr"]:"";
	$TxtPesoHistorico = isset($_REQUEST["TxtPesoHistorico"])?$_REQUEST["TxtPesoHistorico"]:"";
	$TxtPesoBruto = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoTara  = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtHoraS     = isset($_REQUEST["TxtHoraS"])?$_REQUEST["TxtHoraS"]:"";	
	$TxtHoraE     = isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:"";
	$TxtPesoNeto  = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$TxtGuia      = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$TxtConjunto  = isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$TxtNombre      = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtDescripcion = isset($_REQUEST["TxtDescripcion"])?$_REQUEST["TxtDescripcion"]:"";
	$TxtObs         = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$Valor = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";

	$Consultar   = "SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp = mysqli_query($link, $Consultar);
	if($Row=mysqli_fetch_array($Resp))
	{
		$OperSalida=strtoupper(substr($Row["nombres"],0,1)).strtoupper(substr($Row["apellido_paterno"],0,1)).strtoupper(substr($Row["apellido_materno"],0,1));		
	}

	switch($Proceso)
	{
		case "E"://ACTUALIZAR RECEPCION
			CrearArchivoResp('O','E',$TxtCorrelativo,'','','',$RutOperador,$TxtBasculaAux,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_entrada='$TxtBasculaAux',peso_bruto='".$TxtPesoBruto."',patente='".strtoupper($TxtPatente)."',nombre='".$TxtNombre."',";
			$Actualizar.="guia_despacho='".$TxtGuia."',conjunto='".$TxtConjunto."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_entrada='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
      		header('location:rec_otros_pesajes.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "S"://ACTUALIZAR SALIDA
			CrearArchivoResp('O','S',$TxtCorrelativo,'','','',$RutOperador,'',$TxtBasculaAux,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$TxtNombre,'','',$TxtDescripcion,'',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');			
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_salida='$TxtBasculaAux',peso_bruto='".$TxtPesoBruto."',peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',hora_salida='".$TxtHoraS."',";
			$Actualizar.="nombre='".$TxtNombre."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			if(trim($TxtConjunto)=='')
			{
				ImprimirOtrosPesajes($TxtCorrelativo,$TxtNumRomana,$OperSalida);
			}
			else
			{
				//AGREGA MOVIMIENTO CONJUNTO EN RAM
				$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = $TxtConjunto AND estado != 'f' order by fecha_creacion desc ";
				$rs = mysqli_query($link, $consulta);
				//echo $consulta."<br>";
				if($row = mysqli_fetch_array($rs))
				{
					$cod_conjunto = $row["cod_conjunto"];
					$cod_lugar = $row["cod_lugar"];
					$num_lugar = $row["num_lugar"];
					$CProd=$row["cod_producto"];
					$CSProd=$row["cod_subproducto"];
					if(strlen($cod_conjunto) == 1)
						$cod_conjunto = "0".$cod_conjunto;				
		
					if(strlen($cod_lugar) == 1)
						$cod_lugar = "0".$cod_lugar;				
		
					if(strlen($num_lugar) == 1)
						$num_lugar = "0".$num_lugar;				
		
					$Insertar = "INSERT INTO ram_web.movimiento_conjunto (COD_EXISTENCIA,FECHA_MOVIMIENTO,COD_CONJUNTO,NUM_CONJUNTO,COD_LUGAR_ORIGEN,
								 LUGAR_ORIGEN,COD_CONJUNTO_DESTINO,CONJUNTO_DESTINO,COD_LUGAR_DESTINO,LUGAR_DESTINO,PESO_SECO_MOVIDO,PESO_HUMEDO_MOVIDO,
								 PESO_HUMEDO_ACUMULADO,ESTADO_VALIDACION,ORIGEN)";
			
					$fecha = $TxtFecha.' '.date("H:i:s");
					$Insertar = "$Insertar VALUES('02','".$fecha."','03','$TxtConjunto','0','0','$cod_conjunto','$TxtConjunto','$cod_lugar','$num_lugar',0,$TxtPesoNeto,0,0,'A')";												  
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					$Actualizar="UPDATE sipa_web.otros_pesaje set nombre='".$CProd."',descripcion='".$CSProd."' where correlativo='".$TxtCorrelativo."'";
					mysqli_query($link, $Actualizar);
					
				}
			}
			header('location:rec_otros_pesajes.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "A"://ANULAR
			$Actualizar="UPDATE sipa_web.otros_pesaje set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
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