<link href="js/style.css" rel=stylesheet>
<table width="770" height="25" border=0 cellpadding=0 cellspacing=0> 
	  <td align="center" valign="middle">
		  <table width="770" border="0" cellpadding="0" cellspacing="0">
			<tr align="center" valign=middle bgcolor="#b26c4a" height="16">
			<?php  
				$Consulta = "select * from intranet.menus where pos_menu='99' order by lpad(orden,4,'0'), descripcion";
				$Resp=mysqli_query($link,$Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					echo "<td height=\"19\" ><a href=\"".$Fila["link"]."\"><font class=\"main-menu_2\">";
					echo $Fila["descripcion"];
					echo "</font></a></td>\n";
					echo "<td width=\"4\"><img src=\"images/1x1white.gif\" width=\"1\" height=\"10\" border=\"0\"></td>\n";
				}
			?>  
		    </tr> 
        </table></td>
	</tr>        
</table>
