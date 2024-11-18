<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	require "includes/class.phpmailer.php";
	$CookieRut = $_COOKIE["CookieRut"];	
	$RutOperador=$CookieRut;
	$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TipoProceso   = isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:'';

	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtNumBascula = isset($_REQUEST["TxtNumBascula"])?$_REQUEST["TxtNumBascula"]:"";
	$TxtBasculaAux = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$TxtHoraE = isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:"";
	$TxtFecha = isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:"";
	$TxtPesoTara  = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtPatente  = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtObs      = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$CmbCodMop = isset($_REQUEST["CmbCodMop"])?$_REQUEST["CmbCodMop"]:"";
	$TxtNumRomana = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";
	$TxtRutChofer = isset($_REQUEST["TxtRutChofer"])?$_REQUEST["TxtRutChofer"]:"";
	$TxtNomChofer = isset($_REQUEST["TxtNomChofer"])?$_REQUEST["TxtNomChofer"]:"";
	$TxtGuia     = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$TxtTarjeta  = isset($_REQUEST["TxtTarjeta"])?$_REQUEST["TxtTarjeta"]:"";
	$CmbUltRecargo = isset($_REQUEST["CmbUltRecargo"])?$_REQUEST["CmbUltRecargo"]:"";
	$TxtPesoBruto  = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtPesoNeto  = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";
	$TxtMarca     = isset($_REQUEST["TxtMarca"])?$_REQUEST["TxtMarca"]:"";
	$TxtSello     = isset($_REQUEST["TxtSello"])?$_REQUEST["TxtSello"]:"";
	$TxtTransp    = isset($_REQUEST["TxtTransp"])?$_REQUEST["TxtTransp"]:"";
	$TxtLote        = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$TxtRecargo  = isset($_REQUEST["TxtRecargo"])?$_REQUEST["TxtRecargo"]:"";	
	$CmbProveedor = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtNombrePrv = isset($_REQUEST["TxtNombrePrv"])?$_REQUEST["TxtNombrePrv"]:"";	
	$DifLimitePeso = isset($_REQUEST["DifLimitePeso"])?$_REQUEST["DifLimitePeso"]:"";	
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$TxtPesoNetoSec = isset($_REQUEST["TxtPesoNetoSec"])?$_REQUEST["TxtPesoNetoSec"]:"";
	$TxtLimitePeso = isset($_REQUEST["TxtLimitePeso"])?$_REQUEST["TxtLimitePeso"]:"";

	
	$Consultar="SELECT nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut = '".$RutOperador."'";
	$Resp=mysqli_query($link, $Consultar);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$OperSalida= strtoupper(substr($Fila["nombres"],0,1)).strtoupper(substr($Fila["apellido_paterno"],0,1)).strtoupper(substr($Fila["apellido_materno"],0,1));
	}
	switch($Proceso)
	{
		case "E"://ACTUALIZAR ENTRADA
			CrearArchivoResp('D','E',$TxtCorrelativo,'','','',$RutOperador,$TxtBasculaAux,'',$TxtFecha,$TxtHoraE,'','',$TxtPesoTara,'','','','','','','',$TxtPatente,'','',$TxtObs,'','','','',$CmbCodMop);
			$Actualizar="UPDATE sipa_web.despachos SET peso_tara='".$TxtPesoTara."',cod_mop='".$CmbCodMop."',observacion='".$TxtObs."',bascula_entrada='$TxtBasculaAux',romana_entrada='$TxtNumRomana',rut_chofer='".$TxtRutChofer."',nombre_chofer='".$TxtNomChofer."' ";
			$Actualizar.=" WHERE correlativo='".$TxtCorrelativo."'";
			echo $Actualizar;
			mysqli_query($link, $Actualizar);
			//echo $Actualizar."<br>";
			$Insertar="INSERT INTO sipa_web.datos_ejes (tipo_camion,patente,folio,cod_tipo_carga,tipo_carga,guia,tara,numtarjeta,tolerancia,validar_tolerancia) values(";
			//$Insertar.="'$CmbCodMop','".trim($TxtPatente)."','$TxtCorrelativo','2','MINERO','$TxtGuia','$TxtPesoTara','$TxtTarjeta','3','N')";//se habilita esto si copias exe guia nuevo
			$Insertar.="'$CmbCodMop','".trim($TxtPatente)."','$TxtCorrelativo','2','MINERO','$TxtGuia','$TxtPesoTara','$TxtTarjeta','3','S')";//y este desabilitar si copias guias nueva
			mysqli_query($link, $Insertar);
			//echo $Insertar."<br>";
			CrearArchivoEjes($TxtCorrelativo,$TxtPatente,$CmbCodMop,"","","",$TxtGuia);
			header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break; 
		case "S"://ACTUALIZAR SALIDA
			$Datos=explode('~',$TxtCorrelativo);
			$Actualizar="UPDATE sipa_web.despachos set bascula_salida='$TxtBasculaAux', ult_registro='".$CmbUltRecargo."',peso_bruto='".$TxtPesoBruto."',peso_neto='".$TxtPesoNeto."',";
			$Actualizar.="marca='".$TxtMarca."',cod_mop='".$CmbCodMop."',num_sello='".$TxtSello."',transportista='".$TxtTransp."',rut_chofer='".$TxtRutChofer."',";
			$Actualizar.="nombre_chofer='".$TxtNomChofer."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana' ";
			$Actualizar.="where correlativo='".$Datos[0]."' and lote='".$TxtLote."' and recargo='".$TxtRecargo."'";
			$result=mysqli_query($link, $Actualizar);
			//echo "Actualizar 1 ".$Actualizar;
			if (!$result)
			{
				$Actualizar="UPDATE sipa_web.despachos set bascula_salida='$TxtBasculaAux', ult_registro='".$CmbUltRecargo."',peso_bruto='".$TxtPesoBruto."',peso_neto='".$TxtPesoNeto."',";
				$Actualizar.="marca='".$TxtMarca."',cod_mop='".$CmbCodMop."',num_sello='".$TxtSello."',transportista='".$TxtTransp."',rut_chofer='".$TxtRutChofer."',";
				$Actualizar.="nombre_chofer='".$TxtNomChofer."',observacion='".$TxtObs."',romana_salida='$TxtNumRomana',lote='".$TxtLote."',recargo='".$TxtRecargo."'  ";
				$Actualizar.="where correlativo='".$Datos[0]."'";
				mysqli_query($link, $Actualizar);	
				//echo "Actualizar 2 ".$Actualizar;
			}

			//echo $Actualizar."<br>";
		
			$Actualiza="UPDATE sipa_web.datos_ejes set NOM_TRANSPORTISTA = '".$TxtTransp."', GUIA = '".$TxtGuia."',";
			$Actualiza.="BRUTO = '".$TxtPesoBruto."' where FOLIO = '".$Datos[0]."'";
			mysqli_query($link, $Actualiza);
			RespConsDespSal($Datos[0],$Actualizar);
			ImprimirDespachos($Datos[0],$TxtNumRomana,$OperSalida,$link); 
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
			if($DifLimitePeso!='')
			{
				$DatosDif=explode('~',$DifLimitePeso);
				$ProdSubProd=explode('~',$CmbSubProducto);
				$Insertar="INSERT INTO sipa_web.registro_puntos_control(correlativo,fecha_hora,rut_operador,peso_bruto,peso_tara,peso_neto,peso_sec,cod_producto,cod_subproducto,guia_despacho,patente,peso_control,diferencia,operacion_realizada) values ";
				$Insertar.="('".$Datos[0]."','".date('Y-m-d G:i:s')."','".$CookieRut."','".$TxtPesoBruto."','".$TxtPesoNeto."','".$TxtPesoTara."','".$TxtPesoNetoSec."','".$ProdSubProd[0]."','".$ProdSubProd[1]."','".$TxtGuia."','".trim($TxtPatente)."','".$TxtLimitePeso."','".$DatosDif[1]."','".$DatosDif[0]."')";
				mysqli_query($link, $Insertar);
				FuncionEnvioCorreo($Datos[0],$link);
				
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
			mysqli_query($link, $Actualizar);
			header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break;		
		case "C"://CANCELAR
			$Datos=explode('~',$TxtCorrelativo);
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
				$Actualizar="UPDATE sipa_web.despachos set lote='',recargo='',peso_bruto='0',peso_neto='0' ";
				$Actualizar.="where correlativo='".$Datos[0]."'";
				//$Actualizar.="where correlativo='".$TxtCorrelativo."'";				
				mysqli_query($link, $Actualizar);
				if($DifLimitePeso!='')
				{
					$DatosDif=explode('~',$DifLimitePeso);
					if($DatosDif[0]=='C')
					{
						$ProdSubProd=explode('~',$CmbSubProducto);
						$Insertar="INSERT INTO sipa_web.registro_puntos_control(correlativo,fecha_hora,rut_operador,peso_bruto,peso_tara,peso_neto,peso_sec,cod_producto,cod_subproducto,guia_despacho,patente,peso_control,diferencia,operacion_realizada) values ";
						$Insertar.="('".$TxtCorrelativo."','".date('Y-m-d G:i:s')."','".$CookieRut."','".$TxtPesoBruto."','".$TxtPesoNeto."','".$TxtPesoTara."','".$TxtPesoNetoSec."','".$ProdSubProd[0]."','".$ProdSubProd[1]."','".$TxtGuia."','".trim($TxtPatente)."','".$TxtLimitePeso."','".$DatosDif[1]."','".$DatosDif[0]."')";
						mysqli_query($link, $Insertar);
					}
				}
			}
			header('location:rec_despacho.php?TxtNumBascula='.$TxtNumBascula);
			break;		
	}
function FuncionEnvioCorreo($Corr,$link)
{
	$ConsultaCorreo="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='24003'";
	$RespCorreo=mysqli_query($link, $ConsultaCorreo);
	if($FilaCorreo=mysqli_fetch_array($RespCorreo))
	{
		
		$Correos=$FilaCorreo["nombre_subclase"];
		
		$Consulta="SELECT t1.*,t2.descripcion as Prod,t3.descripcion as SubProd,t4.apellido_paterno,t4.apellido_materno,t4.nombres from sipa_web.registro_puntos_control t1 ";
		$Consulta.=" left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto";
		$Consulta.=" left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
		$Consulta.=" left join proyecto_modernizacion.funcionarios t4 on t1.rut_operador=t4.rut ";
		$Consulta.=" where t1.correlativo='".$Corr."' and t1.operacion_realizada='A' order by t1.fecha_hora desc";
		$RespReg=mysqli_query($link, $Consulta);
		if($FilaReg=mysqli_fetch_array($RespReg))
		{
			$Fecha=$FilaReg["fecha_hora"];
			$Operador=$FilaReg["apellido_paterno"]." ".$FilaReg["apellido_materno"]." ".$FilaReg["nombres"];
			$Patente=$FilaReg["patente"];
			$Guia=$FilaReg["guia_despacho"];
			$Prod=$FilaReg["Prod"];
			$SubProd=$FilaReg["SubProd"];
			$PesoBrutoSipa=$FilaReg["peso_bruto"];
			$PesoBrutoSec=$FilaReg["peso_sec"];
			$PesoControl=$FilaReg["peso_control"];
			$PesoDif=$FilaReg["diferencia"];
		
		}
		
		$ArrayCorreos=explode(",",$Correos);
		foreach($ArrayCorreos as $C =>$Correo2)	
		{
			$Asunto='Aviso Punto de Control SIPA';
			$Titulo='Aviso Punto de Control SIPA';
			$Mensaje='<font face="Arial" size="2">Con Fecha '.$Fecha.' se a aceptado despacho de camion con un Peso Superior al limite predefinido.</b><br>';
			$Mensaje.='<br>';
			/*$Mensaje.='Pesaje del Camion Patente '.$Patente.', Correspondiente a la Siguiente Guia N� '.$Guia.'<br><br>';
			$Mensaje.='Con un Peso Bruto Sipa de '.number_format($PesoBrutoSipa,0,',','.').' (Kg) y un Peso Bruto Sec '.number_format($PesoBrutoSec,0,',','.').' (Kg)<br><br>';
			$Mensaje.='A Sobrepasado en '.$PesoDif.' (Kg) del Peso Limite definido de ('.$PesoControl.') (Kg) para el Producto '.$Prod.' SubProducto '.$SubProd.'<br><br>';
			*/
			$Mensaje.= '<table border="1"  ><tr><td><font color="#999999" face="Times New Roman, Times, serif">Patente</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$Patente.'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Guia</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$Guia.'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Producto</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$Prod.'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">SubProducto</font></td><td><font color="#999999" face="Times New Roman, Times, serif">'.$SubProd.'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Peso Bruto Sipa (Kg)</font></td><td  align="right"><font color="#999999" face="Times New Roman, Times, serif">'.number_format($PesoBrutoSipa,0,',','.').'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Peso Bruto Sec (Kg)</font></td><td  align="right"><font color="#999999" face="Times New Roman, Times, serif">'.number_format($PesoBrutoSec,0,',','.').'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Peso Limite (Kg)</font></td><td  align="right"><font color="#999999" face="Times New Roman, Times, serif">'.$PesoControl.'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Sobre Peso Limite(Kg)</font></td><td  align="right"><font color="#999999" face="Times New Roman, Times, serif">'.$PesoDif.'</font></td></tr>';
			$Mensaje.= '<tr><td><font color="#999999" face="Times New Roman, Times, serif">Operador</font></td><td  align="left"><font color="#999999" face="Times New Roman, Times, serif">'.$Operador.'</font></td></tr>';
			$Mensaje.= '</table>';



			$cuerpoMsj = '<html>';
			$cuerpoMsj.= '<head>';
			$cuerpoMsj.= '<title>'.$Titulo.'</title>';
			$cuerpoMsj.= '</head>';
			$cuerpoMsj.= '<body>';
			$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
			$cuerpoMsj.= '<tr><td>';
			$cuerpoMsj.= ''.$Mensaje.'';
			$cuerpoMsj.= "<br>";
			$cuerpoMsj.="Por Su Atenci�n Muchas Gracias.";
			$cuerpoMsj.= "<br>";
			$cuerpoMsj.="Servicio Automatico de Sistema de Pesaje 'SIPA'.";
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
			$mail->FromName = "SIPA - Sistemas Pesaje Automatico";
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
}	
?>