<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
//echo "EEEE".$Proceso;
switch($Proceso)
{
	case "AG"://AGREGA CABECERA
	
		$Consulta="SELECT max(num_hoja_ruta) as num_hoja from sget_hoja_ruta ";
		$RespSolp=mysqli_query($link, $Consulta);
		if($FilaHoja=mysql_fetch_array($RespSolp))
		{
			if (substr($FilaHoja["num_hoja"],0,4) == date("Y"))
				$TxtHoja =$FilaHoja["num_hoja"]+1;										
			else
				$TxtHoja=date("Y")."00001";	
		}
		else
			$TxtHoja=date("Y")."00001";	
		$Inserta="INSERT INTO sget_hoja_ruta (num_hoja_ruta,fecha_ingreso,rut_ingresador,fecha_tramitacion,rut_empresa,cod_contrato, ";
		$Inserta.=" cod_estado_pantalla,cod_estado_aprobado)";
		$Inserta.=" values('".$TxtHoja."','".$Fecha_Creacion."','".$Rut."','".$Fecha_Sistema."','".$CmbEmpresa."','".$CmbContrato."','1','1')";
		//echo $Inserta."<br>";
		mysql_query($Inserta);
		Registra_Estados($TxtHoja,$Fecha_Creacion,$Rut,'11','1','','E');
		$Consulta = "SELECT * from sget_hitos ";
		$Consulta.=" where cod_sistema='30' and cod_pantalla IN ('14','15','16','18')  ";
		$RespH = mysqli_query($link, $Consulta);
		while ($FilaH=mysql_fetch_array($RespH))
		{
			$Inserta="INSERT INTO sget_hoja_ruta_hitos (num_hoja_ruta,cod_hito)";
			$Inserta.=" values('".$TxtHoja."','".$FilaH[cod_hito]."')";
			//echo $Inserta."<br>";
			mysql_query($Inserta);
		}
		$VarCodelco=AdmCttoCodelco($CmbContrato);
		$array=explode('~',$VarCodelco);
		$RuAdm=$array[0];
		$Insertar="INSERT INTO sget_hoja_ruta_adm_ctto (num_hoja_ruta,rut_adm_ctto,activo,tipo,observacion) values ('".$TxtHoja."','".$RuAdm."','S','O','')";
		mysql_query($Insertar);
		header("location:sget_hoja_ruta.php?Opt=M&TxtHoja=".intval($TxtHoja)."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato);
	break;
	case "M":
	case "AN"://AGREGA NOMINA

		$Consulta="SELECT * from sget_hoja_ruta_nomina where num_hoja_ruta ='".$TxtHoja."' and rut_personal='".$TxtRut."'";
		$RespExi=mysqli_query($link, $Consulta);
	//	echo "RR".$Consulta;
		if(!$Fila=mysql_fetch_array($RespExi))
		{	
			$Inserta="INSERT INTO sget_hoja_ruta_nomina (num_hoja_ruta,rut_personal,estado)";
			$Inserta.=" values('".$TxtHoja."','".$TxtRut."','A')";
			mysql_query($Inserta);	
		}
		$Consulta="SELECT * from sget_personal where rut ='".$TxtRut."' ";
		$Resp=mysqli_query($link, $Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
				if($TxtFechaCert=='')
					$TxtFechaCert='0000-00-00';
				//$TxtNumeroCert=number_format($TxtNumeroCert,0,",",".");	
				$Actualizar=" UPDATE  sget_personal set ";
				$Actualizar.="nombres='".strtoupper($TxtNom)."',ape_paterno='".strtoupper($TxtPat)."',ape_materno='".strtoupper($TxtMat)."',fec_nac='".FormatoFechaAAAAMMDD($TxtFechaNac)."',cargo='".$CmbCargo."',tipo='".ValidaEntero($CmbTipoPersona)."',direccion='".strtoupper($TxtDir)."',cod_ciudad='".ValidaEntero($CmbCiudad)."',cod_comuna='".ValidaEntero($CmbComunas)."',";
				$Actualizar.="telefono1='".$TxtFono1."',telefono2='".$TxtFono2."',rut_empresa='".$CmbEmpresa."',cod_contrato='".$CmbContrato."',";
				$Actualizar.="estado='".$Est."',observacion='".$TxtObs."',cod_region='".$CmbRegion."',";
				if($TxtTarj=='Provisoria'||$TxtTarj=='Provisor')
					$Actualizar.="nro_tarjeta='".trim($TxtTarj)."',";
				else
					$Actualizar.="nro_tarjeta='".str_pad(trim($TxtTarj),8,'0',STR_PAD_LEFT)."',";					
				$Actualizar.="certificado_ant='".$CertAnt."',fec_ini_ctto='".$TxtFecIniCtto."',fec_fin_ctto='".$TxtFecFinCtto."',sueldo=".intval(str_replace('.','',$TxtSueldo)).",cod_afp='".ValidaEntero($CmbAfp)."',cod_sindicato='".ValidaEntero($CmbSindicato)."',cod_turno='".ValidaEntero($CmbTurnos)."',fecha_certif='".$TxtFechaCert."' ";	
				$Actualizar.=",sexo='".$Sexo."',beca='".$Beca."',cod_salud='".ValidaEntero($CmbSalud)."',cargas_familiares='".intval($TxtCargas)."',cod_aseguradora='".intval($CmbAseguradora)."',tipo_ctto='".intval($CmbTipoCtto)."',tipo_educ='".intval($CmbEscolaridad)."',num_cert_antecedentes='".str_replace(".","",$TxtNumeroCert)."' where rut='".$TxtRut."'";
				mysql_query($Actualizar);
				if($Archivo!='none')
				{
					$Extension=explode('.',$Archivo);
					if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
					{
						$Directorio='fotos';
						$NombreArchivo=str_pad(strtoupper($TxtRut),10,'0',STR_PAD_LEFT).".jpg";
						copy($Archivo, $Directorio."/".$NombreArchivo);
					}
				}
				$Consulta="SELECT * from sget_personal_historia where cod_contrato='".$CmbContrato."' and rut_empresa='".$CmbEmpresa."' and rut='".$TxtRut."'";
				$Resp=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Resp))
				{	
					$Actualizar="UPDATE sget_personal_historia set activo='N' where rut='".$TxtRut."'";  
					mysql_query($Actualizar);
					if($TxtFecFinCtto=='')
					$TxtFecFinCtto='0000-00-00';
					if($TxtFecIniCtto=='')
					$TxtFecIniCtto='0000-00-00';
					$Insertar="INSERT INTO sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino) values('".$CmbContrato."','".$CmbEmpresa."','".str_pad(trim($TxtRut),10,'0',STR_PAD_LEFT)."','S','".$TxtFecIniCtto."','".$TxtFecFinCtto."',".intval(str_replace('.','',$Sueldo)).")";		
					mysql_query($Insertar);				
				}
		}	
		else
		{	  
			if($TxtFechaCert=='')
				$TxtFechaCert='0000-00-00';
			    $Insertar="INSERT INTO sget_personal(rut,nombres,ape_paterno,ape_materno,fec_nac,cargo,tipo,cod_ciudad,cod_comuna,fec_ini_ctto,fec_fin_ctto,certificado_ant,direccion,telefono1,telefono2,rut_empresa,cod_contrato,estado,observacion,nro_tarjeta,sueldo,cod_sindicato,cod_turno,cod_afp,fecha_certif,sexo,beca,cod_salud,cod_region,cargas_familiares,cod_aseguradora,tipo_ctto,tipo_educ,num_cert_antecedentes) values (";
				$Insertar.="'".str_pad(trim($TxtRut),10,'0',STR_PAD_LEFT)."','".strtoupper($TxtNom)."','".strtoupper($TxtPat)."','".strtoupper($TxtMat)."','".		FormatoFechaAAAAMMDD($TxtFechaNac)."','".$CmbCargo."','".ValidaEntero($CmbTipoPersona)."','".ValidaEntero($CmbCiudad)."','".ValidaEntero($CmbComuna)."','".	$TxtFecIniCtto."','".$TxtFecFinCtto."','".$CertAnt."','".strtoupper($TxtDir)."','".$TxtFono1."','".$TxtFono2."',";
				$Insertar.="'".$CmbEmpresa."','".$CmbContrato."','".$Est."','".$TxtObs."',";
				if($TxtTarj=='Provisoria'||$TxtTarj=='Provisor')
					$Insertar.="'".trim($TxtTarj)."'";
				else
					$Insertar.="'".str_pad(trim($TxtTarj),8,'0',STR_PAD_LEFT)."'";	
				$Insertar.=",".intval(str_replace('.','',$Sueldo)).",'".ValidaEntero($CmbSindicato)."','".ValidaEntero($CmbTurnos)."','".ValidaEntero($CmbAfp)."','".$TxtFechaCert."','".$Sexo."','".$Beca."','".ValidaEntero($CmbSalud)."','".$CmbRegion."','".intval($TxtCargas)."','".intval($CmbAseguradora)."','".intval($CmbTipoCtto)."','".intval($CmbEscolaridad)."','".str_replace(".","",$TxtNumeroCert)."')";
				mysql_query($Insertar);
			//echo $Insertar;
				if($Archivo!='none')
				{
					$Extension=explode('.',$Archivo);
					if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
					{
						$Directorio='fotos';
						$NombreArchivo=str_pad(strtoupper($TxtRut),10,'0',STR_PAD_LEFT).".jpg";
						//echo $NombreArchivo;
						copy($Archivo, $Directorio."/".$NombreArchivo);
					}
				}
				if($TxtFecFinCtto=='')
					$TxtFecFinCtto='0000-00-00';
				if($TxtFecIniCtto=='')
					$TxtFecIniCtto='0000-00-00';
				$Insertar="INSERT INTO sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino,sueldo) values('".$CmbContrato."','".$CmbEmpresa."','".str_pad(trim($TxtRut),10,'0',STR_PAD_LEFT)."','S','".$TxtFecIniCtto."','".$TxtFecFinCtto."',".intval(str_replace('.','',$Sueldo)).")";		
				mysql_query($Insertar);	
				//echo "poly".$Insertar;
		}
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProceso.action='sget_hoja_ruta.php?Opt=M&Buscar=STxtHoja=".intval($TxtHoja)."&CmbEmpresa=".$CmbEmpresaO."&CmbContrato=".$CmbContratoO."';";
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();</script>";  	
	break;  
	case "BuscaRut":
		$Consulta="SELECT * from sget_personal where rut ='".str_pad(trim($TxtRutPer),10,'0',STR_PAD_LEFT)."' ";
		//echo "NN".$Consulta;
		$FechaSistema=date('Y-m-d');
		$Resp=mysqli_query($link, $Consulta);
		$Existe=false;
		if($Fila=mysql_fetch_array($Resp))
		{
		
			if($Fila["cod_contrato"]!=$CmbContrato)
			{
				$dif=resta_fechas($FechaSistema,$Fila[fec_fin_ctto]);
				if($dif>0)
				{
					$Existe=true;
				}
			}
			else
			{
				$Existe=true;
			}
			if($Existe==true)
			{
				$Consulta="SELECT * from sget_hoja_ruta_nomina where num_hoja_ruta ='".$TxtHoja."' and rut_personal='".str_pad(trim($TxtRutPer),10,'0',STR_PAD_LEFT)."'";
				$RespExi=mysqli_query($link, $Consulta);
					//echo "ggggg".$Consulta;
				if(!$Fila2=mysql_fetch_array($RespExi))
				{	
					$Inserta="INSERT INTO sget_hoja_ruta_nomina (num_hoja_ruta,rut_personal,estado)";
					$Inserta.=" values('".$TxtHoja."','".str_pad(trim($TxtRutPer),10,'0',STR_PAD_LEFT)."','A')";
					//echo "inse".$Inserta;
					mysql_query($Inserta);
					if($Fila["cod_contrato"]!=$CmbContrato||$Fila[rut_empresa]!=$CmbEmpresa)
					{
						$DatosCtto=DescripCtto($CmbContrato);
						$ArrayCtto=explode('~',$DatosCtto);
						$FecIniCtto=$ArrayCtto[2];
						$FecFinCtto=$ArrayCtto[3];
						$Actualizar="UPDATE sget_personal set cod_contrato='".$CmbContrato."',rut_empresa='".$CmbEmpresa."',fec_ini_ctto='".$FecIniCtto."',fec_fin_ctto='".$FecFinCtto."' where rut ='".str_pad(trim($TxtRutPer),10,'0',STR_PAD_LEFT)."' ";
						mysql_query($Actualizar);
						//echo "GGGGG".$Actualizar."<br>";
						$TxtRut=$TxtRutPer.'-'.$TxtDv;
						$Insertar="INSERT INTO sget_personal_historia(cod_contrato,rut_empresa,rut,activo,fecha_ingreso,fecha_termino,sueldo) values('".$CmbContrato."','".$CmbEmpresa."','".str_pad(trim($TxtRut),10,'0',STR_PAD_LEFT)."','S','".$FecIniCtto."','".$FecFinCtto."',".$Fila[sueldo].")";		
						mysql_query($Insertar);
						//echo "zzzzz".$Insertar;	
					}
				}
			header("location:sget_hoja_ruta.php?Opt=M&TxtHoja=".intval($TxtHoja)."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&EsPopup=".$EsPopup);
			}
			else
			{
			header("location:sget_hoja_ruta.php?Opt=M&TxtHoja=".intval($TxtHoja)."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&EsPopup=".$EsPopup."&Cadena=.".$TxtRutPer.".,");
			}	
		}
		else
			header("location:sget_hoja_ruta.php?Opt=M&TxtHoja=".intval($TxtHoja)."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&EsPopup=".$EsPopup."&Error=RUTNO");
	break;
	case "N":
		header("location:sget_hoja_ruta.php");
	break;
	case "EN":
		$Eliminar=" delete from sget_hoja_ruta_nomina where num_hoja_ruta='".$TxtHoja."' and rut_personal='".$RutEmpresa."' ";
		mysql_query($Eliminar); 
		header("location:sget_hoja_ruta.php?Opt=M&TxtHoja=".intval($TxtHoja)."&CmbEmpresa=".$CmbEmpresa."&CmbContrato=".$CmbContrato."&EsPopup=".$EsPopup);
	break;
	case "MH":
		$Consulta="SELECT * from sget_hoja_ruta where num_hoja_ruta='".$TxtHoja."'  ";
		$RespSolp=mysqli_query($link, $Consulta);
		if($FilaHoja=mysql_fetch_array($RespSolp))
		{
			$Contrato=$FilaHoja[num_hoja_ruta];
			$Empresa=$FilaHoja[rut_empresa];
		}
		/*echo $Contrato."<br>";
		echo $Empresa."<br>";*/
		//$Actualizar="UPDATE sget_hoja_ruta set rut_empresa='".$CmbEmpresa."' ,  cod_contrato='".$CmbContrato."' where num_hoja_ruta='".$TxtHoja."' ";
		//mysql_query($Actualizar)
		
	break;
	
}



?>