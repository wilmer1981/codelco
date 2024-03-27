<? 
	include("../principal/conectar_sget_web.php");
	session_start();
	
	$TxtFecha=date("Y-m-d");
	$HoraActual = date("H");
	$MinutoActual = date("i");	
?>
<html>
<head>
<title>Carga Masiva Nomina</title>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{
	var f= document.FrmPopupProceso;
	switch(Opcion)
	{
		case "G":
			
			if(f.Archivo.value=='')
			{
				alert('Debe Seleccionar Documento')
				f.Archivo.focus();
				return;
			}
			f.action='sget_procesa_excel.php?ID='+f.ID.value;
			f.submit();
			break;
		case "S":
			if (f.Pagina.value=="sget_hoja_ruta.php")
			{
				window.opener.document.FrmProceso.action="sget_hoja_ruta.php?TxtHoja="+f.ID.value+"&Opt=M";
				window.opener.document.FrmProceso.submit();						
				window.close();
			}
			
			break;
	}
}
</script>
</head>

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form action="" method="post" enctype="multipart/form-data" name="FrmPopupProceso">
<input type="hidden" name="Proceso" value="<? echo $Proceso;?>">
<input type="hidden" name="ID" value="<? echo $ID;?>">
<input type="hidden" name="Formulario" value="<? echo $Formulario;?>">
<input type="hidden" name="Pagina" value="<? echo $Pagina;?>">
<input type="hidden" name="TipoVolver" value="<? echo $TipoVolver;?>">
   <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="942" height="15"background="archivos/images/interior/form_arriba.gif"> <img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>

   <td>
  <table width="441" border="0" align="center" cellpadding="3" cellspacing="0" class="BordeTabla">
    <tr>
      <td colspan="6" class="TituloTablaNaranja">Cargar Excel  (Archivos) </td>
    </tr>
    <tr>
      <td width="107" align="right" class="texto_bold">N&ordm; Hoja Ruta      </td>
      <td width="3" class="texto_bold">:</td>
      <td width="293" colspan="4" class="texto_bold"><?
	  
	   		echo $ID;
	  	
	   ?></td>
    </tr>
   <!-- <tr>
      <td align="right" class="texto_bold">Etapa
	 
	  </td>
      <td class="texto_bold">:</td>
      <td class="texto_bold">
	  <? 
	  if($Proceso=='L'||$Proceso=='C'){//SI ES LICITACION
	  	$Consulta="SELECT * from sgc_estados where tipo_proceso='L' ";
		$Consulta.=" and cod_estado='".$CodEstO."' ";
		$RespEst=mysqli_query($link, $Consulta);
		$FilaEst=mysql_fetch_array($RespEst);
		$DescripEst=$FilaEst[descrip_estado];
	  }
	  	if(($Formulario=='FrmPrograma')|| ($Formulario=='FrmDoc'))//Si se Adjunta documentos desde Registro de Hitos
			$DescripEst='Reg.Hitos';
		echo $DescripEst;
	  ?>
	  </td>
      <td class="texto_bold">Hito</td>
      <td class="texto_bold">:</td>
      <td class="texto_bold"><?
	   if(($Formulario=='FrmPrograma')|| ($Formulario=='FrmDoc'))//Si se Adjunta documentos desde Registro de Hitos
		{
			$Consulta="SELECT * from sgc_hitos where  ";
			$Consulta.="  cod_hito='".$RegHito."' ";
			$RespHito=mysqli_query($link, $Consulta);
			$FilaHito=mysql_fetch_array($RespHito);
			$DescripHito=$FilaHito[descrip_hito];
		  }
	   echo $DescripHito; 
	   ?>&nbsp;</td>
    </tr>-->
    
   <tr>
      <td align="right" class="texto_bold">Documento Excel </td>
      <td class="texto_bold">:</td>
      <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
      <td colspan="4" class="texto_bold">
        <input type="file" name="Archivo" id="Archivo">      </td>
    </tr>
    <tr align="center">
      <td colspan="6" class="texto_bold">
	  <a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png"  border="0" align="absmiddle"></a>&nbsp;
	  &nbsp;<a href="JavaScript:Proceso('S')"><img src="archivos/close.png" border="0" align="absmiddle"></a></td>
    </tr>
      <tr>
        <td colspan="6" valign="top" class="texto_bold"><span class="titulo_rojo_tabla">(*) Datos Obligatorios</td>
      </tr>
  </table>
  </td>
  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje!="")
		echo "alert('".$Mensaje."');";
	if($ID=='')
	{
		echo "alert('No Existe Nro. ID (Solp/Lic/Ctto)');";	
		echo "window.close();"; 
	}	
	if($Acento==true)
	{
		echo "alert('Renombre el Archivo sin Acentos');";	
	}
	
	
	echo "</script>";
?>