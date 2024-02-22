<?
	require "includes/class.phpmailer.php";
	
function DescripcionCeco($Ceco)
{
	$Des='';
	$Consulta = "select t2.DESCRIPCION  from  proyecto_modernizacion.centro_costo t2  where t2.CENTRO_COSTO='".$Ceco."' ";
	//echo $Consulta;
	$RespP=mysql_query($Consulta);
	if ($FilaP=mysql_fetch_array($RespP))
	{
		$Des=$FilaP["descripcion"];
	}
	return($Des);

}
function PerfilCorreo($Nro,$Cuenta)
{
	$Des='';
	$Consulta="select count(*) as CANT from ipif_ceco_solicitante t1 inner join ipif_novedades_correos t2 on ";
	$Consulta.=" t1.cod_ceco=t2.cod_cc and t1.cuenta_solicitante=t2.cuenta";
	$Consulta.=" where  cod_tipo='2' and nro_solicitud='".$Nro."' and t2.tipo='A' ";
	
$ConsultaP="select t3.*,t4.descripcion  from ipif_novedades t1 inner join ipif_novedades_correos t2 on ";
$ConsultaP.=" t1.nro_solicitud=t2.nro_solicitud inner join ipif_ceco_solicitante t3 ";
$ConsultaP.=" t2.cuenta=t3.cuenta_solicitante and t2.cod_cc=t3.cod_ceco inner join ipif_tipo_perfil t4 ";
$ConsultaP.=" on t3.cod_perfil=t4.cod_tipo_perfil where  t1.nro_solicitud='".$Nro."' and t2.cuenta='".$Cuenta."'";
$ResultP = mysql_query($ConsultaP);
if($FiP = mysql_fetch_assoc($ResultP))
{	
	$Des=$FiP["descripcion"];
}
return($Des);
}
function EnvioCorreo($NumNov,$OPCI)
{
		
		ob_start("ob_gzhandler");
		$Hora= date("G:i:s");
		$InfGer='';
		$Consulta="select * from ipif_novedades where nro_solicitud='".$NumNov."'";
		$RespSolp=mysql_query($Consulta);
		if($FilaSolp=mysql_fetch_array($RespSolp))
		{
			//$TxtFecha=$FilaSolp[fecha_ingreso];
			$TxtFecha=FechaAMD($FilaSolp[fecha]);
			$TxtFechaNovedad=FechaAMD($FilaSolp[fecha_ingreso]);
			$CmbTurno=$FilaSolp[turno];
			$Turno=Turno($CmbTurno);
			$textnovedad=$FilaSolp["observacion"];
			$InfGer=$FilaSolp[informe_gerencia];
			$Estado=$FilaSolp[estado];
			$RutOrig=$FilaSolp[rut_originador];
			$CuentaOrig=CuentaRut($RutOrig).'@codelco.cl';
			$CecoOri=CECOFuncionario($FilaSolp[cuenta]);
			$DescripOri=DescripcionCeco($CecoOri);
			$CentroCostoOrigen='['.$CecoOri.']'.' '.$DescripOri;
		}
		if($InfGer=='S')
			$InfGer='Si';
		else
			$InfGer='No';
		$Asunto=$NumNov." ".substr($textnovedad,0,100);
		$De=$CuentaOrig;
		$Condicion='';
		$CO='No';
		$Consulta="select * from ipif_condicion t1 inner join ipif_novedades_condicion t2 on ";
		$Consulta.="t1.cod_condicion=t2.cod_condicion where t2.nro_solicitud='".$NumNov."'  ";
		$RespCO=mysql_query($Consulta);
		While($FilaCO=mysql_fetch_array($RespCO))
		{
			$CO='Si';
			$Condicion=$Condicion.'<tr><td>'.ucwords(strtolower($FilaCO["descripcion"])).'</td><td>'.$CO.'&nbsp;</td></tr>';
		}
		//$Condicion=$Condicion.'<tr><td>'.ucwords(strtolower($FilaCO["descripcion"])).'</td><td>'.$CO.'&nbsp;</td></tr>';
		if($OPCI=='A')
		{
		$Consulta="select * from ipif_novedades_correos where nro_solicitud='".$NumNov."' and tipo='A'";
		$RespCORREO=mysql_query($Consulta);
		while($FilaCORREO=mysql_fetch_array($RespCORREO))
		{
			$Cuenta=$FilaCORREO[cuenta];
			$DatosF=Funcionario($FilaCORREO[cuenta]);
			$MDatosF=explode('~',$DatosF);
			$Email1=$MDatosF[1];
			$Perfil= Perfil($Cuenta,$FilaCORREO[cod_cc]);
			$Ceco= DescripcionCeco($FilaCORREO[cod_cc]);
			$Cabecera='<table width="611" height="163" border="0"><tr><td colspan="2">&nbsp;</td></tr>';
			$Cabecera.='<tr><td colspan="2">Estimado Sr. '.$Perfil.' de '.$Ceco.'</td></tr>';
			$Cabecera.=' <tr><td colspan="2">&nbsp;</td></tr>';
			$Cabecera.='<tr><td colspan="2">Se ha genereado una solicitud Autom&aacute;tica (Sol-'.$NumNov.') para ser atendida por su &aacute;rea</td> </tr>';
			$Cabecera.='<tr><td colspan="2">el incidente informado especifica lo siguiente:</td> </tr>';
			$Cabecera.='<tr><td colspan="2">&nbsp;</td></tr>';
			$Cabecera.='<tr><td width="133">Nro. Incidente </td><td width="462">'.$NumNov.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>Fecha Creaci&oacute;n Reporte</td><td>'.$TxtFecha.' '.$Hora.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>Fecha y Turno Novedad</td><td>'.$TxtFechaNovedad.'  '.$Turno.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>�rea Originadora</td><td>'.$CentroCostoOrigen.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>Novedad Reportada </td><td>'.$textnovedad.'&nbsp;</td></tr>';
			$Cabecera.=$Condicion;
			$Cabecera.='<tr><td>Aviso Gerencia </td><td>'.$InfGer.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
			$Cabecera.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
			$Cabecera.=' <tr><td colspan="2">Por su Atenci&oacute;n Muchas Gracias.</td></tr>';
			$Cabecera.='<tr><td colspan="2">Servicio Autom&aacute;tico Informaci&oacute;n de Novedades </td></tr></table>';
			$cuerpoMsj = '<html>';
			$cuerpoMsj.= '<head>';
			$cuerpoMsj.= '<title>IPIF</title>';
			$cuerpoMsj.= '</head>';
			$cuerpoMsj.= '<body>';
			$cuerpoMsj.= '<table border="0"><tr><td width="253">'.$Cabecera.'</td></tr>';
			$cuerpoMsj.= '</table>';
			$cuerpoMsj.= '</body></html>';
		$DOS_SALTOS="\r\n\r\n";
			$mail = new phpmailer();
			$mail->PluginDir = "includes/";
			$mail->Mailer = "smtp";
			$mail->Host = "VEFVEX03.codelco.cl";
			$mail->From = $De;
			$mail->FromName = $De;
			//$mail ->addcc=
			$mail->Subject = $Asunto;
			$mail->Body=$cuerpoMsj;
			$mail->IsHTML=true;
			$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
			$mail->Timeout=120;
			if($Email1!='')
				$mail->AddAddress($Email1);
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
		
		if($OPCI=='B')
		{
		$Consulta="select * from ipif_novedades_correos where nro_solicitud='".$NumNov."' and tipo!='A'";
		$RespCORREO=mysql_query($Consulta);
		while($FilaCORREO=mysql_fetch_array($RespCORREO))
		{
			$Cuenta=$FilaCORREO[cuenta];
			$DatosF=Funcionario($FilaCORREO[cuenta]);
			$MDatosF=explode('~',$DatosF);
			$Email1=ucwords(strtolower($MDatosF[1]));
				$NOMBRE=$MDatosF[0];
			$Cabecera='<table width="611" height="163" border="0"><tr><td colspan="2">&nbsp;</td></tr>';
			$Cabecera.='<tr><td colspan="2">Estimado Sr. '.$NOMBRE.'</td></tr>';
			$Cabecera.=' <tr><td colspan="2">&nbsp;</td></tr>';
			$Cabecera.='<tr><td colspan="2">Se ha genereado una solicitud Autom&aacute;tica (Sol-'.$NumNov.') para ser atendida por su &aacute;rea</td> </tr>';
			$Cabecera.='<tr><td colspan="2">el incidente informado especifica lo siguiente:</td> </tr>';
			$Cabecera.='<tr><td colspan="2">&nbsp;</td></tr>';
			$Cabecera.='<tr><td width="133">Nro. Incidente </td><td width="462">'.$NumNov.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>Fecha Creaci&oacute;n Reporte</td><td>'.$TxtFecha.' '.$Hora.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>Fecha y Turno Novedad</td><td>'.$TxtFechaNovedad.'  '.$Turno.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>�rea Originadora</td><td>'.$CentroCostoOrigen.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>Novedad Reportada </td><td>'.$textnovedad.'&nbsp;</td></tr>';
			$Cabecera.=$Condicion;
			$Cabecera.='<tr><td>Aviso Gerencia </td><td>'.$InfGer.'&nbsp;</td></tr>';
			$Cabecera.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
			$Cabecera.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
			$Cabecera.=' <tr><td colspan="2">Por su Atenci&oacute;n Muchas Gracias.</td></tr>';
			$Cabecera.='<tr><td colspan="2">Servicio Autom&aacute;tico Informaci&oacute;n de Novedades </td></tr></table>';
			$cuerpoMsj = '<html>';
			$cuerpoMsj.= '<head>';
			$cuerpoMsj.= '<title>IPIF</title>';
			$cuerpoMsj.= '</head>';
			$cuerpoMsj.= '<body>';
			$cuerpoMsj.= '<table border="0"><tr><td width="253">'.$Cabecera.'</td></tr>';
			$cuerpoMsj.= '</table>';
			$cuerpoMsj.= '</body></html>';
			$DOS_SALTOS="\r\n\r\n";
			$mail = new phpmailer();
			$mail->PluginDir = "includes/";
			$mail->Mailer = "smtp";
			$mail->Host = "VEFVEX03.codelco.cl";
			$mail->From = $De;
			$mail->FromName = $De;
			$mail->Subject = $Asunto;
			$mail->Body=$cuerpoMsj;
			$mail->IsHTML=true;
			$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
			$mail->Timeout=120;
			if($Email1!='')
				$mail->AddAddress($Email1);
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
		if($OPCI=='C')
		{
			$Ceco='';
			$Consulta = "select t2.ceco_origen  from  ipif_novedades t2  where t2.nro_solicitud='".$NumNov."' ";
			$RespP=mysql_query($Consulta);
			if ($FilaP=mysql_fetch_array($RespP))
			{
				$Ceco=$FilaP[ceco_origen];
			}
			if($Ceco!='')
			{
				$CODIGOCLASE=CODIGOCLASE();
				$Consulta = "Select t1.cuenta_solicitante as cuenta from ipif_ceco_solicitante t1 inner join proyecto_modernizacion.sub_clase t2 ";
				$Consulta.= " on t1.cod_perfil=t2.cod_subclase and t1.cod_tipo=t2.valor_subclase1 ";
				$Consulta.= " where t2.cod_clase='".$CODIGOCLASE."'  and t2.valor_subclase2='S' and t1.cod_ceco='".$Ceco."' ";
				$RespP=mysql_query($Consulta);
				$RespCORREO=mysql_query($Consulta);
				//echo $Consulta;
				while($FilaCORREO=mysql_fetch_array($RespCORREO))
				{
					$Cuenta=$FilaCORREO[cuenta];
					$DatosF=Funcionario($FilaCORREO[cuenta]);
					//echo "mail____".$DatosF."<br>";
					$MDatosF=explode('~',$DatosF);
					$Email1=ucwords(strtolower($MDatosF[1]));
					$NOMBRE=$MDatosF[0];
					//echo "nose___".$Email1;	
					//$CC=$CC.''.$Email1.''.',';
					//$CCFinal=substr($CC,0,strlen($DatosDivCCA)-1);
					//echo "con_copia_".$CCFinal."<br>"; 
					//echo "con_copia_".$CCFinal."<br>";
					$Cabecera='<table width="611" height="163" border="0"><tr><td colspan="2">&nbsp;</td></tr>';
					$Cabecera.='<tr><td colspan="2">Estimado '." ".$NOMBRE.' </td></tr>';
					$Cabecera.=' <tr><td colspan="2">&nbsp;</td></tr>';
					$Cabecera.='<tr><td colspan="2">Se ha genereado una solicitud Autom&aacute;tica (Sol-'.$NumNov.') para ser atendida por su &aacute;rea.</td> </tr>';
					$Cabecera.='<tr><td colspan="2">El incidente informado especifica lo siguiente:</td> </tr>';
					$Cabecera.='<tr><td colspan="2">&nbsp;</td></tr>';
					$Cabecera.='<tr><td width="133">Nro. Incidente </td><td width="462">'.$NumNov.'&nbsp;</td></tr>';
					$Cabecera.='<tr><td>Fecha Creaci&oacute;n Reporte</td><td>'.$TxtFecha.' '.$Hora.'&nbsp;</td></tr>';
					$Cabecera.='<tr><td>Fecha y Turno Novedad</td><td>'.$TxtFechaNovedad.'  '.$Turno.'&nbsp;</td></tr>';
					$Cabecera.='<tr><td>�rea Originadora</td><td>'.$CentroCostoOrigen.'&nbsp;</td></tr>';
					$Cabecera.='<tr><td>Novedad Reportada </td><td>'.$textnovedad.'&nbsp;</td></tr>';
					$Cabecera.=$Condicion;
					$Cabecera.='<tr><td>Aviso Gerencia </td><td>'.$InfGer.'&nbsp;</td></tr>';
					$Cabecera.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
					$Cabecera.='<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
					$Cabecera.=' <tr><td colspan="2">Por su Atenci&oacute;n Muchas Gracias.</td></tr>';
					$Cabecera.='<tr><td colspan="2">Servicio Autom&aacute;tico Informaci&oacute;n de Novedades </td></tr></table>';
					$cuerpoMsj = '<html>';
					$cuerpoMsj.= '<head>';
					$cuerpoMsj.= '<title>IPIF</title>';
					$cuerpoMsj.= '</head>';
					$cuerpoMsj.= '<body>';
					$cuerpoMsj.= '<table border="0"><tr><td width="253">'.$Cabecera.'</td></tr>';
					$cuerpoMsj.= '</table>';
					$cuerpoMsj.= '</body></html>';
					$DOS_SALTOS="\r\n\r\n";
					$mail = new phpmailer();
					$mail->PluginDir = "includes/";
					$mail->Mailer = "smtp";
					$mail->Host = "VEFVEX03.codelco.cl";
					$mail->From = $De;
					$mail->FromName = $De;
					//$mail->Addcc= $CCFinal;
					$mail->Subject = $Asunto;
					$mail->Body=$cuerpoMsj;
					$mail->IsHTML=true;
					$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
					$mail->Timeout=120;
					if($Email1!='')
						$mail->AddAddress($Email1);
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
		
		ob_end_flush();


}


function CambiaAcento($Texto)
	{
		$Texto=str_replace('�','&aacute;',$Texto);
		$Texto=str_replace('�','&eacute;',$Texto);
		$Texto=str_replace('�','&iacute;',$Texto);
		$Texto=str_replace('�','&oacute;',$Texto);
		$Texto=str_replace('�','&uacute;',$Texto);
		$Texto=str_replace('�','&uuml;',$Texto);
		$Texto=str_replace('�','&ntilde;',$Texto);
		$Texto=str_replace('�','&rsquo;',$Texto);
		
		$Texto=str_replace('�','&Aacute;',$Texto);
		$Texto=str_replace('�','&Eacute;',$Texto);
		$Texto=str_replace('�','&Iacute;',$Texto);
		$Texto=str_replace('�','&Oacute;',$Texto);
		$Texto=str_replace('�','&Uacute;',$Texto);
		$Texto=str_replace('�','&Uuml;',$Texto);
		$Texto=str_replace('�','&Ntilde;',$Texto);
		 
		return($Texto);
	}	
	function InsertarFuncionario($Cuenta,$Correo)
	{
		$Consulta="Select * from ipif_funcionario where cuenta='".$Cuenta."'";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			if($Correo!='')
			{
			$Actualizar="UPDATE ipif_funcionario set correo='".$Correo."' where cuenta='".$Cuenta."'";
			mysql_query($Actualizar);
			}
		}
		else
		{
			$Consulta="Select * from proyecto_modernizacion.funcionarios where cuenta_red='".$Cuenta."'";
			$Resp1=mysql_query($Consulta);
			if($Fila1=mysql_fetch_array($Resp1))
			{
				$Insertar="insert into ipif_funcionario(cuenta,nombre,correo)values('".$Cuenta."','".$Fila1[ape_paterno]." ".$Fila1[ape_materno]." ".$Fila1[nombres]."','".$Cuenta."@CODELCO.CL')";
				mysql_query($Insertar);
			
			}
		}	
	}
		function CECOFuncionario($Cuenta)
	{	$Datos='';
		$Consulta="Select cod_ceco from proyecto_modernizacion.funcionarios t1 where t1.cuenta_red='".$Cuenta."'";
		$RespF=mysql_query($Consulta);
		if($FilaF=mysql_fetch_array($RespF))
		{
			$Datos=$FilaF[cod_ceco];
		}
		return($Datos);
	}
	function Funcionario($Cuenta)
	{	$Datos='';
		$Consulta="Select t1.apellido_paterno,t1.apellido_materno,t1.nombres,t2.correo from proyecto_modernizacion.funcionarios t1 left join ipif_funcionario t2 on  t1.cuenta_red=t2.cuenta where t1.cuenta_red='".$Cuenta."'";
		$RespF=mysql_query($Consulta);
		if($FilaF=mysql_fetch_array($RespF))
		{
			$Datos=$FilaF["apellido_paterno"]." ".$FilaF["apellido_materno"]." ".$FilaF[nombres];
			$Datos=ucwords(strtolower(CambiaAcento($Datos)))."~".$FilaF[correo];
		}
		return($Datos);
	}
	function CODIGOCLASE()
	{	$Datos='';
		$Consulta="Select * from ipif_parametros_sistema where cod_parametro='1'";
		$RespF=mysql_query($Consulta);
		if($FilaF=mysql_fetch_array($RespF))
		{
			$Datos=$FilaF[valor];
		}
		return($Datos);
	}
	
	function CODIGOADMINISTRADOR()
	{	
	$CODIGOCLASE=CODIGOCLASE();
	
	$Datos='';
		$Consulta = "select t1.descripcion as DESCRIP,t2.cod_subclase from ipif_tipo_ceco t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_tipo=t2.valor_subclase1 where t2.cod_clase='".$CODIGOCLASE."' and t2.valor_subclase4='S'";			
		$RespF=mysql_query($Consulta);
		/*echo "***************************"."<br>";
		echo $Consulta."<br>";*/
		if($FilaF=mysql_fetch_array($RespF))
		{
			$Datos=$FilaF["cod_subclase"];
		}
		return($Datos);
	}	
	
	function CODIGOSISTEMA()
	{	$Datos='';
		$Consulta="Select * from ipif_parametros_sistema where cod_parametro='2'";
		$RespF=mysql_query($Consulta);
		if($FilaF=mysql_fetch_array($RespF))
		{
			$Datos=$FilaF[valor];
		}
		return($Datos);
	}
	function EncabezadoPagina($IP_SERV,$Imagen,$RutFunc)
	{
		include("encabezado.php")?>
		 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
		 <tr> 
		 <td width="958" valign="top">
		 <table width="760" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			  <td height="30" align="right" >
			  <table width="770" class="TablaPrincipal2">
					<tr valign="middle"> 
					  <td width="271">&nbsp;&nbsp;<img src="archivos\Titulos\<? echo $Imagen; ?>"></td>
					  <td width="190" align="center"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">											                      <? 
						echo NombreFunc($RutFunc) ;?>
					  </font></font></td>
					  <td width="280" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
						</font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
						<? 
						//$Fecha_Hora = date("d-m-Y h:i");
						$FechaFor=FechaHoraActual();
						echo $FechaFor." hrs";
						?>
						</font>
						</td>
					</tr>
				</table></td>
			</tr>
		  </table>
	
	<?
	}
	function CierreEncabezado()
	{
		?>
		</td>
    	</tr>
  		</table>
		<? include("pie_pagina.php");
	}
	function NombreFunc($R)
	{
		$Consulta=" select rut,nombres,apellido_paterno,apellido_materno";
		$Consulta.=" from proyecto_modernizacion.funcionarios where rut='".$R."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Func=$Fila[nombres].' '.$Fila["apellido_paterno"].' '.$Fila["apellido_materno"];
		return($Func);
	}
	function NombreFuncCorto($R)
	{
		$Consulta=" select rut,nombres,apellido_paterno,apellido_materno";
		$Consulta.=" from proyecto_modernizacion.funcionarios where rut='".$R."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Func=strtoupper($Fila[nombres]).' '.strtoupper($Fila["apellido_paterno"]).' '.strtoupper(substr($Fila["apellido_materno"],0,1));
		return($Func);
	}
	function NombreSol($C)
	{
		$Consulta=" select *  ";
		$Consulta.=" from sgpt_solicitante where cuenta='".$C."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Func=ucwords(strtolower($Fila[nombre_completo]));
		return($Func);	 	
	}
	function NombreOrig($R)
	{
		$Consulta="Select t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 where rut='".str_pad($R,10,'0',STR_PAD_LEFT)."'";
		$RespF=mysql_query($Consulta);
		if($FilaF=mysql_fetch_array($RespF))
		{
			$Datos=$FilaF["apellido_paterno"]." ".$FilaF["apellido_materno"]." ".$FilaF[nombres];
			$Datos=ucwords(strtolower(CambiaAcento($Datos)));
		return($Datos);	 	
		}
	}
	function CuentaRut($R)
	{
		$Consulta=" select *  from proyecto_modernizacion.funcionarios where rut='".str_pad($R,10,'0',STR_PAD_LEFT)."' ";
		$Resp=mysql_query($Consulta);
		/*echo $Consulta;*/
		if($Fila=mysql_fetch_array($Resp))
			$Cuenta=$Fila[cuenta_red];
		return($Cuenta);	 	
	}
	function Turno($Cod)
	{
		$Consulta = "select * from  proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase='".$Cod."'";
		$Resp=mysql_query($Consulta);
		if($FilaT=mysql_fetch_array($Resp))
			$T=$FilaT["nombre_subclase"];
		return($T);
	}
		
	function Perfil($P,$C)
	{
		$CODIGOCLASE=CODIGOCLASE();	
		$Consulta=" select t1.*,t2.nombre_subclase ,t2.cod_clase from  proyecto_modernizacion.sub_clase  t2 ";
		$Consulta.="inner join ipif_ceco_solicitante t1 on t1.cod_perfil=t2.cod_subclase ";
		$Consulta.=" where  t1.cuenta_solicitante='".$P."' and t1.cod_ceco='".$C."' and  t2.cod_clase='".$CODIGOCLASE."'"; 
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila["nombre_subclase"];
		return($Descripcion);	 	
	}	
	function FechaDMA($String)
	{
		$FechaSalida='';
		if(strlen($String)>10)
		{
			$String=substr($String,0,10);
		}
		if($String!='')
		{
		$Fecha=explode('-',$String);
		$FechaSalida=$Fecha[2]."-".$Fecha[1]."-".$Fecha[0];
		}
		return($FechaSalida);
	}
	function FechaAMD($String)
	{
		if(strlen($String)>10)
		{
			$String=substr($String,0,10);
		}
		$Fecha=explode('-',$String);
		$FechaSalida=$Fecha[2]."-".$Fecha[1]."-".$Fecha[0];
		
		return($FechaSalida);
	}
	function FechaDMAH($String)
	{
		$Hora='';
		if(strlen($String)>10)
		{
			$S=explode(' ',$String);
			$String=$S[0];
			$Hora=$S[1];
		}
		$Fecha=explode('-',$String);
		$FechaSalida=$Fecha[2]."-".$Fecha[1]."-".$Fecha[0]." ".$Hora;
		
		return($FechaSalida);
	}
	
	
	/* Fin Funciones IPIF*/
	
	
	
	
	
	
	
	function CantObs($NH,$H)
	{
		$Consulta="select count(*) as cantidad from sget_hoja_ruta_hitos_observaciones ";
		$Consulta.="  where num_hoja_ruta='".$NH."' and cod_hito='".$H."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
		$Cantidad=$Fila[cantidad];
		if($Cantidad > 0)
			$archobs='file_obs.png';
		else
			$archobs='file.png';
		return($archobs);
	
	}
	function FormatearRun($Run)
	{
		$RUT=substr($Run,0,strlen($Run-2));
		$RUT1=substr($Run,0,2);
		$RUT2=substr($Run,2,3);
		$RUT3=substr($Run,5,3);
		$RUT4=substr($Run,8,2);
		
		$RUT=$RUT1.".".$RUT2.".".$RUT3."".$RUT4;
		return($RUT);
	}
	function FormatearNombre($Nombre)
	{
		$Nom=ucwords(strtolower($Nombre));
		return($Nom);
	}
	function FechaHoraActual()
	{
		$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S�bado");
		$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$str_dia = date("w");
		$str_dia = $str_dia;
		$dia = date("j");
		$mes = date("n");
		$mes = $mes - 1;
		$ano = date("Y");
		$hora = date("H");
		$min = date("i");
		$FormatFecha= $Dias[$str_dia]." ".$dia." de ".$Meses[$mes]." de ".$ano." ".$hora.":".$min;
		return($FormatFecha);
	}
	
	
	function Registra_Autorizacion($NumHoja,$Rut,$Funcionario,$Estado,$Hito,$CodEstado)
	{
		$FechaHora= date("Y-m-d G:i:s");
		$Insertar="insert into sget_registro_actividad(rut,num_hoja_ruta,rut_funcionario,fecha_hora,estado,hito,cod_estado) values(";
		$Insertar.="'".$Rut."','".$NumHoja."','".$Funcionario."','".$FechaHora."','".$Estado."','".$Hito."','".$CodEstado."')";
		mysql_query($Insertar);	
	}
	function edad($edad){
		list($anio,$mes,$dia) = explode("-",$edad);
		$anio_dif = date("Y") - $anio;
		$mes_dif = date("m") - $mes;
		$dia_dif = date("d") - $dia;
		if ($dia_dif < 0 || $mes_dif < 0)
		$anio_dif--;
		return $anio_dif;
	}
	function FormatoFechaAAAAMMDD($FechaReal)
	{
		//echo "fecha1".$FechaReal."<br>";
		if($FechaReal!='')
		{
			$Datos = explode("/",$FechaReal);
			$Dia=$Datos[2];
			$Mes=$Datos[1];
			$A�o=$Datos[0];
			$FechaFormat=$Dia.'-'.$Mes.'-'.$A�o;
			//echo "fecha2".$FechaFormat."<br>";
		}
		else
			$FechaFormat='0000-00-00';
		return ($FechaFormat);
	}
	function FormatoFechaAAAAMMDD2($FechaReal)
	{
		//echo "Fecha: ".$FechaReal."<br>";
		if($FechaReal!='')
		{
			$Datos = explode("/",$FechaReal);
			$Dia=$Datos[2];
			$Mes=$Datos[1];
			$A�o=$Datos[0];
			//$FechaFormat=$Dia.'-'.$Mes.'-'.$A�o;
			$FechaFormat=$A�o.'-'.$Mes.'-'.$Dia;
			//echo "fecha2".$FechaFormat."<br>";
		}
		else
			$FechaFormat='0000-00-00';
		return ($FechaFormat);
	}
	function ValidaEntero($Cod)
	{
		if($Cod=='S'||$Cod==''||$Cod=='-1')
			$Cod=0;
		else
			$Cod=$Cod;	
		return($Cod);
	}
	function DescripCtto($Ctto)
	{
		$Consulta="select * from sget_contratos where cod_contrato='".$Ctto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[cod_contrato].'~'.$Fila["descripcion"].'~'.$Fila[fecha_inicio].'~'.$Fila[fecha_termino].'~'.$Fila[cod_gerencia].'~'.$Fila[cod_area].'~'.$Fila[cod_tipo_contrato].'~'.$Fila[rut_prev];
		return($Descripcion);	
	}

	function DescripEmpresa($RutEmp)
	{
		$Consulta="select * from sget_contratistas where rut_empresa='".$RutEmp."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[rut_empresa].'~'.$Fila[razon_social].'~'.$Fila[calle].'~'.$Fila[telefono_comercial].'~'.$Fila[mail_empresa].'~'.$Fila[cod_mutual_seguridad].'~'.$Fila[fecha_ven_cert].'~'.$Fila[nro_regic].'~'.$Fila[nro_registro];
		return($Descripcion);	
	}
	function AdmCodelco($Rut)
	{
		$Consulta="select t1.rut_adm_contrato,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono,t1.email from sget_administrador_contratos t1 where t1.rut_adm_contrato='".$Rut."' ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contrato].'~'.$Fila[nombres].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono].'~'.$Fila[email];
		return($AdmCodelco);	
	}

	function AdmCttoCodelcoHR($HR)
	{
		$Consulta="select t1.rut_adm_contrato,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono,t1.email from sget_administrador_contratos t1 inner join sget_hoja_ruta_adm_ctto t2 on t1.rut_adm_contrato =t2.rut_adm_ctto where t2.num_hoja_ruta='".$HR."' and activo='S'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contrato].'~'.$Fila[nombres].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono].'~'.$Fila[email];
		return($AdmCodelco);	
	}

	function AdmCttoCodelco($Ctto)
	{
		$Consulta="select t1.rut_adm_contrato,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono from sget_administrador_contratos t1 inner join sget_contratos t2 on t1.rut_adm_contrato =t2.rut_adm_contrato where t2.cod_contrato='".$Ctto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contrato].'~'.$Fila[nombres].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono];
		return($AdmCodelco);	
	}
	
	function AdmCttoContratista($Ctto)
	{
		$Consulta=" select t1.rut_adm_contratista,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.telefono,t1.email ";
		$Consulta.=" from sget_administrador_contratistas t1 inner join sget_contratos t2 ";
		$Consulta.=" on t1.rut_adm_contratista =t2.rut_adm_contratista where t2.cod_contrato='".$Ctto."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$AdmCodelco=$Fila[rut_adm_contratista].'~'.$Fila[nombres].'~'.$Fila[ape_paterno].'~'.$Fila[ape_materno].'~'.$Fila[telefono].'~'.$Fila[email];
		return($AdmCodelco);	
	}
	function DescripTipoCtto($Cod)
	{
		$Consulta=" select * from sget_tipo_contrato  ";
		$Consulta.="  where cod_tipo_contrato='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[descrip_tipo_contrato];
		return($Descripcion);	
	}
	
	function DescripcionMutual($Cod)
	{
		$Consulta=" select * from sget_mutuales_seg  ";
		$Consulta.="  where cod_mutual='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila["abreviatura"];
		return($Descripcion);	
	}
	function DescripcionCiudad($Cod)
	{
		$Descripcion='';
		$Consulta=" select nom_ciudad from sget_ciudades  ";
		$Consulta.="  where cod_ciudad='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[nom_ciudad];
		return($Descripcion);	
	}
	function DescripcionComuna($Cod)
	{
		$Descripcion='';
		$Consulta=" select nom_comuna from sget_comunas  ";
		$Consulta.="  where cod_comuna='".$Cod."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[nom_comuna];
		return($Descripcion);	
	}
	function DescripcionGerencia($Cod)
	{
		$Consulta=" select descrip_gerencias from sget_gerencias  ";
		$Consulta.="  where cod_gerencia='".$Cod."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[descrip_gerencias];
		return($Descripcion);	
	}

	function DescripcionArea($Cod)
	{
		$Consulta=" select descrip_area,cod_cc from sget_areas ";
		$Consulta.="  where cod_area='".$Cod."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[cod_cc]." - ".$Fila[descrip_area];
		return($Descripcion);	
	}
	function DescripcionPrev($RutPrev)
	{
		$Consulta=" select * from sget_prevencionistas  ";
		$Consulta.="  where rut_prev='".$RutPrev."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Consulta = "select * from proyecto_modernizacion.clase where cod_clase = '".$Fila[cod_clase]."'   ";
			$Resp1=mysql_query($Consulta);
			$Fila1=mysql_fetch_array($Resp1);
			$Consulta = "select * from proyecto_modernizacion.sub_clase  where cod_clase='".$Fila[cod_clase]."' and cod_subclase='".$Fila["cod_subclase"]."'  ";
			$Resp3=mysql_query($Consulta);
			$Fila3=mysql_fetch_array($Resp3);
			if($Fila3["nombre_subclase"] != "" )
				$SubClase='('.$Fila3["nombre_subclase"].')';
			else	
				$SubClase='';
			$Prevencionista=$Fila[nombres].'~'.$Fila["apellido_paterno"].'~'.$Fila["apellido_materno"].'~'.$Fila[nro_registro].'~'.$Fila[telefono].'~'.$Fila1[nombre_clase].' '.$SubClase;;
		}
		return($Prevencionista);	
	}
	function SubContratista($CmbEmpresa)
	{
		$Consulta=" select * from sget_sub_contratistas  ";
		$Consulta.="  where rut_contratista='".$CmbEmpresa."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Var='S';
		else	
			$Var='N';
		return($Var);	
	}
	function DescripcionRazonSocial($RutE)
	{
		$Consulta=" select * from sget_contratistas  ";
		$Consulta.="  where rut_empresa='".$RutE."' ";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=$Fila[razon_social];
		return($Descripcion);	
	}
	
	function RetornoPagina($CodSistema,$CodPantalla)
	{
		$Consulta=" select link from proyecto_modernizacion.pantallas  ";
		$Consulta.="  where cod_pantalla='".$CodPantalla."' and cod_sistema='".$CodSistema."'";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
			$Descripcion=substr($Fila[link],12,strlen($Fila[link]));
		return($Descripcion);	
	}
	function ContabHitosAdm($NH,$P)
	{
		$Consulta=" select count(*) as cantidad from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."'  ";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
			$Cant=$Fila[cantidad];
		$Consulta=" select count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."' and t2.autorizado='S'  ";
		//echo $Consulta;
		$Resp2=mysql_query($Consulta);
		$Fila2=mysql_fetch_array($Resp2);
			$CantAut=$Fila2[cantau];
		/*echo "cantidad".$Cant."<br>";
		echo "cantidad_aut".$CantAut."<br>";*/
		if($Cant > 0 )
		{
			if($CantAut > 0)
				$Rech='N';
			else
				$Rech='S';
		 }
		 else
		 	$Rech='S';
		return($Rech);	
	}
	function Registra_Estados($NumHoja,$Fecha,$Rut,$CodPant,$CodEst,$AR,$Tipo)
	{
		$FechaHora= date("Y-m-d G:i:s");
		$Actualizar="UPDATE sget_hoja_ruta set cod_estado='$CodEst' where num_hoja_ruta='".$NumHoja."'";
		mysql_query($Actualizar);
		$Actualizar="UPDATE sget_reg_estados set ult='' where num_hoja_ruta='".$NumHoja."'";
		mysql_query($Actualizar);
		$Insertar="insert into sget_reg_estados(num_hoja_ruta,cod_estado,fecha_hora,rut,acept_rech,tipo,ult) values(";
		$Insertar.="'".$NumHoja."','".$CodEst."','".$FechaHora."','".$Rut."','".$AR."','".$Tipo."','S')";
		mysql_query($Insertar);	
	}
	function Registra_Actividad($NumHoja,$Rut,$CodEst,$Tipo)
	{
		$FechaHora= date("Y-m-d G:i:s");
		$Insertar="insert into sget_reg_estados(num_hoja_ruta,cod_estado,fecha_hora,rut,tipo) values(";
		$Insertar.="'".$NumHoja."','".$CodEst."','".$FechaHora."','".$Rut."','".$Tipo."')";
		mysql_query($Insertar);	
	}

	
	function ActualizaRNomina($NumHoja)
	{
		$Actualizar=" UPDATE  sget_hoja_ruta_nomina set ";
		$Actualizar.="estado='R' ";	
		$Actualizar.=" where num_hoja_ruta='".$NumHoja."' ";
		mysql_query($Actualizar);
		//echo $Actualizar;
	}
	function ActualizaGen($NH,$P)
	{
		$Consulta=" select count(*) as cantidad from sget_hitos t1 left join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."'  ";
		$Resp=mysql_query($Consulta);
		$Fila=mysql_fetch_array($Resp);
			$Cant=$Fila[cantidad];
		$Consulta=" select count(*) as cantau from sget_hitos t1 inner join sget_hoja_ruta_hitos t2 on t1.cod_hito=t2.cod_hito and cod_pantalla='".$P."' ";
		$Consulta.="  where t2.num_hoja_ruta='".$NH."' and t2.autorizado='S' ";
		$Resp2=mysql_query($Consulta);
		$Fila2=mysql_fetch_array($Resp2);
			$CantAut=$Fila2[cantau];
		if($Cant > 0 )
		{
			if($CantAut > 0)
			{	
				if($Cant==$CantAut)
				{
					switch($P)
					{
						case "15"://Autoriza Adm Contratos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=4,cod_estado_pantalla=3 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "16":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=6,cod_estado_pantalla=5 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "19":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=2,cod_estado_pantalla=2 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
					}
				}
				else
				{
					switch($P)
					{
						case "15"://Autoriza Adm Contratos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 2 ,cod_estado_pantalla=3 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "16":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=5, cod_estado_pantalla=5 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "19":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=1,cod_estado_pantalla=2 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
					}
				}	
		 	}
			else
			{
				switch($P)
				{
						case "15"://Autoriza Adm Contratos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado= 2 ,cod_estado_pantalla=3 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "16":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=5, cod_estado_pantalla=5 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
						case "19":////Autoriza Gestion de Riesgos
							$Actualizar="UPDATE sget_hoja_ruta set cod_estado_aprobado=1,cod_estado_pantalla=2 where num_hoja_ruta='".$NH."'";
							mysql_query($Actualizar);
						break;
				}
			}
		 }
	}
	function CalculaReajuste()
	{
		//REAJUSTE CONTRATO
		$Consulta="select cod_contrato,corr from sget_reajustes_contratos where tipo='C' and estado='P' and fecha_reajustada <='".date('Y-m-d')."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$PromIpcAcum=0;
			$Consulta="select fecha_inicio,monto_ctto from sget_contratos where cod_contrato='".$Fila[cod_contrato]."'";
			//echo $Consulta."<br>";
			$RespCtto=mysql_query($Consulta);
			$FilaCtto=mysql_fetch_array($RespCtto);
			$PromIpcAcum=EntregaValorIpc($FilaCtto[fecha_inicio]);
			//echo $PromIpcAcum."<br>";
			if($PromIpcAcum!=0)
			{
				$NewMonto=round($FilaCtto[monto_ctto]+(($FilaCtto[monto_ctto]*$PromIpcAcum)/100));
				$Actualizar="UPDATE  sget_reajustes_contratos SET monto_reajustado='".$NewMonto."',estado='L' where cod_contrato='".$Fila[cod_contrato]."' and corr='".$Fila["corr"]."'";
				//echo $Actualizar;
				mysql_query($Actualizar);
			}
		}
		//REAJUSTE SUELDO TRABAJADORES DEL CONTRATO
		$Consulta="select cod_contrato,corr from sget_reajustes_contratos where tipo='S' and estado='P' and fecha_reajustada <='".date('Y-m-d')."'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			$PromIpcAcum=0;
			$Consulta="select fecha_inicio from sget_contratos where cod_contrato='".$Fila[cod_contrato]."'";
			$RespCtto=mysql_query($Consulta);
			$FilaCtto=mysql_fetch_array($RespCtto);
			$PromIpcAcum=EntregaValorIpc($FilaCtto[fecha_inicio]);
			if($PromIpcAcum!=0)
			{
				$Consulta="select rut,sueldo,cod_contrato,rut_empresa,fec_ini_ctto,fec_fin_ctto from sget_personal where cod_contrato='".$Fila[cod_contrato]."' and estado='A' ";
				//echo $Consulta;
				$RespPers=mysql_query($Consulta);
				while($FilaPers=mysql_fetch_array($RespPers))
				{
					$NewMonto=round($FilaPers[sueldo]+(($FilaPers[sueldo]*$PromIpcAcum)/100));
					$Insertar="insert into sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino) values('".$FilaPers[cod_contrato]."','".$FilaPers[rut_empresa]."','".str_pad(trim($FilaPers[rut]),10,'0',STR_PAD_LEFT)."','S','".$FilaPers[fec_ini_ctto]."','".$FilaPers[fec_fin_ctto]."',".intval(str_replace('.','',$NewMonto)).")";		
					//echo $Insertar."<br>";
					mysql_query($Insertar);				
				}
				$Actualizar="UPDATE  sget_reajustes_contratos SET estado='L' where cod_contrato='".$Fila[cod_contrato]."' and corr='".$Fila[corr]."'";
				//echo $Actualizar;
				mysql_query($Actualizar);
			}
		}
		
	}
	function EntregaValorIpc($FechaIniCtto)
	{
		$Fecha=explode('-',$FechaIniCtto);
		$A�o=$Fecha[0];
		$Mes=$Fecha[1];
		$Dia=0;
		//echo "FECHA: ".$FechaIniCtto."<br>";
		//echo "FECHA: ".date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1));
		$FechaAux=explode('-',date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1)));
		$ValorIpc1=0;
		$Consulta="select valor from sget_ipc where ano='".$A�o."' and mes='".intval($FechaAux[1])."'";
		//echo $Consulta;
		$RespIpc=mysql_query($Consulta);
		if($FilaIpc=mysql_fetch_array($RespIpc))
		{
			$ValorIpc1=$FilaIpc[valor];
		}
		$Fecha=explode('-',date('Y-m-d'));
		$A�o=$Fecha[0];
		$Mes=$Fecha[1];
		$Dia=0;
		$FechaAux=explode('-',date('Y-m-d',mktime(0,0,0,$Mes,$Dia,$A�o,1)));
		$ValorIpc2=0;
		$Consulta="select valor from sget_ipc where ano='".$A�o."' and mes='".intval($FechaAux[1])."'";
		//echo $Consulta;
		$RespIpc=mysql_query($Consulta);
		if($FilaIpc=mysql_fetch_array($RespIpc))
		{
			$ValorIpc2=$FilaIpc[valor];
		}
		//echo $ValorIpc1."<br>";
		//echo $ValorIpc2."<br>"; 
		if($ValorIpc1!=0)
			$Result=$ValorIpc2/$ValorIpc1;
		else
			$Result=0;
		//echo $Result;	
		return($Result);	
		
				
	}
	function resta_fechas($fecha1,$fecha2)
	{
		 // echo "f_1".$fecha1."<br>"; 
		  //echo "f_2".$fecha2."<br>"; 
		  if($fecha1 != '0000-00-00' && $fecha2 != '0000-00-00')
		  {
			  $fecha1=substr($fecha1,8,2)."-".substr($fecha1,5,2)."-".substr($fecha1,0,4);
			  $fecha2=substr($fecha2,8,2)."-".substr($fecha2,5,2)."-".substr($fecha2,0,4);
			  //echo "f1".$fecha1."<br>";
			  //echo "f2".$fecha2."<br>";
			  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
					  list($dia1,$mes1,$a�o1)=split("-",$fecha1);
			  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
					  list($dia1,$mes1,$a�o1)=split("-",$fecha1);
			  if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
					  list($dia2,$mes2,$a�o2)=split("-",$fecha2);
			  if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
					  list($dia2,$mes2,$a�o2)=split("-",$fecha2);
			  $dif = mktime(0,0,0,$mes1,$dia1,$a�o1,1) - mktime(0,0,0,$mes2,$dia2,$a�o2,1);
			  //echo "dif".$dif."<br>";
			  $ndias=floor($dif/(24*60*60));
			 //echo "DIAS:".$ndias."<br><br>";
		 }
		 else 
			 $ndias=0;
		  return($ndias);
	}
	function RecuperaUltHito($HR,$Est,$Rut,$AcepRech,$Tipo)
	{
		$Fecha='';
		$Consulta="select fecha_hora from sget_reg_estados where num_hoja_ruta='".$HR."' and cod_estado='".$Est."' and rut='".$Rut."'";
		$Consulta.=" and acept_rech='".$AcepRech."' and tipo='".$Tipo."' and ult='S'";
		//echo $Consulta;
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$Fecha=$Fila["fecha_hora"];
		}
		return($Fecha);
	}
	function PersonasActivasCtto($Ctto)
	{
		$Consulta="select count(rut) as Cantidad from sget_personal where cod_contrato='".$Ctto."' and estado='A'";
		$RespCant=mysql_query($Consulta);
		if($FilaCant=mysql_fetch_array($RespCant))
			return($FilaCant[Cantidad]);
		else
			return(0);
	}	
	function PersonasSindicalizCtto($Ctto)
	{
		$Consulta="select count(rut) as Cantidad from sget_personal where cod_contrato='".$Ctto."' and cod_sindicato<>'0' and estado='A'";
		$RespCant=mysql_query($Consulta);
		if($FilaCant=mysql_fetch_array($RespCant))
			return($FilaCant[Cantidad]);
		else
			return(0);
	}	
	function SindicatosCtto($Ctto)
	{
		$Sind='';
		$Consulta="select t2.descripcion from sget_personal t1 inner join sget_sindicato t2 on t1.cod_sindicato=t2.cod_sindicato where t1.cod_contrato='".$Ctto."' and t1.cod_sindicato<>'0' and t1.estado='A' group by t1.cod_sindicato ";
		//echo $Consulta;
		$RespCant=mysql_query($Consulta);
		while($FilaCant=mysql_fetch_array($RespCant))
		{
			$Sind=$Sind.$FilaCant["descripcion"].", ";
		}
		if($Sind!='')
			$Sind=substr($Sind,0,strlen($Sind)-2);
		return($Sind);		
	}
	function DotacionSegAcc($Ctto)
	{
		$Consulta="select count(rut) as Cantidad from sget_personal where cod_contrato='".$Ctto."' and cod_aseguradora not in(0,1) and estado='A'";
		$RespCant=mysql_query($Consulta);
		if($FilaCant=mysql_fetch_array($RespCant))
			return($FilaCant[Cantidad]);
		else
			return(0);
	}	
	function PersonasBonosCttoAnual($Ctto,$A�o)
	{
		$Consulta="select * from sget_bonos_contratistas where cod_contrato='".$Ctto."' and ano='".$A�o."' group by cod_contrato,ano,rut_persona";
		//echo $Consulta;
		$RespCant=mysql_query($Consulta);
		if($FilaCant=mysql_num_rows($RespCant))
			return($FilaCant=mysql_num_rows($RespCant));
		else
			return(0);
	}	
	function NumPolizaCtto($Ctto)
	{
		$Consulta="select poliza from sget_contratos where cod_contrato='".$Ctto."'";
		$RespPol=mysql_query($Consulta);
		if($FilaPol=mysql_fetch_array($RespPol))
			return($FilaPol[poliza]);
		else
			return('');
	}	
	
?>