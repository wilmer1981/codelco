<? 
    include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Consulta="SELECT * from sget_contratistas where rut_empresa = '".$Emp."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtRutPrv=intval(substr(str_pad($Fila["rut_empresa"],10,'0',l_pad),0,8));
		$TxtDv=substr(str_pad($Fila["rut_empresa"],12,'0',l_pad),11,1);
		$TxtRazonSocial=$Fila["razon_social"];
		$TxtNombreFantasia=$Fila["nombre_fantasia"];
		$TxtCalle=$Fila["calle"];
		$TxtCorreo=$Fila["mail_empresa"];
		$TxtFono=$Fila["telefono_comercial"];
		$TxtRep1=$Fila["repres_legal1"];
		$TxtFonoRep1=$Fila["telefono_repres1"];
		$TxtMailRep1=$Fila["mail_repres_legal1"];
		$TxtCelRep1=$Fila["celular_repres_legal1"];
		$TxtRep2=$Fila["repres_legal2"];
		$TxtFonoRep2=$Fila["telefono_repres2"];
		$TxtMailRep2=$Fila["mail_repres_legal2"];
		$TxtCelRep2=$Fila["celular_repres_legal2"];
		$TxtNroRegic=$Fila["nro_regic"];
		$TxtFechaCert=$Fila["fecha_ven_cert"];
		$TxtNroRegistro=$Fila["nro_registro"];
		if($Rec != 'S')
		{
			$CmbCiudad=$Fila["cod_ciudad"];
			$CmbComuna=$Fila["cod_comuna"];
			$CmbMutuales=$Fila["cod_mutual_seguridad"];
			$CmbPrevencionista=$Fila["rut_prev"];
		}
		$CmbEstado=	$Fila["estado"];
	}	
?>
<html>
<head>
<title>Informaci�n Empresa <? echo $TxtRazonSocial;?></title>
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
				f.action = "sget_mantenedor_empresas01.php?Opcion="+Opcion; 
				f.submit();
			}
		break;
		case "M":
			Veri=ValidaCampos(Valida,Opcion);
			if (Veri==true)
			{
				f.action = "sget_mantenedor_empresas01.php?Opcion="+Opcion;
				f.submit();
			}
		break;
		case "R":
			f.action = "sget_mantenedor_empresas_proceso.php?Opcion="+Opcion+"&Rec=S";
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
	if (f.TxtRutPrv.value=="")
	{
		alert("Debe Ingresar Rut");
		f.TxtRutPrv.focus();
		Res=false;
		return;
	}
	if (f.TxtDv.value=="")
	{
		alert("Debe Ingresar Digito Verificador");
		f.TxtDv.focus();
		Res=false;
		return;
	}
	if (f.TxtRazonSocial.value=="")
	{
		alert("Debe Ingresar Razon Social");
		f.TxtRazonSocial.focus();
		Res=false;
		return;
	}

	return(Res);
}

</script>
</head>
<?
/*
if ($Opc=='N')
	echo '<body onLoad="document.FrmProceso.TxtRutPrv.focus();">';
	else
		echo '<body onLoad="document.FrmProceso.TxtRazonSocial.focus();">';
*/?>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" method="post" action="">
<input name="Opc" type="hidden" value="<? echo $Opc; ?>">
<table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1058" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td width="74%" align="left"><img src="archivos/sub_tit_info_emp.png"></td>
       <td align="right"><a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
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
             <td colspan="4"align="center" class="TituloTablaVerde">Datos Generales</td>
           </tr>
           <tr>
             <td class="formulario2">Rut Empresa </td>
             <td colspan="3" class="formulariosimple" ><?
				echo FormatearRun($TxtRutPrv."-".$TxtDv);
			 
			 ?>             </td>
           </tr>
           <tr>
             <td width="231" class="formulario2">Raz&oacute;n Social </td>
             <td colspan="3" class="formulariosimple" ><? echo FormatearNombre($TxtRazonSocial); ?></td>
           </tr>
           <tr>
             <td height="33" class="formulario2">Nombre Fantasia </td>
             <td colspan="3" class="formulariosimple" ><? echo $TxtNombreFantasia; ?></td>
           </tr>
           <tr>
             <td height="33" class="formulario2">Calle</td>
             <td colspan="3" class="formulariosimple" ><? echo $TxtCalle; ?></td>
           </tr>
           <tr>
             <td height="25" class="formulario2">Ciudad</td>
             <td colspan="3" class="formulariosimple" ><?
			$Consulta = "SELECT * from sget_ciudades where cod_ciudad='".$CmbCiudad."' order by nom_ciudad ";			
			$Resp1=mysqli_query($link, $Consulta);
			while ($Fila1=mysql_fetch_array($Resp1))
			{
				echo ucfirst($Fila1["nom_ciudad"]);
			}
			?>             </td>
           </tr>
           <tr>
             <td height="25" class="formulario2">Comuna</td>
             <td colspan="3" class="formulariosimple" ><?
			  $Consulta = "SELECT t2.cod_comuna,t2.nom_comuna from sget_comunas_por_ciudad  t1 inner join sget_comunas t2 on t1.cod_comuna=t2.cod_comuna ";
			  $Consulta.= " where t1.cod_ciudad='".$CmbCiudad."' and t1.cod_comuna='".$CmbComuna."'";			
			  $Consulta.= " order by nom_comuna ";			
			  $Resp2=mysqli_query($link, $Consulta);
			  while ($Fila2=mysql_fetch_array($Resp2))
			  {
				echo ucfirst($Fila2["nom_comuna"]);
			   }
			   ?>             </td>
           </tr>
           <tr>
             <td height="25" class="formulario2">E-Mail</td>
             <td class="formulariosimple" ><? echo $TxtCorreo ; ?></td>
             <td class="formulario2" >Telefono</td>
             <td class="formulariosimple" ><? echo $TxtFono ; ?></td>
           </tr>
           <tr>
             <td height="28" class="formulario2">Mutual Seguridad </td>
             <td class="formulariosimple" ><?
			  $Consulta = "SELECT * from sget_mutuales_seg where estado='1' and cod_mutual='".$CmbMutuales."' order by descripcion ";			
			  $Resp3=mysqli_query($link, $Consulta);
			  while ($Fila3=mysql_fetch_array($Resp3))
			  {
				echo ucfirst($Fila3["abreviatura"]);
			  }
			 ?>             </td>
             <td  class="formulario2">Nro Regic </td>
             <td class="formulariosimple" ><? echo $TxtNroRegic ; ?></td>
           </tr>
           <tr>
             <td height="28" class="formulario2">Fecha Ven. Cert.</td>
             <td width="148" class="formulariosimple" ><? echo $TxtFechaCert; ?></td>
             <td width="138" class="formulario2" >Nro Registro </td>
             <td width="291" class="formulariosimple" ><? echo $TxtNroRegistro ; ?></td>
           </tr>
           <tr>
             <td height="28" class="formulario2">Estado</td>
             <td colspan="3" class="formulariosimple" ><?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007'  and cod_subclase='".$CmbEstado."'";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			echo ucfirst($FilaTC["nombre_subclase"]);
		}
			?>             </td>
           </tr>
           <tr>
             <td  colspan="4" class="TituloTablaVerde"  align="center">Datos Representante Principal</td>
           </tr>
           <tr>
             <td height="25" class="formulario2">Representante Legal Principal </td>
             <td class="formulariosimple" ><? echo FormatearNombre($TxtRep1); ?></td>
             <td class="formulario2" >E-Mail</td>
             <td class="formulariosimple" ><? echo $TxtMailRep1 ; ?></td>
           </tr>
           <tr>
             <td height="28" class="formulario2">Telefono </td>
             <td class="formulariosimple" ><? echo $TxtFonoRep1 ; ?></td>
             <td class="formulario2" >Celular</td>
             <td class="formulariosimple" ><? echo $TxtCelRep1 ; ?></td>
           </tr>
           <tr>
             <td colspan="4" class="TituloTablaVerde" align="center">Datos Persona Contacto </td>
           </tr>
           <tr>
             <td height="28" class="formulario2">Representante Legal Secundario </td>
             <td class="formulariosimple" ><? echo FormatearNombre($TxtRep2) ; ?></td>
             <td class="formulario2" >E-Mail</td>
             <td class="formulariosimple" ><? echo $TxtMailRep2 ; ?></td>
           </tr>
           <tr>
             <td height="28" class="formulario2">Telefono</td>
             <td class="formulariosimple" ><? echo $TxtFonoRep2 ; ?></td>
             <td class="formulario2" >Cargo</td>
             <td class="formulariosimple" ><? echo $TxtCelRep2 ; ?></td>
           </tr>
         </table></td>
         <td width="0%" align="center" class="TituloTablaVerde"></td>
       </tr>
       <tr>
         <td colspan="3"align="center" class="TituloTablaVerde"></td>
       </tr>
     </table>
     <br></td>
  <td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="20" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table><br>
  <table width="90%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1058" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="20" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>

   <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr>
	<td align="center" class="TituloTablaVerde">Contrato</td>
   	<td align="center" class="TituloTablaVerde">Descripci&oacute;n</td>  
	<td align="center" class="TituloTablaVerde">Fecha Inicio</td> 
	<td align="center" class="TituloTablaVerde">Fecha Termino</td>
	<td align="center" class="TituloTablaVerde">Estado</td>     
 	</tr>
	<?
	$Consulta="SELECT * from sget_contratos t1 left join  proyecto_modernizacion.sub_clase t2  on t1.estado=t2.cod_subclase and t2.cod_clase='30007'";
	$Consulta.="  where t1.rut_empresa='".$Emp."' ";
	$Respd=mysqli_query($link, $Consulta);
	while($Filad=mysql_fetch_array($Respd))
	{
	?>
	<tr>
    <td ><a href="sget_info_ctto.php?Ctto=<? echo $Filad["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a><? echo $Filad["cod_contrato"];?>&nbsp;</td>
   	<td ><? echo FormatearNombre($Filad["descripcion"]);?>&nbsp;</td>  
	<td ><? echo $Filad["fecha_inicio"];?>&nbsp;</td> 
	<td ><? echo $Filad[fecha_termino];?>&nbsp;</td>
	<td ><? echo $Filad["nombre_subclase"];?>&nbsp;</td>   
	</tr>
	
	
	
	<?
	}
	$Consulta="SELECT t1.rut_empresa,t1.cod_contrato,t3.descripcion,t3.fecha_inicio,t3.fecha_termino,t2.nombre_subclase from sget_sub_contratistas t1 inner join sget_contratos t3 on t1.cod_contrato=t3.cod_contrato left join  proyecto_modernizacion.sub_clase t2  on t3.estado=t2.cod_subclase and t2.cod_clase='30007'";
	$Consulta.="  where t1.rut_empresa='".$Emp."' ";
	//echo $Consulta;
	$Respd=mysqli_query($link, $Consulta);
	while($Filad=mysql_fetch_array($Respd))
	{
	?>
	<tr>
    <td ><a href="sget_info_ctto.php?Ctto=<? echo $Filad["cod_contrato"];?>" target="_blank"><img src="archivos/info2.png"  alt="Informaci�n Contrato" border="0" width='23' height='23' align="absmiddle" /></a><? echo $Filad["cod_contrato"];?>&nbsp;</td>
   	<td ><? echo FormatearNombre($Filad["descripcion"]);?>&nbsp;</td>  
	<td ><? echo $Filad["fecha_inicio"];?>&nbsp;</td> 
	<td ><? echo $Filad[fecha_termino];?>&nbsp;</td>
	<td ><? echo $Filad["nombre_subclase"];?>&nbsp;</td>   
	</tr>
	<?
	}
	?>
   
			  		  
</table>
  </td>
  <td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="20" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>
  
  
   <br>
</form>
</body>
</html>