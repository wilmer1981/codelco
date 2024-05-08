<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="js/style.css" rel=stylesheet>
</head>

<body>
<br>
<table width="156" height="135" border="0" cellpadding="2" cellspacing="1" background="images/logo_fundido.jpg">

<?  
	$Consulta = "select * from intranet.menus where pos_menu='1' order by lpad(orden,4,'0'), descripcion";
	$Resp=mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($Fila["titulo"]=="S")
		{
			echo "<tr><td colspan=\"2\"><span class=\"titulo_codelco_informa\">".$Fila["descripcion"]."</span></td></tr>\n";
		}
		else
		{			
			echo "<tr>\n";
			echo "<td>&nbsp;</td>\n";
			echo "<td><img src=\"images/vineta.gif\" width=\"9\" height=\"8\" border=\"0\">";
			echo "<a href=\"".$Fila["link"]."\"><font class=\"main-menu\">";
			echo $Fila["descripcion"];
			echo "</font></a></td>\n";
			echo "</tr>\n";
		}
	}
?>  
</table>
<br>
<table width="156" border="0" cellspacing="1" cellpadding="2">
<?  
	/*$Consulta = "select * from intranet.menus where pos_menu='2' order by lpad(orden,4,'0'), descripcion";
	$Resp=mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($Fila["titulo"]=="S")
		{
			echo "<tr><td colspan=\"2\"><span class=\"titulo_codelco_informa\">".$Fila["descripcion"]."</span></td></tr>\n";
		}
		else
		{			
			echo "<tr>\n";
			echo "<td>&nbsp;</td>\n";
			echo "<td><img src=\"images/vineta.gif\" width=\"9\" height=\"8\" border=\"0\">";
			echo "<a href=\"".$Fila["link"]."\"><font class=\"main-menu\">";
			echo $Fila["descripcion"];
			echo "</font></a></td>\n";
			echo "</tr>\n";
		}
	}*/
?>  
</table>
<br>
<table width="156" border="0" cellspacing="1" cellpadding="2">
<?  
	$Consulta = "select * from intranet.menus where pos_menu='3' order by lpad(orden,4,'0'), descripcion";
	$Resp=mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($Fila["titulo"]=="S")
		{
			echo "<tr><td colspan=\"2\"><span class=\"titulo_codelco_informa\">".$Fila["descripcion"]."</span></td></tr>\n";
		}
		else
		{
			echo "<tr>\n";
			echo "<td>&nbsp;</td>\n";
			echo "<td><img src=\"images/vineta.gif\" width=\"9\" height=\"8\" border=\"0\">";
			echo "<a href=\"".$Fila["link"]."\"><font class=\"main-menu\">";
			echo $Fila["descripcion"];
			echo "</font></a></td>\n";
			echo "</tr>\n";
		}
	}
?>    
</table>
</body>
</html>
