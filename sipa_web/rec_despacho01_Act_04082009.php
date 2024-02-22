<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	$RutOperador=$CookieRut;
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
			header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "S"://ACTUALIZAR SALIDA
			$Datos=explode('~',$TxtCorrelativo);
			$Actualizar="UPDATE sipa_web.despachos set bascula_salida='$TxtNumBascula', ult_registro='".$CmbUltRecargo."',peso_bruto='".$TxtPesoBruto."',peso_neto='".$TxtPesoNeto."',";
			$Actualizar.="marca='".$TxtMarca."',cod_mop='".$CmbCodMop."',num_sello='".$TxtSello."',transportista='".$TxtTransp."',rut_chofer='".$TxtRutChofer."',";
			$Actualizar.="nombre_chofer='".$TxtNomChofer."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$Datos[0]."' and lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			RespConsDespSal($Datos[0],$Actualizar);
			ImprimirDespachos($Datos[0],$TxtNumRomana);
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
				echo "window.location='rec_despacho.php?TxtNumBascula=".$TxtNumBascula."';";
				echo "</script>";
			}					
			else
				header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break;
		case "A"://ANULAR
			$Actualizar="UPDATE sipa_web.despachos set estado='A',observacion='".$TxtObs."' ";
			$Actualizar.="where correlativo='".$TxtCorrelativo."'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break;	
		case "C"://CANCELAR
			if($TipoProceso=='E')
			{
				if($TxtCorrelativo!='')
				{
					$Eliminar="delete from sipa_web.despachos where correlativo='".$TxtCorrelativo."' and patente='".trim($TxtPatente)."' and peso_bruto='0' and peso_tara='0' and peso_neto='0' ";
					mysqli_query($link, $Eliminar);			
					//echo $Eliminar."<br>";
				}	
			}
			else
			{
				$Actualizar="UPDATE sipa_web.despachos set lote='',recargo='',peso_bruto='',peso_neto='' ";
				$Actualizar.="where correlativo='".$TxtCorrelativo."'";
				mysqli_query($link, $Actualizar);
			}
			header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break;	
	}
?>