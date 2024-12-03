<table width="330" border="0" cellpadding="2" cellspacing="1" >
<?php  
	$Consulta = "select * from intranet.menus where pos_menu='".$CodMenu."' order by lpad(orden,4,'0'), descripcion";
	$Resp=mysqli_query($link,$Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($Fila["titulo"]=="S")
		{
			echo "<tr><td colspan=\"2\" class=\"BordeInf\"><span class=\"titulo_codelco_informa_gris\">".ucwords(strtolower($Fila["descripcion"]))."</span></td></tr>\n";
		}
		else
		{
			echo "<tr>\n";
			echo "<td align=\"right\" width=\"50\" >";
			if ($Fila["link"]!="")
				echo "<a href=\"".ucwords(strtolower($Fila["link"]))."\" target=\"_blank\">";
			else
				echo "<a href=\"JavaScript:DetalleNoticias('".$Fila["pos_menu"]."','".$Fila["cod_menu"]."')\">";
			echo "<img src=\"".$Fila["foto"]."\" width=\"45\" height=\"47\" border='0'></a>";
			echo "</td>\n";
			echo "<td align=\"left\" >";
			if ($Fila["titulo"]=="P")
				echo "<font class=\"titulo_codelco_informa2\">";
			else
				echo "<font class=\"main-menu\">";
			echo ucwords(strtolower(substr($Fila["descripcion"],0,90)))."...<br></font>";
			if ($Fila["link"]!="")
				echo "<a href=\"".$Fila["link"]."\" target=\"_blank\">";
			else
				echo "<a href=\"JavaScript:DetalleNoticias('".$Fila["pos_menu"]."','".$Fila["cod_menu"]."')\">";
			echo "<font class=\"main-menu\">".substr($Fila["texto"],0,90)."...";
			echo "<img height=\"13\" src=\"images/mas_info.gif\" width=\"23\" align=\"absMiddle\" border=\"0\">\n";
			echo "</font></a></td>\n";
			echo "</tr>\n";
		}
	}
?>   
	<tr>
    <td colspan="2" align="right" class="BordeInf">&nbsp;</td>
  </tr> 
</table>