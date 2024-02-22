<?php include("inter_conectar.php"); ?>
<!-- saved from url=(0083)http://www.capacitacion.lod.cl/browse.asp?pagina=codelco/global/lista_contratos.htm -->
<HTML><HEAD><TITLE>CODELCO</TITLE>
<SCRIPT language=Javascript>
var logeado_dll = 1;

var Huella_dll = Array();

Huella_dll[0] = '#FECHA#ÿ25/08/2005ÿ1ÿ';
Huella_dll[1] = '#USUARIO#ÿSr. Administrador Contratista   ÿ1ÿ';
</SCRIPT>

<SCRIPT language=JavaScript src="archivos/funcionesMM.js"></SCRIPT>

<SCRIPT language=JavaScript src="archivos/validaciones.js"></SCRIPT>

<SCRIPT language=JavaScript src="archivos/general.js"></SCRIPT>

<SCRIPT language=JavaScript>
<!--
//------====== VARIABLES ======------
var TotReg = 0;
var RegPag = 0;
var TotPag = 0;
var Numpagina = 0;
var p_id_tr = '';
var cont = 0;
//------====== FUNCIONES ======------

function swMouseOutPanel(pID)
{
swMouseOut(pID, p_id_tr)
}

function eliminar_borrador(id_hoja, conid, lib_id, Paginaactual, id_tr, id_contrato)
{
w=400;h=200;
var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;
winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',resizable=yes,menubar=no,location=no,toolbar=no,status=no,scrollbars=yes,directories=no'
window.open('/browse.asp?pagina=codelco/global/popup_elimina_borrador.htm&id_hoja=' + id_hoja +'&conid='+ conid +'&lib_id='+lib_id+'&Paginaactual='+Paginaactual+'&id_tr='+id_tr+'&id_contrato='+id_contrato+'&prefijo=&la_pagina=lc' , '', winprops);
}
//-->
</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></HEAD>
<BODY class=body_general>
<!--=== AYUDA ===-->
<SCRIPT language=JavaScript src="archivos/helpWindow.js"></SCRIPT>
<!--=== FIN AYUDA ===-->
<TABLE width="73%" height="100%" border=0 cellPadding=0 cellSpacing=0 class="BordeDer">
  <TBODY>
  <TR>
    <TD vAlign=baseline height="99%">
      <TABLE cellSpacing=0 cellPadding=0 width=768 border=0>
        <TBODY>
        <TR>
          <TD width="768" colSpan=4 align="right"><!--=== CABEZERA ===-->
           <?php include("inter_menu_sup.php") ?></SCRIPT>
<!--=== FIN CABEZERA ===--></TD>
        </TR></TBODY></TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=767 border=0>
        <TBODY>
        <TR>
          <TD height=20 align="right" class=titulo_cafe><?php echo date("d")." de ".$Meses[date("n")-1]." de ".date("Y"); ?></TD>
        </TR></TBODY></TABLE>
      <TABLE cellSpacing=0 cellPadding=0 width=767 border=0>
        <TBODY>
        <TR>
          <TD class=noprint vAlign=top width=138><!--=== MENU IZQUIERDO ===-->
            <?php include("inter_menu_izq.php"); ?>
            <!--=== FIN MENU IZQUIERDO ===--></TD>
          <TD width=649 align="center" vAlign=top class="BordeIzq"><!--=== INFORMACION PRINCIPAL ===-->		  
<?php
	if (!isset($Pagina))
	{
		include("inter_body.php"); 
	}
	else
	{	
		$Pagina=explode("?",$Pagina);
		$URL=$Pagina[0];
		if ($URL=="inter_doc.php" || $URL=="inter_directorio.php")
		{
			$Variables=explode("=",$Pagina[1]);
			$Sistema=$Variables[1];
			//include($URL);
			$Dir="documentos/".$Sistema;
			echo $Dir;
		}
		include($URL);
	}
?>
<!--=== FIN INFORMACION PRINCIPAL ===--></TD>
        </TR>
        </TBODY>
		</TABLE>
	</TD>
    <TD vAlign=baseline>&nbsp;&nbsp;&nbsp;</TD>
  </TR>
<TR>
    <TD>
	<!--=== PIE ===-->
      <?php include("inter_pie.php"); ?>
<!--=== FIN PIE ===-->
   </TD>
    <TD>&nbsp;</TD>
</TR>
</TBODY>
</TABLE>
</BODY>
</HTML>
