<? 
	include("conectar.php");
?>
<html>
<head>
<title>Atachar Documento</title>
</head>

<link href="estilos/sgc_style.css" rel="stylesheet" type="text/css">
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form action="" method="post" enctype="multipart/form-data" name="FrmPopupProceso">
  <table width="441" border="0" align="center" cellpadding="3" cellspacing="0" class="BordeTabla">
    <tr align="center">
      <td colspan="6" class="TituloTablaCafeBold">Busqueda Archivos </td>
    </tr>
   <tr>
      <td width="107" align="right" class="texto_bold">Documento</td>
      <td width="3" class="BordeBajo">:</td>
      <!--<td class="titulos_tablas"><input name="TxtRutPrv" type="text" class="InputDer" onBlur="CalculaDv(TxtRutPrv,TxtDv,this.form)" onKeyDown="TeclaPulsada('')"  value="<? echo $TxtRutPrv;?>" size="12" maxlength="10" <? echo $EstadoRutPrv?>>-->
      <td width="4688" colspan="4" class="BordeBajo">
        <input type="file" name="Archivo" id="Archivo">
      </td>
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
	echo "</script>";
?>