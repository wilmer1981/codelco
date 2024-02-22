<!--
document.write('<STYLE TYPE="text/css" MEDIA="print">.noprint {display: none;}</STYLE>');
document.write('<div class="noprint">');
document.write('<table width="767" border="0" cellpadding="0" cellspacing="0">');
document.write('<tr>');
document.write('	<td width="49%"><img src="imagenes_encabezado/logo_sup.jpg" width="159" height="52"></td>');
document.write('    <td width="10%" background="imagenes_encabezado/bg_sup.gif"><img src="imagenes_encabezado/mitad.jpg" width="148" height="52"></td>');
document.write('    <td width="35%" background="imagenes_encabezado/bg_sup.gif">');
document.write('    <div align="right" class="titulo_cafe">Mesa de Ayuda - Horario 08:00 hrs a 24:00 hrs');
document.write('    <span class="titulo_cafe"></span><span class="nTelefono">6903403</span></div></td>');
document.write('    <td width="6%" background="imagenes_encabezado/bg_sup.gif">');
document.write('	<div align="right"><img src="imagenes_encabezado/telefono.gif" width="29" height="31"><img src="images/menu_botones/1pixel.gif" width="7" height="8"></div>')
document.write('	</td>');
document.write('</tr>');
document.write('<tr>');
document.write('	<td colspan="4">')
document.write('	<table width="100%" border="0" cellpadding="0" cellspacing="0">');
document.write('    <tr>');
document.write('    	<td width="70%" height="22" background="imagenes_encabezado/alto_cobre.gif"><img src="imagenes_encabezado/alto_cobre.gif" width="4" height="22"><img src="imagenes_encabezado/flecha_menu.gif" width="19" height="22"><a href="/browse.asp?pagina=codelco/home.htm"><img src="imagenes_encabezado/contrato_2.gif" border="0" width="72" height="22"></a><img src="imagenes_encabezado/separa_menu.gif" width="8" height="22"></td>');
document.write('		<td width="5%" height="22" background="imagenes_encabezado/bg_cobre_2.gif">');
document.write('		<a href="/browse.asp?pagina=codelco/global/ayuda.htm"><div align="right" class="texBco">Ayuda&nbsp;&nbsp;</div></a></td>');
document.write('		<td width="4%" background="imagenes_encabezado/bg_cobre_2.gif">');
document.write('		<div align="right"><a href="/browse.asp?pagina=codelco/global/ayuda.htm"><img src="imagenes_encabezado/ayuda.gif" border="0" width="26" height="20"></a></div></td>');
document.write('        <td width="4%" background="imagenes_encabezado/bg_cobre_2.gif"><a href="/browse.asp?pagina=codelco/home.htm"><img src="imagenes_encabezado/home.gif" width="20" height="20" border=0></a></td>');
document.write('        <td width="4%" background="imagenes_encabezado/bg_cobre_2.gif"><a href="http://www.codelco.com/form_contactenos/fr_contactenos.html" target="_blank"><img src="imagenes_encabezado/centro_contacto.gif" border=0></a></td>');
document.write('        <td width="14%" height="22" background="imagenes_encabezado/bg_cobre_3.jpg" class="texBco">&nbsp;&nbsp;<a href="/browse.asp?pagina=codelco/logout.htm&accion=logout"><span class="texBco">Cerrar Sesi&oacute;n</span></a>&nbsp;&nbsp;');
document.write('		</td>');
document.write('	</tr>');
document.write('	</table>')
document.write('	</td>');
document.write('</tr>');
document.write('</table>');
document.write('</div>');

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
//-->
