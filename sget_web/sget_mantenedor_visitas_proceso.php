<? include("../principal/conectar_sget_web.php");


if(isset($Pasaport) && $Pasaport=='S')
	$CheckPasa='checked=checked';
else
	$CheckPasa='';
	
if ($Opc=='M')
{
	$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
	$RC=mysql_query($ConsultaC);
	$FC=mysql_fetch_array($RC);
	$AnoDAS=$FC["valor_subclase1"];
	//$AnoPreo=$FC["valor_subclase2"];
	$Ano2Ocu=$FC[valor_subclase3];

	$Consulta="SELECT * from sget_visitas where corr_visita = '".$CorrV."'";
	 $Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		//$TxtRutPrv=str_pad($Fila["rut_empresa"],10,'0',l_pad);
		$CorrVisita=$Fila["corr_visita"];
		$TxtFechaIng=$Fila["fecha_ingreso"];
		$TxtRut=$Fila["rut"];
		$TxtNombre=$Fila["nombres"];
		$TxtPat=$Fila["apellido_paterno"];
		$TxtMat=$Fila["apellido_materno"];
		$TxtEmpresa=$Fila["empresa"];
		$TxtCtto_orden=$Fila["contrato_orden"];
		$Pasaporte=$Fila['pasaporte'];
		if($Pasaporte=='S')
			$CheckPasa='checked=checked';
		else
			$CheckPasa='';	
			
		if($Fila["fecha_das"]=='0000-00-00')
		{
			$TxtFecha='';
			$FechaTerminoDAS="<span class='InputRojo'>SIN REGISTRO FECHA DAS</span>";
		}
		else
		{
			$TxtFecha=$Fila["fecha_das"];
			$FechaDAS=explode('-',$Fila[fecha_das]);
			$FechaDAS[0]=$FechaDAS[0]+$AnoDAS;
			$FechaTerminoDAS=$FechaDAS[0]."-".$FechaDAS[1]."-".$FechaDAS[2];
			if($FechaTerminoDAS< date('Y-m-d'))	
				$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
			else
				$FechaTerminoDAS=$FechaTerminoDAS;	
		}
		$TxtArea=$Fila["area"];
		$TxtSolicita=$Fila["solicitada_por"];
		$TxtFono=$Fila["telefono_solicita"];
		$Obs=$Fila["observacion"];
		$Motivo=$Fila["motivo"];
		$TxtCargo=$Fila["cargo_visita"];
		$TxtCargoSol=$Fila["cargo_solicita"];

		//CONSULTO ULTIMO INGRESO DEL RUT BUSCADO	
		$UltimoIngreso='';$Dia=0;$FechaTope='';
		$Consulta="SELECT fecha_ingreso from sget_visitas where rut='".$TxtRut."' and corr_visita <> '".$CorrV."' order by fecha_ingreso desc";	
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$FecUltIng=explode('-',$Fila[fecha_ingreso]);
			$FechaTope=date('Y-m-d',mktime(0,0,0,intval($FecUltIng[1]),intval($FecUltIng[2])+7,intval($FecUltIng[0])));
			//$Dia=explode('-',$UltimoIngreso);
			//$Dia=$Dia[2]+7;
		}	 
	}	
}
if($R=='S')//REINGRESO
{
	$TxtFechaIng='';
	$TxtRut='';
	$TxtNombre='';
	$TxtPat='';
	$TxtMat='';		
	$TxtFecha='';
	$Pasaporte='';
	$TxtEmpresa='';
	$TxtCtto_orden='';
	$TxtCargo='';
	$TxtCargoSol='';
	$TxtFono='';	
	$TxtArea='';
	$TxtSolicita='';
	$Motivo='';	$Obs='';
}
if($BusDatos=='S')
{
	$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
	$RC=mysql_query($ConsultaC);
	$FC=mysql_fetch_array($RC);
	$AnoDAS=$FC["valor_subclase1"];
	//$AnoPreo=$FC[valor_subclase2];
	$Ano2Ocu=$FC[valor_subclase3];

	$TxtNombre='';
	$TxtPat='';
	$TxtMat='';
	$TxtFecha='';
	$TxtEmpresa='';
	$Consulta="SELECT * from sget_visitas where rut='".$TxtRut."' order by fecha_ingreso desc";
	//echo $Consulta."<br>";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtNombre=$Fila["nombres"];
		$TxtPat=$Fila["apellido_paterno"];
		$TxtMat=$Fila["apellido_materno"];		
		$TxtFecha=$Fila[fecha_das];
		$Pasaporte=$Fila['pasaporte'];
		if($Pasaporte=='S')
			$CheckPasa='checked=checked';
		else
			$CheckPasa='';	
		if($TxtFecha=='0000-00-00')
		{
			$TxtFecha='';
			$FechaTerminoDAS="<span class='InputRojo'>SIN REGISTRO FECHA DAS</span>";
		}
		else
		{
			$FechaDAS=explode('-',$Fila[fecha_das]);
			$FechaDAS[0]=$FechaDAS[0]+$AnoDAS;
			$FechaTerminoDAS=$FechaDAS[0]."-".$FechaDAS[1]."-".$FechaDAS[2];
			if($FechaTerminoDAS< date('Y-m-d'))	
				$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
			else
				$FechaTerminoDAS=$FechaTerminoDAS;	
		}
		$TxtEmpresa=$Fila[empresa];
		$TxtCtto_orden=$Fila["contrato_orden"];
		$TxtCargo=$Fila["cargo_visita"];
		$TxtCargoSol=$Fila["cargo_solicita"];
		$TxtFono=$Fila["telefono_solicita"];
			
	}
	else//CONSULTO EN PERSONAL
	{
		$Consulta="SELECT * from sget_personal where rut='".$TxtRut."'";
		$Resp=mysql_query($Consulta);
		if($Fila=mysql_fetch_array($Resp))
		{
			$TxtNombre=$Fila["nombres"];
			$TxtPat=$Fila["ape_paterno"];
			$TxtMat=$Fila["ape_materno"];		
			$TxtFecha=$Fila[fecha_das];
			$Pasaporte=$Fila['pasaporte'];
			$TxtCtto_orden=$Fila["cod_contrato"];
			if($Pasaporte=='S')
				$CheckPasa='checked=checked';
			else
				$CheckPasa='';	
			if($TxtFecha=='0000-00-00')
			{
				$TxtFecha='';
				$FechaTerminoDAS="<span class='InputRojo'>SIN REGISTRO FECHA DAS</span>";
			}
			else
			{
				$FechaDAS=explode('-',$Fila[fecha_das]);
				$FechaDAS[0]=$FechaDAS[0]+$AnoDAS;
				$FechaTerminoDAS=$FechaDAS[0]."-".$FechaDAS[1]."-".$FechaDAS[2];
				if($FechaTerminoDAS< date('Y-m-d'))	
					$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
				else
					$FechaTerminoDAS=$FechaTerminoDAS;	
			}
			if($Fila["rut_empresa"]!='' && $Fila["rut_empresa"]!='-')
			{
				$ConEmp="SELECT razon_social from sget_contratistas where rut_empresa='".$Fila["rut_empresa"]."'";
				$REmp=mysql_query($ConEmp);
				$FEmp=mysql_fetch_array($REmp);
				$TxtEmpresa=$FEmp[razon_social];
			}
			else
				$TxtEmpresa='Sin Empresa en SGET Personal';
		}
	}
	//CONSULTO ULTIMO INGRESO DEL RUT BUSCADO	
	$UltimoIngreso='';$Dia=0;
	$Consulta="SELECT fecha_ingreso from sget_visitas where rut='".$TxtRut."' order by fecha_ingreso desc";	
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$FecUltIng=explode('-',$Fila[fecha_ingreso]);
		$FechaTope=date('Y-m-d',mktime(0,0,0,intval($FecUltIng[1]),intval($FecUltIng[2])+7,intval($FecUltIng[0])));
	}	 
}
//PREGUINTO SI TIENE INGRESO PARA EL D�A
$Consulta="SELECT fecha_ingreso from sget_visitas where rut='".$TxtRut."' and fecha_ingreso='".$TxtFechaIng."' order by fecha_ingreso desc";	
$Resp=mysql_query($Consulta);$ExisteMismoDia='N';
if($Fila=mysql_fetch_array($Resp))
	$ExisteMismoDia='S';
?>
<html>
<head>
<?
	if ($Opc=='N')
	{
		if($MuestraS=='')
			$Muestra=$MuestraS;
		else
			$Muestra=$MuestraS;	
		echo "<title>Nueva Visita</title>";
		$VarTitulo='Nueva Visita';
	}
	else	
	{
		$Muestra='S';
		echo "<title>Modifica Visita</title>";
		$VarTitulo='Modifica Visita';
	}	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmProceso;
	var Valida=true;
	var Veri="";
	switch(Opcion)
	{
		case "N":
				Veri=ValidaCampos(Valida,Opcion);
				if (Veri==true)
				{
					//alert(f.FechaTope.value);				
					var Pasa='N';
					if(f.Pasaporte.checked==true)
						Pasa='S';
					if(f.ExisteMismoDia.value=='N')//QUE NO TIENE INGRESO PARA EL MISMO DIA
					{
						if((f.FechaTope.value)!=''&&(f.FechaTope.value>f.TxtFechaIng.value))				
						{
							var mensaje=confirm('�Visita ya ingreso dentro de los �ltimos siete d�as, realice tramite de acreditaci�n de ingreso en Direcci�n de Fiscalizaci�n de Terceros?. \nPara continuar Presione (Aceptar), sino (Cancelar).')					
							if(mensaje==true)
							{
								f.action = "sget_mantenedor_visitas_proceso01.php?Opcion="+Opcion+"&Pasaport="+Pasa; 
								f.submit();
							}
						}
						else
						{
							f.action = "sget_mantenedor_visitas_proceso01.php?Opcion="+Opcion+"&Pasaport="+Pasa; 
							f.submit();
						}
					}
					else
					{
						alert('Ya se encuentran ingresado para la Fecha, \nVuelva a Ingresar.')
						f.action="sget_mantenedor_visitas_proceso.php?Opcion=N&R=S";
						f.submit();
						return;
					}
				}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				var Pasa='N';
				if(f.Pasaporte.checked==true)
					Pasa='S';
				/*if(f.ExisteMismoDia.value=='N')//QUE NO TIENE INGRESO PARA EL MISMO DIA
				{
					if((f.FechaTope.value)!=''&&(f.FechaTope.value>f.TxtFechaIng.value))					
					{
						var mensaje=confirm('�Visita ya ingreso dentro de los �ltimos siete d�as, realice tramite de acreditaci�n de ingreso en Direcci�n de Fiscalizaci�n de Terceros?. \nPara continuar Presione (Aceptar), sino (Cancelar).')					
						if(mensaje==true)
						{*/
							f.action = "sget_mantenedor_visitas_proceso01.php?Opcion="+Opcion+"&Pasaport="+Pasa; 
							f.submit();
						//}
/*					}
					else
					{
						f.action = "sget_mantenedor_visitas_proceso01.php?Opcion="+Opcion+"&Pasaport="+Pasa; 
						f.submit();
					}
				}
				else
				{
					alert('Visita no puede tener dos Accesos a la Divisi�n en el mismo D�a.')
					return;
				}*/
			}
		break;
		case "R":
			f.action = "sget_mantenedor_empresas_proceso.php?Opcion="+Opcion+"&Rec=S";
			f.submit();
		break;
		case "Mut":
		var	URL = "sget_mantenedor_mutuales_proceso.php?Volver=S&CmbMutuales="+f.CmbMutuales.value;		//var	URL = "sget_ingreso_administradores.php?Opc=B";
			window.open(URL,"","top=30,left=30,width=500,height=250,menubar=no,status=1,resizable=yes,scrollbars=yes");
		break;
		case "PB":
			var Pasa='N';
			if(f.Pasaporte.checked==true)
				Pasa='S';
			f.action = "sget_mantenedor_visitas_proceso.php?Opc=N&BusDatos=S&TxtRut="+f.TxtRut.value+"&Pasaport="+Pasa+"&MuestraS=S";
			f.submit();
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

	if(f.TxtFechaIng.value=='')
	{
		alert("Debe Ingresar Fecha de Ingreso Visita");
		f.TxtFechaIng.focus();
		Res=false;
		return;
	}
	if(f.Muestra.value=='')
	{
		alert('Debe Validar Fecha Ingreso para Seguir.')		
		return;
	}
	if(Opcion=='N')
	{
		if (f.TxtRut.value=="")
		{
			alert("Debe Ingresar Rut");
			f.TxtRut.focus();
			Res=false;
			return;
		}
		if(f.Pasaporte.checked==false)
		{
			var RutDig=f.TxtRut.value.split('-');
			if(RutDig[1]=='k')
				RutDig[1]='K';
			f.TxtRut.value=RutDig[0]+"-"+RutDig[1];
			var VarRut=rut(RutDig[0],RutDig[1]);
			if(VarRut==false)
			{
				alert('Rut incorrecto, ingrese nuevamente.')
				f.TxtRut.focus();
				Res=false;
				return;
			}
		}
	}	

	if (f.TxtNombre.value=="")
	{
		alert("Debe Ingresar Nombres");
		f.TxtNombre.focus();
		Res=false;
		return;
	}
	if(f.TxtPat.value=='')
	{
		alert("Debe Ingresar Apellido Paterno");
		f.CmbRegion.focus();
		Res=false;
		return;
	}
	if (f.TxtMat.value=="")
	{
		alert("Debe Ingresar Apellido Materno");
		f.TxtMat.focus();
		Res=false;
		return;
	}

	if (f.TxtEmpresa.value=="")
	{
		alert("Debe Ingresar Empresa");
		f.TxtEmpresa.focus();
		Res=false;
		return;
	}

	if (f.TxtArea.value=="")
	{
		alert("Debe Ingresar �rea");
		f.TxtArea.focus();
		Res=false;
		return;
	}
	if (f.TxtSolicita.value=="")
	{
		alert("Debe Ingresar Solicitado Visita por.");
		f.TxtSolicita.focus();
		Res=false;
		return;
	}
	if(f.Motivo.value=='')
	{
		alert("Debe Ingresar Motivo de Visita.");
		f.Motivo.focus();
		Res=false;
		return;
	}
	return(Res);
}
function Muestra()
{
	var f= document.FrmProceso;
	if(f.TxtFechaIng.value=='')
	{
		alert("Debe Ingresar Fecha de Ingreso Visita");
		f.TxtFechaIng.focus();
		Res=false;
		return;
	}
	f.action = "sget_mantenedor_visitas_proceso.php?Opc="+f.Opc.value+"&MuestraS=S";
	f.submit();
}
</script>
</head>
<?
if ($Opc=='N')
{
	if($TxtFechaIng=='')
		echo '<body onLoad="document.FrmProceso.TxtFechaIng.focus();">';			
	if($TxtRut=='')
	{
		if($Muestra=='S')
			echo '<body onLoad="document.FrmProceso.TxtRut.focus();">';				
	}	
}
else if ($Opc=="M")
{ 

		echo '<body onLoad="document.FrmProceso.TxtRut.focus();">';
}
?>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	/*background-image: url(archivos/f1.gif);*/
}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
<input name="Opc" type="hidden" value="<? echo $Opc; ?>">
<input name="CorrVisita" type="hidden" value="<? echo $CorrVisita; ?>">
<input name="Pagina" type="hidden" value="<? echo $Pagina; ?>">
<input name="FechaTope" type="hidden" value="<? echo $FechaTope; ?>">
<input name="ExisteMismoDia" type="hidden" value="<? echo $ExisteMismoDia; ?>">
<input name="Muestra" type="hidden" value="<? echo $MuestraS; ?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor" >
  <tr >
	<td height="15"><img src="archivos/images/interior/esq1em.gif" width="15" height="15"></td>
	<td width="848" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2em.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
              
            <td width="87%" align="left">
              <? 
			  if($Opc=='N')
			  {
			  ?>
			  <img src="archivos/sub_tit_visita_n.png" width="450" height="40">
              <? 
			  }
			  else
			  {
			  ?>
              <img src="archivos/sub_tit_visita_m.png" width="450" height="40">
              <? 
			  }?>			  </td>
              <td width="13%" align="right">
			  <a href="JavaScript:Proceso('<? echo $Opc;?>')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a>&nbsp;
			  <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>  </td>
  </tr>
   </table>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8DF9D">
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
     <tr>
       <td width="1%" align="center" class="TituloTablaVerde"></td>
            <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" >
                <tr> 
                  <td class="FilaAbeja2">Fecha Ingreso Visita </td>                  
                  <td colspan="3" class="FilaAbeja2"><input name="TxtFechaIng" type="text" id="TxtFechaIng"  value="<? echo $TxtFechaIng; ?>"   size="10" readonly="" >
				  &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIng,TxtFechaIng,popCal);return false"> <span class="InputRojo">(*)</span>
				  <a href="JavaScript:Muestra()" class="SinBorde"><img src="archivos/aprobado3.png" alt="Validar y Seguir Ingreso" class="SinBorde"></a>
				  </td>
                </tr>
				<?
				if($Muestra=='S')
				{
				?>				
                <tr> 
                  <td class="FilaAbeja2">Rut o N&uacute;mero de  pasaporte</td>                  
                  <td width="530" class="FilaAbeja2"> 
                    <?	   
					if($Opc=='M')
					{
					?>
					<input name="TxtRut" type="text" value="<? echo $TxtRut;?>" size="15" maxlength="15" readonly="true"> 
					<?
					}
					else
					{
					?>
					<input name="TxtRut" type="text" value="<? echo $TxtRut;?>" size="15" maxlength="15" onBlur="Proceso('PB')"> 
					<?
					}
					?>
                  <span class="InputRojo">(*)Ingreso Rut Ej: 12654789-6</span></td>
                  <td width="70" class="FilaAbeja2">Pasaporte</td>
                  <td width="324" class="FilaAbeja2">
                    <input type="checkbox" name="Pasaporte" value="<? echo $Pasaporte;?>" <? echo $CheckPasa;?> class="SinBorde">
				  &nbsp;Marcar solo si es extranjero</td>
                </tr>
                <tr> 
                  <td width="174" class="FilaAbeja2">Nombres</td>
                  <td colspan="3" class="FilaAbeja2"><input name="TxtNombre" type="text" id="TxtNombre" value="<? echo $TxtNombre; ?>" size="45" maxlength="40"> 
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Apellido Paterno </td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtPat" type="text" id="TxtPat" value="<? echo $TxtPat; ?>" size="30" maxlength="25">
                  &nbsp;<span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Apellido Materno </td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtMat" type="text" id="TxtMat" value="<? echo $TxtMat; ?>" size="30" maxlength="25">
                  &nbsp;<span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Empresa o Instituci&oacute;n </td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtEmpresa" type="text" id="TxtEmpresa" value="<? echo $TxtEmpresa; ?>" size="95" maxlength="75" >
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Cargo Visita </td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtCargo" type="text" id="TxtCargo" value="<? echo $TxtCargo; ?>" size="100" maxlength="100" ></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Contrato/Orden Compra</td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtCtto_orden" type="text" id="TxtCtto_orden" value="<? echo $TxtCtto_orden; ?>" size="35" maxlength="30"></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">Fecha DAS. (Inicio) </td>
                  <td colspan="3" class="FilaAbeja2"><input name="TxtFecha" type="hidden" id="TxtFecha"  value="<? echo $TxtFecha; ?>"   size="10" readonly ><? echo $TxtFecha; ?>&nbsp;&nbsp;Fecha Vencimiento DAS:&nbsp;&nbsp;<? echo $FechaTerminoDAS;?></td>
                </tr>
                <tr> 
                  <td height="25" class="FilaAbeja2">&Aacute;rea a Visitar </td>
                  <td colspan="3" class="FilaAbeja2"><label>
                    <input name="TxtArea" type="text" id="TxtArea" value="<? echo $TxtArea; ?>" size="50" maxlength="45" >
                  </label>
                  <span class="InputRojo">(*)</span></td>
                </tr>
                <tr>
                  <td height="25" class="FilaAbeja2"> Visita Solicitada Por </td>
                  <td colspan="3" class="FilaAbeja2"><input name="TxtSolicita" type="text" id="TxtSolicita" value="<? echo $TxtSolicita; ?>" size="80" maxlength="75" >
                    <span class="InputRojo">(*)</span></td>
                </tr>
                <tr> 
                  <td height="33" class="FilaAbeja2">Cargo Solicitante</td>
                  <td colspan="3" class="FilaAbeja2" ><input name="TxtCargoSol" type="text" value="<? echo $TxtCargoSol; ?>" size="100" maxlength="100" ></td>
                </tr>
				<tr>
                  <td height="25" class="FilaAbeja2">Telefono</td>
                  <td colspan="3" class="FilaAbeja2"><input name="TxtFono" type="text" value="<? echo $TxtFono; ?>" size="30" maxlength="33" ></td>
				</tr>
				  
                <tr>
                  <td height="28" class="FilaAbeja2">Motivo Visita</td>
                  <td height="28" colspan="3" class="FilaAbeja2"><label>
                    <textarea name="Motivo" cols="60" id="Obs" ><? echo $Motivo;?></textarea>
                    <span class="InputRojo">(*)</span></label></td>
                </tr>
                <tr>
                  <td height="28" class="FilaAbeja2">Observaci&oacute;n</td>
                  <td height="28" colspan="3" class="FilaAbeja2"><label>
                    <textarea name="Obs" cols="60" id="Obs" ><? echo $Obs;?></textarea>
                  </label></td>
                </tr>
			<?
				}
			?>	
                <tr>
                  <td height="28" colspan="4" class="FilaAbeja2"><span class="InputRojo">(*) 
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
<? if($Opc=='M')
{
?>
<? 
}
?>
<input name="TxtRutO" type="hidden"   value="<? echo $Valores ; ?>">
  <input name="TxtTieneReq" type="hidden"   value="<? echo $TieneReq ; ?>">
  <input name="TxtGrupoU" type="hidden"   value="<? echo $TxtGrupoU ; ?>">
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Msj=='G')
		echo "alert('Registro ingresado exitosamente');";
	if ($Msj=='M')
		echo "alert('Registro modificado exitosamente');";
	echo "</script>";
?>