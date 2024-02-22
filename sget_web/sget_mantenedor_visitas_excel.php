<? include("../principal/conectar_sget_web.php");?>
<html>
<head>
<?
	if(!isset($TxtFechaIng))
		$TxtFechaIng=date('Y-m-d');
	if($Borra=='S')
	{
		$Elimina="delete from sget_visitas_tmp where rut_registro_solicita='".$CookieRut."'";
		mysql_query($Elimina);
	}

		echo "<title>Carga Excel Visitas</title>";
		$VarTitulo='Carga Excel Visitas';
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
		case "Carga":
			if(f.TxtFechaIng.value=='')
			{
				alert('Debe seleccionar Fecha de Ingreso de Visita(s)')
				return;
			}
			if(f.file.value=='')
			{
				alert('Debe seleccionar el archivo a cargar.')
				f.file.focus();
				return;
			}
			var mensaje=comprueba_extensionVisita(f.file.value);
			if(mensaje==true)
			{ 
				f.action = "sget_mantenedor_visitas_excel01.php?Opcion=procesa"; 
				f.submit();
			}
			else
			{
				alert('Extensi�n de archivo incorrecto, debe ser .xls')
				return;
			}			
		break;
		case "Carga1":
			f.action = "sget_mantenedor_visitas_excel01.php?Opcion=carga"; 
			f.submit();
		break;


	}
}
function Salir()
{
	window.close();
}
function comprueba_extensionVisita(archivo) 
{ 
   extensiones_permitidas = new Array(".xls"); 
   mierror = ""; 
  //recupero la extensi�n de este nombre de archivo 
  extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
  //alert (extension); 
  //compruebo si la extensi�n est� entre las permitidas 
  permitida = false; 
  for (var i = 0; i < extensiones_permitidas.length; i++) 
  { 
	 if (extensiones_permitidas[i] == extension) 
	 { 
		 permitida = true; 
		 break; 
	 } 
  } 
  if (permitida) 
	return(true);	
  else
	return(false);
}
function VerMsj(Msj,RutExist,Fecha,RutDias)
{
	if(Msj=='NEx')
	{
		alert('Planilla no corresponde utilice Excel disponible en extremo superior de esta ventana.')
		return;
	}
	if (Msj=='NC')
	{
		alert('No se a podido cargar excel, intente nuevamente');
	}
	if (Msj=='S' && RutExist=='')
	{
		alert('Proceso realizado exitosamente \nPor favor revisar y validar los datos antes de guardar.');
	}
	if(RutExist!='')
		alert('Rut(s) o N� Pasaporte(s): '+RutExist+', Ya se encuentran ingresados para Fecha '+Fecha+'.');
	if(RutDias!='')	
		alert('Rut(s) o N� Pasaporte(s): '+RutDias+', ya ingresaron dentro de los �ltimos siete d�as. \nrealice tramite de acreditaci�n de ingreso en Direcci�n de Fiscalizaci�n de Terceros');
	if (Msj=='R')
	{
		alert('Datos Guardados exitosamente');
	}	
}
</script>
</head>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<?
if(isset($Msj))
{
?>
<body onLoad="VerMsj('<? echo $Msj?>','<? echo $RutExist;?>','<? echo $FechaIMsj;?>','<? echo $RutDias;?>')">
<?
}
else
{
?>
<body>
<?
}
?>
<form action="" method="post" enctype="multipart/form-data" name="FrmProceso">

<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
              
            <td width="74%" align="left"><img src="archivos/sub_tit_excel_visita.png" width="450" height="40"></td>
              <td width="26%" align="right"><strong>Planilla Excel para Carga  Visitas</strong><img src="archivos/vineta.gif"> <a href="archivos/carga_visitas_rev01.xls" target="_blank"><img src="archivos/ico_excel4.jpg"  alt="Formato Carga Visitas " align="absmiddle" border="0"></a>  
			  <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>			  </td>
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
                  <td width="150" class="FilaAbeja2">Fecha Ingreso</td>
				  <td width="781" class="FilaAbeja2"><input name="TxtFechaIng" type="text" id="TxtFechaIng"  value="<? echo $TxtFechaIng; ?>"   size="10" readonly >
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIng,TxtFechaIng,popCal);return false"> <span class="InputRojo">(*)</span></td>
				</tr>
                <tr> 
                  <td width="150" class="FilaAbeja2">Excel</td>
                  <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                  <td width="781" class="FilaAbeja2"><label>
                    <input type="file" size="60" name="file">
                  &nbsp;<a href="JavaScript:Proceso('Carga')"><img src="archivos/Cexec.png" border="0" alt="Subir Archivo Excel" align="absmiddle"></a></label></td>
                </tr>
                <tr> 
                  <td colspan="2" class="FilaAbeja2"><span class="InputRojo">* Rut en Rojo, Se encuentran incorrectos, revisar.</span>
                    <label></label></td>
                  <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
                </tr>
                <tr>
                  <td height="28" colspan="2" class="FilaAbeja2">
				  <?
					$Consulta="SELECT * from sget_visitas_tmp where corr_visita<>'' and rut_registro_solicita='".$CookieRut."'";
					$Consulta.=" order by apellido_paterno,apellido_materno,nombres";	
					$Resp = mysql_query($Consulta);
					//echo $Consulta;
					$Cont=1;
					if($Fila=mysql_fetch_array($Resp))
					{
						?>
				  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
                    <tr>
                      <td colspan="11" align="center" class="CorteAmarillo">Guardar Datos&nbsp;&nbsp;<a href="JavaScript:Proceso('Carga1')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" class="CorteAmarillo" /></a>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10%" align="center" class="TituloTablaVerde">Fecha Ingreso</td>
					  <td width="7%" align="center" class="TituloTablaVerde">Rut</td>
					  <td width="7%" align="center" class="TituloTablaVerde">N� Pasaporte</td>
                      <td width="11%" align="center" class="TituloTablaVerde">Nombre</td>
                      <td width="10%" align="center" class="TituloTablaVerde">Cargo Visita</td>
					  <td width="12%" align="center" class="TituloTablaVerde">Empresa</td>
					  <td width="12%" align="center" class="TituloTablaVerde">Contrato</td>
                      <td width="12%" align="center" class="TituloTablaVerde">&Aacute;rea</td>
                      <td width="15%" align="center" class="TituloTablaVerde">Solicitado por </td>
					  <td width="15%" align="center" class="TituloTablaVerde">Fono/Anexo</td>
                      <td width="16%" align="center" class="TituloTablaVerde">Motivo </td>
                    </tr>
					  <?
						$Consulta="SELECT * from sget_visitas_tmp where corr_visita<>'' and rut_registro_solicita='".$CookieRut."'";
						$Consulta.=" order by apellido_paterno,apellido_materno,nombres";	
						$Resp = mysql_query($Consulta);
						//echo $Consulta;
						$Cont=1;
						while ($Fila=mysql_fetch_array($Resp))
						{		
							if($Fila[pasaporte]=='N')
							{
								if(valida_rut($Fila["rut"])==false)				
									$ColorRut="<span class='InputRojo'>".$Fila["rut"]."</span>";
								else
									$ColorRut=$Fila["rut"];	
								$NPasaporte='&nbsp;';	
							}
							else
							{
								$ColorRut='&nbsp;';	
								$NPasaporte=$Fila["rut"];	
							}	
							?>
							<tr>	
							  <td align="center" ><? echo $Fila["fecha_ingreso"]."&nbsp;"; ?></td>
							  <td ><? echo $ColorRut; ?></td>
							  <td align="center"><? echo $NPasaporte; ?></td>
							  <td ><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"])); ?>&nbsp;</td>
							  <td ><? echo ucwords(strtolower($Fila["cargo_visita"]))."&nbsp;"; ?></td>
							  <td align="left" ><? echo ucwords(strtolower($Fila["empresa"])); ?>&nbsp;</td>
							  <td align="left" ><? echo ucwords(strtolower($Fila["contrato_orden"])); ?>&nbsp;</td>
							  <td align="left" ><? echo ucwords(strtolower($Fila["area"])); ?>&nbsp;</td>
							  <td align="left" ><? echo ucwords(strtolower($Fila["solicitada_por"]));?>&nbsp;</td>
							  <td align="left" ><? echo ucwords(strtolower($Fila["telefono_solicita"]));?>&nbsp;</td>
							  <td ><? echo ucwords(strtolower($Fila["motivo"]));?>&nbsp;</td>
							</tr>
							<?		
							$Cont++;
						}
			?>
                  </table>
				  <?
				  }
				  ?>				  </td>
                </tr>
              </table>
		    </td>
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
</form>
</body>
</html>
<?
function valida_rut($r)
{
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	if ( $dv==$sub_dv )
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>