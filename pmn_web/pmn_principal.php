<?php

	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");				
		
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Acceso Principal PMN</title>
<script language="JavaScript">
function Salir()
{
	var f=document.frmPrincipal;
	f.action="../principal/sistemas_usuario.php?CodSistema=6";
	f.submit(); 
}
function Link(Link)
{
	var f=document.frmPrincipal;
	if(Link=='1')
	{
		f.action='pmn_principal_reportes.php';
		f.submit();
	}
	if(Link=='4')
	{
		f.action='pmn_principal_consulta.php';
		f.submit();
	}
	if(Link=='5')
	{
		f.action='../ipif_web/ipif_adm_novedades.php?Pmn=S';
		f.submit();
	}
	if(Link=='6')
	{
		f.action='pmn_principal_gestion.php';
		f.submit();
	}
	if(Link=='7')
	{
		f.action='pmn_principal_control.php';
		f.submit();
	}
	if(Link=='8')
	{
		f.action='pmn_rpt_informe_diario.php';
		f.submit();
	}

}
</script>
<style>
.Abajo
{
border-bottom-color:#DECE4A;
border-bottom-style:solid;
border-bottom-width:thin;
}
</style>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frmPrincipal" method="post" action="">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><img src="archivos/logo_sup.jpeg"/>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="58" rowspan="2" align="right"><a href="JavaScript:Salir('')" class="LinkPestana" ><img src="archivos/btn_volver2.png" class="SinBorde"/></a></td>
    </tr>
    <tr>
      <td><img src="archivos/images/interior/esq33.png" width="18" height="17"/><img src="archivos/images/interior/imagen_vertical_arriba.png"/></td>
      <td width="661" align="right">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" >
        <tr>
          <td><img src="archivos/images/interior/esq3.png"/></td>
          <td colspan="2"  background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /> </td>
          <td width="18" ><img src="archivos/images/interior/esq2.png" /></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td colspan="2" rowspan="6" align="center" valign="middle"><table width="100%"  border="0" align="center" cellpadding="0"  cellspacing="0" style="vertical-align:top;">
            <tr>
              <td width="315" align="left" valign="top" class="formulario">Sistema Planta de Metales Nobles </td>
              <td width="61" rowspan="2" align="center">&nbsp;</td>
              <td width="74" rowspan="2" align="center">&nbsp;</td>
              <td width="153" rowspan="2" align="center"><a href="JavaScript:Link('1')" class="LinksinLinea"><img src="archivos/Reportes.jpg" alt="Reportes" width="40" class="SinBorde" /></a>&nbsp;</td>
              <td width="148" rowspan="2" align="center"><a href="JavaScript:Link('4')" class="LinksinLinea"><img src="archivos/btn_buscar.png" alt="Consulta" width="30" class="SinBorde" /></a>&nbsp;</td>
              <td width="119" rowspan="2" align="center"><a href="JavaScript:Link('5')" class="LinksinLinea"><img src="archivos/documental.png" alt="Novedades" width="30" class="SinBorde" /></a>&nbsp;</td>
            </tr>
            <tr>
              <td width="315" rowspan="6" align="center" valign="middle"><img src="archivos/barras.png" alt="Reportes" width="267" height="200" class="SinBorde" /></td>
            </tr>
            <tr>
              <td width="61" align="center">&nbsp;</td>
              <td align="center" class="Abajo">&nbsp;</td>
              <td align="center" class="Abajo"><a href="JavaScript:Link('1')" class="LinksinLinea" ><font size="+1" ><strong>Reportes Operacionales </strong></font></a>&nbsp;</td>
              <td align="center" class="Abajo"><a href="JavaScript:Link('4')" class="LinksinLinea" ><font size="+1"><strong>Consultas Operacionales</strong></font></a>&nbsp;</td>
              <td align="center" class="Abajo"><a href="JavaScript:Link('5')" class="LinksinLinea"><font size="+1"><strong>Novedades</strong></font></a>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center"><p>&nbsp;</p>
                <p>&nbsp;</p></td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="center"><a href="JavaScript:Link('8')" class="LinksinLinea"><img src="archivos/informe.bmp" alt="Informe Diario" width="40" class="SinBorde"/></a>&nbsp;</td>
              <td align="center"><a href="JavaScript:Link('6')" class="LinksinLinea"><img src="archivos/arbol.gif" alt="Gesti&oacute;n" width="50" class="SinBorde"/></a>&nbsp;</td>
              <td align="center"><img src="archivos/control.jpg" alt="Control" width="40" />&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2" align="center">&nbsp;</td>
              <td align="center" class="Abajo">&nbsp;</td>
              <td align="center" class="Abajo"><a href="JavaScript:Link('8')" class="LinksinLinea"><font size="+1"><strong>Informe Diario</strong></font></a>&nbsp;</td>
              <td align="center" class="Abajo"><a href="JavaScript:Link('6')" class="LinksinLinea"><font size="+1"><strong>Gesti&oacute;n</strong></font></a>&nbsp;</td>
              <td align="center" class="Abajo"><a href="JavaScript:Link('7')" class="LinksinLinea"><font size="+1"><strong>Control</strong></font></a>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td height="24" align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" colspan="6">&nbsp;</td>
            </tr>
          </table>
            <br>
			</td>
          <td background="archivos/images/interior/derecho.png"></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png"></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png"></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png"></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png"></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td align="right" background="archivos/images/interior/derecho.png"></td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td width="746" class="Abajo">&nbsp;</td>
          <td width="124" background="archivos/images/interior/imagen_vertical.png" >&nbsp;</td>
          <td bgcolor="#666699">&nbsp;</td>
        </tr>
        <tr>
          <td width="12"><img src="archivos/images/interior/esq1.png"/></td>
          <td height="1" colspan="2" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut)."&nbsp;</SPAN>";?></td>
          <td><img src="archivos/images/interior/esq4.png"  /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br>
  
  
</form>
</body>
</html>
