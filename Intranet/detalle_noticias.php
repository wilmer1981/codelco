<?
	include("conectar.php");
?>
<HTML><HEAD><TITLE>Noticias</TITLE>
<LINK href="js/style.css" type=text/css rel=stylesheet>
</HEAD>
<BODY text=#000000 bgColor=#ffffff leftMargin=0 topMargin=0 marginheight="0" 
marginwidth="0">
<TABLE width=100% height="100%" border=0 cellPadding=5 cellSpacing=3>
  <TBODY>
  <TR>
    <TD width=700 height="147" vAlign=middle><?
	$Consulta = "select * from intranet.menus where pos_menu='".$PosMenu."' and cod_menu='".$Codigo."' ";
	$Resp = mysql_query($Consulta);
	if ($Fila = mysql_fetch_array($Resp))
	{
		echo "<img src=\"".$Fila["foto"]."\"  align=\"absmiddle\">";
	}
	else
	{
		echo "&nbsp;";
	}
?></TD>
    <TD width=10 align="right" valign="top"><IMG src="images/tit_noticias.gif"  border="0"></TD>
  </TR>
  <TR>
    <TD vAlign=top colSpan=2 height=96>
<?
	$Consulta = "select * from intranet.menus where pos_menu='".$PosMenu."' and cod_menu='".$Codigo."' ";
	$Resp = mysql_query($Consulta);
	if ($Fila = mysql_fetch_array($Resp))
	{
		echo "&nbsp;&nbsp;<font class=\"titulo_codelco_informa2\">".strtoupper($Fila["descripcion"])."</font>";
	}
	else
	{
		echo "&nbsp;";
	}
?><BR><BR>
<?
	$Consulta = "select * from intranet.menus where pos_menu='".$PosMenu."' and cod_menu='".$Codigo."' ";
	$Resp = mysql_query($Consulta);
	if ($Fila = mysql_fetch_array($Resp))
	{
		echo "<font class=\"main-menu\">".nl2br($Fila["texto"])."</font>";
	}
	else
	{
		echo "&nbsp;";
	}
?>	
	</TD>
	<BR><BR>
<?
	$Consulta = "select * from intranet.detalle_menus where pos_menu='".$PosMenu."' and cod_menu='".$Codigo."' order by lpad(orden,3,'0')";
	$Resp = mysql_query($Consulta);
	while($Fila = mysql_fetch_array($Resp))
	{
		echo "<tr><td><img src=\"".$Fila["foto"]."\" align=\"absmiddle\"></td></tr>";
		echo "<tr><td><font class=\"main-menu\">".nl2br($Fila["texto"])."</font></td></tr>";
	}
?><BR><BR>
  </TR>
  <TR>
    <TD height="29" colSpan=2 vAlign=top bgColor=#b26c4a>
<DIV align=center><A href="javascript:print()"><IMG height=19 
      src="images/imprimir.gif" width=76 border=0></A><A 
      href="javascript:window.close()"><IMG height=19 
      src="images/ic_cerrar.gif" width=94 
  border=0></A></DIV></TD></TR></TBODY></TABLE>
</BODY></HTML>
