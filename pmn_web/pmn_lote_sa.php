<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");					

?>
<html>
<head>
<title>Acceso Principal PMN</title>
<script language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function SalirRpt()
{
var f=document.frmPrincipalRpt;
f.action="../principal/sistemas_usuario.php?CodSistema=6";
f.submit();
}
function Pantalla(Pant)
{
var f=document.frmPrincipalConsulta;
f.action=Pant;
f.submit();
}
</script>
</head>
<body topmargin="5">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<form name="frmPrincipalRpt" method="post" action="">
  <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td ><img src="archivos/images/interior/esq3.png"/></td>
      <td colspan="3" background="archivos/images/interior/arriba.png"></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png"><img src="archivos/images/interior/esq2.png" /></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png">&nbsp;</td>
      <td width="19%"><img src="archivos/logo_sup.jpeg"/></td>
      <td width="74%" align="left" valign="bottom"  bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><strong><h5>Asignación de lotes por SA</h5></strong></td>
      <td width="4%" align="right" bgcolor="#F7F2EB" style="border-bottom-color:#FFFFFF; border-bottom-style:double; border-bottom-width:thin;"><a href="JavaScript:SalirRpt('')" class="LinkPestana" ><img src="archivos/btn_volver2.png" class="SinBorde"/></a></td>
      <td width="2%" align="right" background="archivos/images/interior/derecho.png">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">
		  <table width="100%"  border="0"  align="center" cellpadding="0"  cellspacing="0" bgcolor="#F7F2EB">
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td colspan="5" ><img src="archivos/images/interior/transparent.gif" width="4" /></td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td colspan="5" rowspan="4" align="center" valign="top">
			<?php 
				include('pmn_ing_lote_sa.php');
			?>									
			</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
	
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td background="archivos/images/interior/izquierdo.png">&nbsp;</td>
          <td background="archivos/images/interior/derecho.png">&nbsp;</td>
        </tr>
        <tr>
          <td width="12"><img src="archivos/images/interior/esq1.png"/></td>
          <td height="1" colspan="5" background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /><?php echo "<font color='#FFFFFF' SIZE='2'>".$CookieRut."  -  ".NomUsuario($CookieRut)."&nbsp;&nbsp;-&nbsp;&nbsp;".NomPerfil($CookieRut)."&nbsp;</SPAN>";?></td>
          <td width="18"><img src="archivos/images/interior/esq4.png"  /></td>
        </tr>
      </table>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
