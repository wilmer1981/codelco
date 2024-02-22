<script language="javascript">
function printIt(){
window.focus();
	if (window.print) {
	    document.body.background="images/fondo.gif";
	    window.print() ;
	    document.body.background="images/fondo_interior.gif";
	} else {
	    var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
	    document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
	    WebBrowser1.ExecWB(6, 2);
	}
}
</script>
<link href="estilos/style.css" rel="stylesheet" type="text/css">
<STYLE TYPE="text/css" MEDIA="print">.noprint {display: none;}</STYLE>
<div class="noprint">
<table width="767" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="49%"><img src="archivos/logo_sup.jpeg" width="159" height="52"></td>
<td width="10%" background="imagenes_encabezado/bg_sup.gif"><img src="archivos/mitad.jpg" width="148" height="52"></td>
<td width="35%" background="archivos/bg_sup.gif">
<div align="right" class="titulo_cafe">Mesa de Ayuda - Horario 08:00 hrs a 17:00 hrs
<span class="titulo_cafe"></span><span class="nTelefono">032-933399</span></div></td>
<td width="6%" background="archivos/bg_sup.gif">
<div align="right"><img src="archivos/telefono.gif" width="29" height="31"><img src="archivos/1pixel.gif" width="7" height="8"></div></td>
</tr>
<tr>
<td colspan="4">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="70%" height="22" background="archivos/alto_cobre.gif"><img src="imagenes_encabezado/alto_cobre.gif" width="4" height="22"><img src="archivos/flecha_menu.gif" width="19" height="22"><img src="archivos/separa_menu.gif" width="8" height="22"></td>
<td width="5%" height="22" background="archivos/bg_cobre_2.gif">
<a href="inter_menu.php?Pagina=con_no_disponible.php">
<div align="right" class="texBco">&nbsp;Ayuda&nbsp;&nbsp;</div>
</a></td>
<td width="4%" background="archivos/bg_cobre_2.gif">
<div align="right"><img src="archivos/ayuda.gif" border="0" width="26" height="20"></div></td>
<td width="4%" background="archivos/bg_cobre_2.gif"><img src="archivos/home.gif" width="20" height="20" border=0></td>
<td width="4%" background="archivos/bg_cobre_2.gif"><img src="archivos/centro_contacto.gif" width="21" height="20" border=0></td>
<td width="14%" height="22" background="archivos/bg_cobre_3.jpeg" class="texBco">&nbsp;&nbsp;<a href="index.php"><span class="texBco">Cerrar Sesi&oacute;n</span></a>&nbsp;&nbsp;
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
