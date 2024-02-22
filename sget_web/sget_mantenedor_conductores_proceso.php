<? include("../principal/conectar_sget_web.php");


if ($Opc=='M')
{
	$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
	$RC=mysql_query($ConsultaC);
	$FC=mysql_fetch_array($RC);
	$AnoDAS=$FC["valor_subclase1"];
	$AnoPreo=$FC["valor_subclase2"];
	$Ano2Ocu=$FC[valor_subclase3];

	$Consulta="SELECT * from sget_conductores where corr_conductor = '".$CorrCond."'";
	//echo $Consulta;
	 $Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		//$TxtRutPrv=str_pad($Fila["rut_empresa"],10,'0',l_pad);
		$CodConductor=$Fila["corr_conductor"];
		$TxtRut=$Fila["rut"];
		$TxtNombre=$Fila["nombres"];
		$TxtPaterno=$Fila["apellido_paterno"];
		$TxtMaterno=$Fila["apellido_materno"];
		$CmbTipo=$Fila["tipo_licencia"];
		$TxtVigMuni=$Fila["fecha_vig_licencia"];
		$TxtRestric=$Fila["restriccion_licencia"];
		$TxtExaPreocu=$Fila["fecha_exa_preoc"];
		$TxtExaPreocu2=explode('-',$Fila["fecha_exa_preoc"]);
		$TxtExaPreocu2[0]=$TxtExaPreocu2[0]+$AnoPreo;
		$FechaTerminoPreo=$TxtExaPreocu2[0]."-".$TxtExaPreocu2[1]."-".$TxtExaPreocu2[2];
		if($FechaTerminoPreo< date('Y-m-d'))	
			$FechaTerminoPreo="<span class='InputRojo'>".$FechaTerminoPreo."</span>";
		else
			$FechaTerminoPreo=$FechaTerminoPreo;	
		
		$TxtInstPreocupa=$Fila["institu_realiza_exam_preoc"];
		$TxtVigExamPST=$Fila["fecha_exa_pst"];
		$TxtInstPST=$Fila["institu_realiza_exam_pst"];
		$TxtFechaHR=$Fila["fecha_hoja_ruta"];
		$TxtNumHR=$Fila["num_hoja_ruta"];
		$TxtFechaCurso=$Fila["fecha_curso_manejo"];
		$TxtRutEmp=$Fila["rut_empresa"];
		$TxtEmpClien=$Fila["empresa"];
		$TxtNContra=$Fila["contrato"];
		$TxtFeOtor=$Fila["fecha_otorga_codelco"];
		$TxtFechaDAS=$Fila["fecha_das_codelco"];
		
		if($TxtFechaDAS=='0000-00-00' && $TxtFechaDAS=='')
		{
			$Consulta="SELECT fecha_das from sget_personal where rut='".$TxtRut."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
				$FechaDAS=$Fila[fecha_das];
		}
		else
			$FechaDAS=explode('-',$Fila[fecha_das_codelco]);
			
		$FechaDAS[0]=$FechaDAS[0]+$AnoDAS;
		$FechaTerminoDAS=$FechaDAS[0]."-".$FechaDAS[1]."-".$FechaDAS[2];
		if($FechaTerminoDAS< date('Y-m-d'))	
			$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
		else
			$FechaTerminoDAS=$FechaTerminoDAS;	
		
		$Obs=$Fila["observacion"];
		$TxtCodumnto=$Fila["hoja_vida_n_docu"];	
		$TxtFechEmiHojaV=$Fila["fecha_hoja_vida"];		
		$TipVehiculo=strtoupper($Fila["tipo_vehiculo"]);
		$CheckedTip1='';
		$CheckedTip2='';
		if($TipVehiculo=='VL')
			$CheckedTip1='checked=checked';
		if($TipVehiculo=='EP')
			$CheckedTip2='checked=checked';
		if($TipVehiculo=='')
			$CheckedTip1='checked=checked';	

		$CheckedA5='';
		$CheckedA4='';
		$CheckedA3='';
		$CheckedA2='';
		$CheckedA1='';
		$CheckedB='';
		$CheckedC='';
		$CheckedD='';
		$Consulta="SELECT * from sget_conductores_licencias where corr_conductor = '".$CorrCond."'";
		//echo $Consulta;
		 $Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			if($Fila[tipo_licencia]=='A5')
				$CheckedA5='checked=checked';
			if($Fila[tipo_licencia]=='A4')
				$CheckedA4='checked=checked';
			if($Fila[tipo_licencia]=='A3')
				$CheckedA3='checked=checked';
			if($Fila[tipo_licencia]=='A2')
				$CheckedA2='checked=checked';
			if($Fila[tipo_licencia]=='A1')
				$CheckedA1='checked=checked';
			if($Fila[tipo_licencia]=='B')
				$CheckedB='checked=checked';
			if($Fila[tipo_licencia]=='C')
				$CheckedC='checked=checked';
			if($Fila[tipo_licencia]=='D')
				$CheckedD='checked=checked';
		}
	//	$CmbEstado=	$Fila["estado"];
	}	
}
if($BusDatos=='S')
{
	$Consulta="SELECT * from sget_personal where rut='".$TxtRut."'";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtNombre=$Fila["nombres"];
		$TxtPaterno=$Fila["ape_paterno"];
		$TxtMaterno=$Fila["ape_materno"];
		$TxtFechaDAS=$Fila[fecha_das];
		$TxtExaPreocu=$Fila[fecha_vigencia_exa_preo];
		$TxtNContra=$Fila["cod_contrato"];
		$TxtRutEmp=$Fila[rut_empresa];
		
		$ConEmp="SELECT razon_social from sget_contratistas where rut_empresa='".$TxtRutEmp."'";
		$REmp=mysql_query($ConEmp);
		$FEmp=mysql_fetch_array($REmp);
		$TxtEmpClien=$FEmp[razon_social];
	}
}
if(!isset($CheckedTip1))
	$CheckedTip1='checked=checked';
?>
<html>
<head>
<?
	if ($Opc=='N')
	{
		echo "<title>Nuevo Conductor</title>";
		$VarTitulo='Nuevo Conductor';
	}
	else	
	{
		echo "<title>Modifica Conductor</title>";
		$VarTitulo='Modifica Conductor';
	}	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function ModificaRut()
{
	var f = document.FrmProceso;
	if (confirm("Esta opci�n reemplazar� rut empresa por nuevo ingresado"))
	{
		f.RutAnt.value = f.TxtRutPrv.value;
		f.NewOpc.value = 'S';
		f.action = "sget_mantenedor_empresas_proceso.php";
		f.submit();
	}
	else
	{
		f.NewOpc.value = "N";
		return;
	}

}
function Proceso(Opcion)
{
	var f= document.FrmProceso;
	var Valida=true;
	var Veri="";
	var TipVehi='VL';
	if(f.TipVe[1].checked==true)
		TipVehi='EP';
	switch(Opcion)
	{
		case "N":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				Liceni=Recuperar(f.name,'Licencias');
				f.action = "sget_mantenedor_conductores_proceso01.php?Opcion="+Opcion+"&LicenciasGua="+Liceni+"&TipVehi="+TipVehi; 
				f.submit();
			}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				Liceni=Recuperar(f.name,'Licencias');
				f.action = "sget_mantenedor_conductores_proceso01.php?Opcion="+Opcion+"&LicenciasGua="+Liceni+"&TipVehi="+TipVehi;
				f.submit();
			}
		break;
		case "R":
			f.action = "sget_mantenedor_empresas_proceso.php?Opcion="+Opcion+"&Rec=S";
			f.submit();
		break;
		case "PB":
			f.action = "sget_mantenedor_conductores_proceso.php?Opc=N&BusDatos=S&TxtRut="+f.TxtRut.value;
			f.submit();
		break;
		case "Mut":
		var	URL = "sget_mantenedor_mutuales_proceso.php?Volver=S&CmbMutuales="+f.CmbMutuales.value;		//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=500,height=250,menubar=no,status=1,resizable=yes,scrollbars=yes");

		break;

	}
}
function Salir()
{
	window.close();
}

function ValidaCampos(Res,Opcion)
{
	var f= document.FrmProceso;

	if (f.TxtRut.value=="")
	{
		alert("Debe Ingresar Rut");
		f.TxtRut.focus();
		Res=false;
		return;
	}
	if(f.TxtRut.value!='')
	{
		var RutDig='';
		RutDig=f.TxtRut.value.split('-');
		if(RutDig[1]=='k')
			RutDig[1]='K';
		f.TxtRut.value=	RutDig[0]+"-"+RutDig[1];
		var VarRut=rut(RutDig[0],RutDig[1]);
		if(VarRut==false)
		{
			alert('Rut incorrecto, ingrese nuevamente.')
			f.TxtRut.focus();
			Res=false;
			return;
		}
	}
	if(f.TxtNombre.value=='')
	{
		alert("Debe ingresar nombres");
		f.TxtNombre.focus();
		Res=false;
		return;
	}
	if (f.TxtPaterno.value=="")
	{
		alert("Debe ingresar apellido paterno");
		f.TxtPaterno.focus();
		Res=false;
		return;
	}
	if (f.TxtMaterno.value=="")
	{
		alert("Debe ingresar apellido materno");
		f.TxtMaterno.focus();
		Res=false;
		return;
	}
	if(f.TxtFechEmiHojaV.value=='')
	{
		alert('Debe seleccionar fecha Hoja Vida')
		f.TxtFechEmiHojaV.focus();
		return;
	}	
	if(f.TxtCodumnto.value=='')
	{
		alert('Debe ingresar N� Hoja Vida')
		f.TxtCodumnto.focus();
		return;
	}	
	var Pasa=SoloUnElementoLicencias(f.name,'Licencias','M');
	if(Pasa==false)
	{
		Res=false;
		return;
	}	
	if (f.TxtVigMuni.value=="")
	{
		alert("Debe seleccionar vigencia municipal");
		f.TxtVigMuni.focus();
		Res=false;
		return;
	}
	/*if (f.TxtRestric.value=="")
	{
		alert("Debe ingresar restricci�n municipal");
		f.TxtRestric.focus();
		Res=false;
		return;
	}*/
/*	if (f.TxtExaPreocu.value=="")
	{
		alert("Debe seleccionar fecha examen preocupacional");
		f.TxtExaPreocu.focus();
		Res=false;
		return;
	}
	if (f.TxtInstPreocupa.value=="")
	{
		alert("Debe ingresar Instituci�n que realizo el examen preocupacional");
		f.TxtInstPreocupa.focus();
		Res=false;
		return;
	}
*/	if (f.TxtVigExamPST.value=="")
	{
		alert("Debe seleccionar fecha de examen PST.");
		f.TxtVigExamPST.focus();
		Res=false;
		return;
	}
/*	if (f.TxtInstPST.value=="")
	{
		alert("Debe ingresar Instituci�n que realizo el examen PST.");
		f.TxtInstPST.focus();
		Res=false;
		return;
	}*/

	if(f.TxtRutEmp.value!='')
	{
		var RutDig='';
		RutDig=f.TxtRutEmp.value.split('-');
		if(RutDig[1]=='k')
			RutDig[1]='K';
		f.TxtRutEmp.value=	RutDig[0]+"-"+RutDig[1];
		var VarRut=rut(RutDig[0],RutDig[1]);
		if(VarRut==false)
		{
			alert('Rut empresa incorrecto, ingrese nuevamente.')
			f.TxtRutEmp.focus();
			Res=false;
			return;
		}
	}
	if (f.TxtEmpClien.value=="")
	{
		alert("Debe ingresar descripcion de empresa / cliente");
		f.TxtEmpClien.focus();
		Res=false;
		return;
	}
	/*if (f.TxtFeOtor.value=="")
	{
		alert("Debe seleccionar fecha otorgamiento Codelco");
		f.TxtFeOtor.focus();
		Res=false;
		return;
	}*/
			
	return(Res);
}
function SoloUnElementoLicencias(f,inputchk,Opc)
{
	var CantCheck=0;
	for (i=1;i<eval("document."+f+"."+inputchk+".length");i++)
	{
		if (eval("document."+f+"."+inputchk+"["+i+"].checked")==true)
			CantCheck++;
	}
	if (CantCheck > 1 ||CantCheck==0)
	{
		if(CantCheck==0)
		{
			alert("Debe Seleccionar al menos un tipo de licencia");
			return(false);
		}	
		return(true);
	}
	else
		return(true);
}
</script>
</head>
<?
if ($Opc=='N')
{
	if($TxtRut=='')
		echo '<body onLoad="document.FrmProceso.TxtRut.focus();">';
}
else if ($Opc=="M")
{ 
	echo '<body onLoad="document.FrmProceso.TxtRut.focus();">';
}
?>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">

<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" method="post" action="" enctype="multipart/form-data">
<input name="Opc" type="hidden" value="<? echo $Opc; ?>">
<input name="NewOpc" type="hidden" value="<? echo $NewOpc; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">

<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1em.gif" width="15" height="15"></td>
	<td width="848" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2em.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
              
            <td width="74%" align="left">
              <? 
			  if($Opc=='N')
			  {
			  ?>
			  <img src="archivos/sub_tit_conduc_n.png" width="450" height="40">
              <? 
			  }
			  else
			  {
			  ?>
              <img src="archivos/sub_tit_conduc_m.png" width="450" height="40">
              <? 
			  }?>            
		    </td>
              <td width="26%" align="right">
			  <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
			  <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>  </td>
  </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
            <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" >
                <tr> 
                  <td class="FilaAbeja2">Rut</td>
                  <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                  <td colspan="2" class="FilaAbeja2"> 
				    <input name="CodConductor" type="hidden" id="CodConductor" value="<? echo $CodConductor;?>" size="13" maxlength="10" readonly="true"> 
					<?
					if($Opc=='N')
					{
					?>
				    <input name="TxtRut" type="text" id="TxtRut" value="<? echo $TxtRut;?>" size="13" maxlength="10" onBlur="Proceso('PB')"> 
					<?
					}
					else
					{
					?>
				    <input name="TxtRut" type="text" id="TxtRut" value="<? echo $TxtRut;?>" size="13" maxlength="10"> 
					<?
					}
					?>
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td width="319" class="FilaAbeja2">Nombres</td>
                  <td colspan="2" class="FilaAbeja2"><input name="TxtNombre" type="text" id="TxtRazonSocial3" value="<? echo $TxtNombre; ?>" size="70" maxlength="75" > 
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Apellido Paterno </td>
                  <td width="468" class="FilaAbeja2" ><input name="TxtPaterno" type="text" id="TxtNombreFantasia3" value="<? echo $TxtPaterno; ?>" size="30" maxlength="25">
                  &nbsp;<span class="InputRojo">(*)</span></td>
                  <td width="317" rowspan="4" class="FilaAbeja2" >
                    <? 
					$Foto="fotos/$TxtRut.jpg";
					if(is_file($Foto))
					$Imagen=$Foto;
					else
					$Imagen="archivos/usuario.png";
					
					?>
                    <img src='<? echo $Imagen;?>' width='100' height='98' border='0' align='absmiddle'>
				  &nbsp;</td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Apellido Materno </td>
                  <td class="FilaAbeja2" ><input name="TxtMaterno" type="text" id="TxtNombreFantasia3" value="<? echo $TxtMaterno; ?>" size="30" maxlength="25">
                  &nbsp;<span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Fecha Emisi&oacute;n Hoja Vida  Conductor</td>
                  <td class="FilaAbeja2" ><input name="TxtFechEmiHojaV" type="text" id="TxtFechEmiHojaV"  value="<? echo $TxtFechEmiHojaV; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechEmiHojaV,TxtFechEmiHojaV,popCal);return false"> &nbsp;<span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Hoja Vida Conductor (N&deg; Documento) </td>
                  <td class="FilaAbeja2" ><input name="TxtCodumnto" type="text" id="TxtCodumnto" value="<? echo $TxtCodumnto; ?>" size="12" maxlength="10">
                  &nbsp;<span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Tipo Licencia </td>
                  <td class="FilaAbeja2" ><input type="hidden" name="Licencias" value="">
					A5<input type="checkbox" name="Licencias" value="A5" class="SinBorde" <? echo  $CheckedA5;?>>&nbsp;
					A4<input type="checkbox" name="Licencias" value="A4" class="SinBorde" <? echo  $CheckedA4;?>>&nbsp;
					A3<input type="checkbox" name="Licencias" value="A3" class="SinBorde" <? echo  $CheckedA3;?>>&nbsp;
					A2<input type="checkbox" name="Licencias" value="A2" class="SinBorde" <? echo  $CheckedA2;?>>&nbsp;
					A1<input type="checkbox" name="Licencias" value="A1" class="SinBorde" <? echo  $CheckedA1;?>>&nbsp;
					B<input type="checkbox" name="Licencias" value="B" class="SinBorde" <? echo  $CheckedB;?>>&nbsp;
					C<input type="checkbox" name="Licencias" value="C" class="SinBorde" <? echo  $CheckedC;?>>&nbsp;
					D<input type="checkbox" name="Licencias" value="D" class="SinBorde" <? echo  $CheckedD;?>>&nbsp;
                  <span class="InputRojo">(*)</span></td>
                  <td class="FilaAbeja2" ><span class="formulario2"><span class="InputRojo">Foto&nbsp;con&nbsp;extension&nbsp;.jpg</span>
                      <input type="file" name="Archivo" id="Archivo">
                  </span></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Tipo Vehiculo </td>
                  <td colspan="2" class="FilaAbeja2">Veh&iacute;culo Liviano<input type="radio" name="TipVe" value="A" class="SinBorde" <? echo  $CheckedTip1;?>>
                  &nbsp;
					Veh&iacute;culo Pesado
					<input type="radio" name="TipVe" value="A" class="SinBorde" <? echo  $CheckedTip2;?>>&nbsp;</td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Fecha Vigencia Municipal </td>
                  <td colspan="2" class="FilaAbeja2"><input name="TxtVigMuni" type="text" id="TxtVigMuni"  value="<? echo $TxtVigMuni; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtVigMuni,TxtVigMuni,popCal);return false"> <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Restricci&oacute;n Licencia </td>
                  <td colspan="2" class="FilaAbeja2"><label>
                    <textarea name="TxtRestric" cols="60" ><? echo $TxtRestric;?></textarea>
                  </label>
                  &nbsp;- Dejar en blanco si no hay restricci�n</td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Fecha Realiza Examen Preocupacional </td>
                  <td colspan="2" class="FilaAbeja2"><label>
                  <input name="TxtExaPreocu" type="text" id="TxtExaPreocu"  value="<? echo $TxtExaPreocu; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtExaPreocu,TxtExaPreocu,popCal);return false"></label>&nbsp;&nbsp;Fecha Vigencia Preocupacional:  <? echo $FechaTerminoPreo;?></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Instituci&oacute;n Examen Preocu. </td>
                  <td colspan="2" class="FilaAbeja2"><label>
                    <input name="TxtInstPreocupa" type="text" id="TxtNombre" value="<? echo $TxtInstPreocupa; ?>" size="80" maxlength="75" >
                  </label></td>
                </tr>
                <tr>
                  <td height="25" class="FilaAbeja2">Fecha Vigencia Psico-senso-t&eacute;cnico</td>
                  <td colspan="2" class="FilaAbeja2"><input name="TxtVigExamPST" type="text" id="TxtVigExamPST"  value="<? echo $TxtVigExamPST; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtVigExamPST,TxtVigExamPST,popCal);return false">&nbsp;<span class="InputRojo">(*)</span>
				  <?
				  	if($TipVehiculo=='VL')
						$fecha_cambiada = mktime(0,0,0,substr($TxtVigExamPST,5,2),substr($TxtVigExamPST,8,2),substr($TxtVigExamPST,0,4)+4);
					else
						$fecha_cambiada = mktime(0,0,0,substr($TxtVigExamPST,5,2),substr($TxtVigExamPST,8,2),substr($TxtVigExamPST,0,4)+1);	
					$fecha = date("Y-m-d", $fecha_cambiada);
					//echo "Examen PST duraci�n:   ".$fecha."."; //devuelve 10/01/2004 
				  ?></td>
                <tr> 
                  <td height="28" class="FilaAbeja2">Instituci&oacute;n Examen Psico-Senso-Tecnico  </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtInstPST" type="text" id="TxtInstPST" value="<? echo $TxtInstPST; ?>" size="80" maxlength="75" >
					</td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Fecha Hoja deRuta </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtFechaHR" type="text" id="TxtFechaHR"  value="<? echo $TxtFechaHR; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaHR,TxtFechaHR,popCal);return false">&nbsp;</td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">N&deg; Hoja de Ruta </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtNumHR" type="text" id="TxtNumHR" value="<? echo $TxtNumHR; ?>" size="80" maxlength="75" ></td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Fecha Vigencia Curso Manejo Defensivo </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtFechaCurso" type="text" id="TxtFechaCurso"  value="<? echo $TxtFechaCurso; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaCurso,TxtFechaCurso,popCal);return false">&nbsp;</td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Rut Empresa / Cliente </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtRutEmp" type="text" id="TxtRutEmp" value="<? echo $TxtRutEmp; ?>" size="9" maxlength="10" ></td>
                </tr>
                <tr> 
                  <td height="28" class="FilaAbeja2">Empresa / Cliente </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtEmpClien" type="text" id="TxtEmpClien" value="<? echo $TxtEmpClien; ?>" size="80" maxlength="75" ></td>
                </tr>
                <tr>
                  <td height="28" class="FilaAbeja2">N&deg; Contrato </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtNContra" type="text" id="TxtNContra" value="<? echo $TxtNContra; ?>" size="30" maxlength="25">
                  &nbsp;</td>
                </tr>
<!--                <tr>
                  <td height="28" class="FilaAbeja2">Fecha Otorgamiento Codelco </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtFeOtor" type="text" readonly   size="10"  value="<? //echo $TxtFeOtor; ?>" >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFeOtor,TxtFeOtor,popCal);return false">&nbsp;<span class="InputRojo">(*)</span></td>
                </tr>
-->                <tr>
                  <td height="28" class="FilaAbeja2">Fecha DAS Codelco </td>
                  <td height="28" colspan="2" class="FilaAbeja2"><input name="TxtFechaDAS" type="text" id="TxtFechaDAS"  value="<? echo $TxtFechaDAS; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaDAS,TxtFechaDAS,popCal);return false">&nbsp;&nbsp;<!--Fecha Vigencia DAS:  --><? //echo $FechaTerminoDAS;?></td>
                </tr>
                <tr>
                  <td height="28" class="FilaAbeja2">Observaci&oacute;n</td>
                  <td height="28" colspan="2" class="FilaAbeja2"><label>
                    <textarea name="Obs" cols="80" rows="5"><? echo strtoupper($Obs);?></textarea>
                  </label></td>
                </tr>
                <tr>
                  <td height="28" colspan="3" class="FilaAbeja2"><span class="InputRojo">(*) 
                  Datos Obligatorios</span></td>
                </tr>
              </table></td>
       <td width="0%" align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
   </table>
   <br></td>
   <td width="1" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="1" height="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="1" height="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
  </table>
   <br>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Empresa  ya Existe');";
	if ($Msj=='G')
		echo "alert('Registro Ingresado con Exito');";
	if ($Msj=='M')
		echo "alert('Registro Modificado con Exito');";
	echo "</script>";
?>