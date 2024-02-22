<?php
	include("../principal/conectar_principal.php");
	include("funciones_2402.php");
	$RutOperador=$CookieRut;
	$Consultar="SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp=mysqli_query($link, $Consultar);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$OperSalida= strtoupper(substr($Fila["nombres"],0,1)).strtoupper(substr($Fila["apellido_paterno"],0,1)).strtoupper(substr($Fila["apellido_materno"],0,1));
	}
	switch($Proceso)
	{
		case "E"://ACTUALIZAR ENTRADA
			CrearArchivoResp('D','E',$TxtCorrelativo,'','','',$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'','',$TxtPesoTara,'','','','','','','',$TxtPatente,'','',$TxtObs,'','','','',$CmbCodMop);
			$Actualizar="UPDATE sipa_web.despachos set peso_tara='".$TxtPesoTara."',cod_mop='".$CmbCodMop."',observacion='".$TxtObs."',bascula_entrada='$TxtNumBascula',romana_entrada='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			$Insertar="INSERT INTO sipa_web.datos_ejes (tipo_camion,patente,folio,cod_tipo_carga,tipo_carga,guia,tara,numtarjeta,tolerancia,validar_tolerancia) values(";
			//$Insertar.="'$CmbCodMop','".trim($TxtPatente)."','$TxtCorrelativo','2','MINERO','$TxtGuia','$TxtPesoTara','$TxtTarjeta','3','N')";//se habilita esto si copias exe guia nuevo
			$Insertar.="'$CmbCodMop','".trim($TxtPatente)."','$TxtCorrelativo','2','MINERO','$TxtGuia','$TxtPesoTara','$TxtTarjeta','3','S')";//y este desabilitar si copias guias nueva
			mysqli_query($link, $Insertar);
			CrearArchivoEjes($TxtCorrelativo,$TxtPatente,$CmbCodMop,"","","",$TxtGuia);
			header('location:rec_despacho_2402.php?TxtNumBascula='.$TxtNumBascula);
			break; 
		case "S"://ACTUALIZAR SALIDA
			$Datos=explode('~',$TxtCorrelativo);
			$Actualizar="UPDATE sipa_web.despachos set bascula_salida='$TxtNumBascula', ult_registro='".$CmbUltRecargo."',peso_bruto='".$TxtPesoBruto."',peso_neto='".$TxtPesoNeto."',";
			$Actualizar.="marca='".$TxtMarca."',cod_mop='".$CmbCodMop."',num_sello='".$TxtSello."',transportista='".$TxtTransp."',rut_chofer='".$TxtRutChofer."',";
			$Actualizar.="nombre_chofer='".$TxtNomChofer."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$Datos[0]."' and lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
			mysqli_query($link, $Actualizar);
			$Actualiza="UPDATE sipa_web.datos_ejes set NOM_TRANSPORTISTA = '".$TxtTransp."', GUIA = '".$TxtGuia."',";
			$Actualiza.="BRUTO = '".$TxtPesoBruto."' where FOLIO = '".$Datos[0]."'";
			mysqli_query($link, $Actualiza);
			RespConsDespSal($Datos[0],$Actualizar);
			ImprimirDespachos($Datos[0],$TxtNumRomana,$OperSalida); 
			//INSERTA DESTINATARIO Y CHOFERES DE CAMION PARA PRODUCTOS QUE NO TENGAN SISTEMAS COMO PAC Y SEC
			if($CmbProveedor!=''&&$TxtNombrePrv!='')
			{
				$Insertar="INSERT INTO sipa_web.proveedores(rut_prv,nombre_prv) values('$CmbProveedor','$TxtNombrePrv')";
				mysqli_query($link, $Insertar);
				$Actualizar="UPDATE sipa_web.proveedores set direccion='".$TxtDirec."' where rut_prv='".$CmbProveedor."'"; 
				mysqli_query($link, $Actualizar);
			}
			if($TxtRutChofer!=''&&$TxtNomChofer!='')
			{
				$Insertar="INSERT INTO sipa_web.choferes(rut_chofer,nombre_chofer) values('$TxtRutChofer','$TxtNomChofer')";
				mysqli_query($link, $Insertar);
			}
			$ProdSubProd=explode('~',$CmbSubProducto);
			if($ProdSubProd[0]!='18'&&$ProdSubProd[0]!='46'&&$ProdSubProd[0]!='41')
			{
				echo "<script language='JavaScript'>";
				echo "window.open('rec_impresion_guia_despacho.php?Valores='+$Datos[0]+'&Proceso=I','','top=0px,left=5px,width=770px,height=550px,scrollbars=yes,resizable = yes');";
				echo "window.location='rec_despacho_2402.php?TxtNumBascula=".$TxtNumBascula."';";
				echo "</script>";
			}				
			else 
				header('location:rec_despacho_2402.php?TxtNumBascula='.$TxtNumBascula);
				break; 	
		case "A"://ANULAR
			$Actualizar="UPDATE sipa_web.despachos set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			mysqli_query($link, $Actualizar);
			header('location:rec_despacho_2402.php?TxtNumBascula='.$TxtNumBascula);
			break;		
		case "C"://CANCELAR
			if($TipoProceso=='E')
			{
				if($TxtCorrelativo!='')
				{
					$Eliminar="delete from sipa_web.despachos where correlativo='".$TxtCorrelativo."' and patente='".trim($TxtPatente)."' and peso_bruto='0' and peso_tara='0' and peso_neto='0' ";
					mysqli_query($link, $Eliminar);			
				}	
			}
			else
			{
				$Actualizar="UPDATE sipa_web.despachos set lote='',recargo='',peso_bruto='',peso_neto='' ";
				$Actualizar.="where correlativo='".$TxtCorrelativo."'";
				mysqli_query($link, $Actualizar);
			}
			header('location:rec_despacho_2402.php?TxtNumBascula='.$TxtNumBascula);
			break;		
	}
?>