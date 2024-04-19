<?php
	include("../principal/conectar_principal.php");
	require "includes/class.phpmailer.php";
	include("funciones.php");
	$CookieRut   = $_COOKIE["CookieRut"];
	$RutOperador = $CookieRut;

	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TipoProceso = isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtPesoBruto = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoTara = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPesoNeto = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";

	$Productos = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:"";
	$SubProductos = isset($_REQUEST["SubProductos"])?$_REQUEST["SubProductos"]:"";
	$Conjunto = isset($_REQUEST["Conjunto"])?$_REQUEST["Conjunto"]:"";
	$TxtNumBascula = isset($_REQUEST["TxtNumBascula"])?$_REQUEST["TxtNumBascula"]:"";
	$TxtBasculaTara = isset($_REQUEST["TxtBasculaTara"])?$_REQUEST["TxtBasculaTara"]:"";
	$TxtBasculaAux = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$Valor = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	$TxtPesoHistorico = isset($_REQUEST["TxtPesoHistorico"])?$_REQUEST["TxtPesoHistorico"]:"";
	$OptBascula = isset($_REQUEST["OptBascula"])?$_REQUEST["OptBascula"]:"";
	$SoloTara = isset($_REQUEST["SoloTara"])?$_REQUEST["SoloTara"]:"";
	$TxtObs = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$TxtGuia = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$TxtNumRomana = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";


	
	$Consultar="SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp=mysqli_query($link, $Consultar);
	if ($Row=mysqli_fetch_array($Resp))
	{
		$OperSalida=strtoupper(substr($Row["nombres"],0,1)).strtoupper(substr($Row["apellido_paterno"],0,1)).strtoupper(substr($Row["apellido_materno"],0,1));		
	}
	

	switch($Proceso)
	{
		case "E"://ACTUALIZAR RECEPCION
			if($TxtPesoBruto=='')
				$TxtPesoBruto=0;
			if($TxtPesoTara=='')
				$TxtPesoTara=0;
			if($TxtPesoNeto=='')
				$TxtPesoNeto=0;
			if($SoloTara=='TARA')
			{
				$TxtObs =$SoloTara;
				$TxtBasculaTara=$TxtBasculaAux;
				$Conjunto='';$SubProductos='';$Productos='';
			}
			else
			{
				//AGREGA MOVIMIENTO CONJUNTO EN RAM
				$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = $Conjunto AND estado != 'f' order by fecha_creacion desc";
				$rs = mysqli_query($link, $consulta);
				//echo $consulta."<br>";
				if($row = mysqli_fetch_array($rs))
				{
					$cod_conjunto = $row["cod_conjunto"];
					$cod_lugar = $row["cod_lugar"];
					$num_lugar = $row["num_lugar"];
					
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
					$Insertar = "$Insertar VALUES('02','".$fecha."','03','$Conjunto','0','0','$cod_conjunto','$Conjunto','$cod_lugar','$num_lugar',0,$TxtPesoNeto,0,0,'A')";												  
					mysqli_query($link, $Insertar);
					
				}
				
			}//
				//CrearArchivoResp('O','E',$TxtCorrelativo,'','','',$RutOperador,$TxtBasculaTara,$TxtBasculaAux,$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,'','','','','',$TxtGuia,$TxtPatente,'',$Conjunto,$TxtObs,'','','','','');
				$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_salida='$TxtBasculaAux',peso_bruto='".$TxtPesoBruto."',peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',patente='".strtoupper($TxtPatente)."',nombre='".$Productos."',";
				$Actualizar.="guia_despacho='".$TxtGuia."',conjunto='".$Conjunto."',descripcion='".$SubProductos."',observacion='".$TxtObs."',romana_entrada='$TxtNumRomana',romana_salida='$TxtNumRomana' ";
				$Actualizar.="where correlativo='".$TxtCorrelativo."'";//echo $Actualizar;
				mysqli_query($link, $Actualizar);
			//	ImprimirOtrosPesajes($TxtCorrelativo,$TxtNumRomana,$OperSalida);
				header('location:rec_circulantes.php?TxtNumBascula='.$TxtNumBascula);	
			break;
		/*case "S"://ACTUALIZAR SALIDA
			CrearArchivoResp('O','S',$TxtCorrelativo,'','','',$RutOperador,'',$TxtNumBascula,$TxtFecha,$TxtHoraE,$TxtHoraS,$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$TxtNombre,'','',$TxtDescripcion,'',$TxtGuia,$TxtPatente,'',$TxtConjunto,$TxtObs,'','','','','');			
			$Actualizar="UPDATE sipa_web.otros_pesaje set bascula_salida='$TxtNumBascula',peso_bruto='".$TxtPesoBruto."',peso_tara='".$TxtPesoTara."',peso_neto='".$TxtPesoNeto."',hora_salida='".$TxtHoraS."',";
			$Actualizar.="nombre='".$TxtNombre."',descripcion='".$TxtDescripcion."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			ImprimirOtrosPesajes($TxtCorrelativo,$TxtNumRomana,$OperSalida);
			header('location:rec_circulantes.php?TxtNumBascula='.$TxtNumBascula);
			break;*/
		case "A"://ANULAR
			$Actualizar="UPDATE sipa_web.otros_pesaje set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			header('location:rec_circulantes.php?TxtNumBascula='.$TxtNumBascula);
			break;	
		case "C"://CANCELAR
			if($TipoProceso=='E')
			{
				if($TxtCorrelativo!='')
				{
					$Eliminar="delete from sipa_web.otros_pesaje where correlativo='".$TxtCorrelativo."' and patente='".trim($TxtPatente)."' and (peso_neto='0' or peso_neto='') ";
					mysqli_query($link, $Eliminar);
					//echo $Eliminar;			
				}	
			}
			header('location:rec_circulantes.php?TxtNumBascula='.$TxtNumBascula);
			break;	
		case "MC"://modofica los circulantes
				$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = $Conjunto AND estado != 'f' order by fecha_creacion desc";
				$rs = mysqli_query($link, $consulta);
				if($row = mysqli_fetch_array($rs))
				{
					$cod_conjunto = $row["cod_conjunto"];
					$num_conjunto = $row["num_conjunto"];
					$cod_existencia = $row["cod_existencia"];
					$conjunto_destino = $row["conjunto_destino"];
					$lugar_destino = $row["lugar_destino"];
					$cod_lugar = $row["cod_lugar"];
					$num_lugar = $row["num_lugar"];
					
					if(strlen($cod_conjunto) == 1)
						$cod_conjunto = "0".$cod_conjunto;				
		
					if(strlen($cod_lugar) == 1)
						$cod_lugar = "0".$cod_lugar;				
		
					if(strlen($num_lugar) == 1)
						$num_lugar = "0".$num_lugar;				
		
					$fecha = $TxtFecha.' '.date("H:i:s");
					$consulta = "SELECT * FROM sipa_web.otros_pesaje WHERE correlativo='".$TxtCorrelativo."'";
					$rs = mysqli_query($link, $consulta);
					if($row = mysqli_fetch_array($rs))
					{
							$Fecha=$row["fecha"];	
						$num_conj_ant=$row["conjunto"];						
						$Actualizar="UPDATE ram_web.movimiento_conjunto set NUM_CONJUNTO='".$Conjunto."', CONJUNTO_DESTINO='".$Conjunto."', LUGAR_DESTINO='".$num_lugar."' where COD_EXISTENCIA='02' and COD_CONJUNTO='03' and NUM_CONJUNTO='".$num_conj_ant."' and left(FECHA_MOVIMIENTO,10) = '".$Fecha."'";
						mysqli_query($link, $Actualizar);
					}					
				}
				$Actualizar="UPDATE sipa_web.otros_pesaje set nombre='".$Productos."',conjunto='".$Conjunto."',descripcion='".$SubProductos."',observacion='".$TxtObs."'";
				$Actualizar.="where correlativo='".$TxtCorrelativo."'";
				mysqli_query($link, $Actualizar);
				header('location:rec_adm_lote06.php?TxtCorr='.$TxtCorrelativo.'&Msj=S');
		break;	
	}

?>