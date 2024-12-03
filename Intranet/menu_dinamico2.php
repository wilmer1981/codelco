<table width="330" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal2">
<?php  
	$Consulta = "select * from intranet.menus where pos_menu='".$CodMenu."' order by lpad(orden,4,'0'), descripcion";
	$Resp=mysqli_query($link,$Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($Fila["titulo"]=="S")
		{
			echo "<tr valign=\"top\"><td height=\"15px\" colspan=\"2\" bgcolor=\"#efefef\"><span class=\"main-menu\">".$Fila["descripcion"]."</span></td></tr>\n";
		}
		else
		{
			echo "<tr valign=\"top\">\n";
			echo "<td height=\"15\" align=\"right\"><img src=\"images/vineta3.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";
			echo "<td height=\"15\" align=\"left\">";
			if ($Fila["link"]!="" && !is_null($Fila["link"]))
			{
				echo "<p><a href=\"".$Fila["link"]."\"><font class=\"main-menu-blanco\">";
				echo $Fila["descripcion"];
				echo "</font></a></p></td>\n";
			}
			else
			{
				echo "<p><font class=\"main-menu-blanco\">";
				echo $Fila["descripcion"];
				echo "</font></p></td>\n";
			}
			echo "</tr>\n";
		}
	}
?>   
	<tr bgcolor="#efefef">
    <td colspan="2" align="center" bgcolor="#efefef" class="BordeInf"><a href="JavaScript:window.history.back();"><span>volver</span></a></td>
  </tr> 
</table>

