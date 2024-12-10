<table width="230" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal">
<?php  
	$Consulta = "select * from intranet.menus where pos_menu='".$CodMenu."' order by lpad(orden,4,'0'), descripcion";
	//echo $Consulta;
	$Resp=mysqli_query($link,$Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($Fila["titulo"]=="S")
		{
			echo "<tr><td colspan=\"2\"><span class=\"titulo_codelco_informa\">".$Fila["descripcion"]."</span></td></tr>\n";
		}
		else
		{
			echo "<tr>\n";
			echo "<td align=\"right\" class=\"BordeInf\"><img src=\"images/vineta2.gif\" width=\"13\" height=\"12\" border=\"0\"></td>\n";
			echo "<td align=\"left\" class=\"BordeInf\">";
			if ($Fila["link"]!="" && !is_null($Fila["link"]))
			{
				if ($Fila["popup"]=="S")
				{
					echo "<p><a href=\"JavaScript:AbrirPopUp2('".$Fila["link"]."', 20, 50, 550, 450)\"><font class=\"main-menu\">";
					echo $Fila["descripcion"];
					echo "</font></a></p></td>\n";
				}
				else
				{
					echo "<p><a href=\"".$Fila["link"]."\"><font class=\"main-menu\">";
					echo $Fila["descripcion"];
					echo "</font></a></p></td>\n";
				}
			}
			else
			{
				echo "<p><font class=\"main-menu\">";
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