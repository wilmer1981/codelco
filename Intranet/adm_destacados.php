<? 
	include("conectar.php"); 
	
?>
<html>
<head>
<title>Destacados</title>
<link href="js/style.css" rel=stylesheet>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "S":
			window.close();
			break;
		case "G":
			if (f.TxtMensaje.value=="")
			{
				alert("Debe Ingresar un Mensage");
				f.TxtMensaje.focus();
				return;
			}
			f.action="adm_destacados01.php?Proceso=G";
			f.submit();
			break;
		case "E":
			var Valor="";			
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkMsg" && f.elements[i].checked==true)
				{
					Valor=f.elements[i].value;
				}
			}
			if (Valor=="")
			{
				alert("Debe Seleccionar un un Mensaje para Eliminar");
				return;
			}
			f.action="adm_destacados01.php?Proceso=E&Valor="+Valor;
			f.submit();
			break;
	}
}
</script>
</head>

<body>
<form name="frmPopUp" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Tipo" value="<? echo $Tipo; ?>">
<table width="450" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaPrincipal">
  <tr>
    <td colspan="4" class="titulo_codelco_informa">Cuadro de Informaciones</td>
  </tr>
  <tr align="center">
    <td colspan="4" class="BordeInf">
    <p><a href="JavaScript:AbrirPopUp('adm_destacados.php')"></a><span class="titulo_codelco_informa"><? if (isset($Mensaje)){ echo $Mensaje;}?></span></p></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Mensaje:</td>
    <td colspan="2" class="BordeInf"><input name="TxtMensaje" type="text" class="InputIzq" id="TxtMensaje" size="50" maxlength="255"></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Link:</td>
    <td colspan="2" class="BordeInf"><input name="TxtLink" type="text" class="InputIzq" id="TxtLink" size="50" maxlength="255"></td>
    </tr>
  <tr align="center">
    <td colspan="4" class="BordeInf"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">       
    <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  <tr align="center">
    <td width="26" class="BordeInf">&nbsp;</td>
    <td width="27" class="BordeInf"><font class="titulo_codelco_informa">Fecha</font></td>
    <td width="169" class="BordeInf"><font class="titulo_codelco_informa">Mensaje</font></td>
    <td width="139"  class="BordeInf"><font class="titulo_codelco_informa">Link</font></td>
  </tr>
<? 
	$Consulta = "select * from intranet.mensajes order by fecha";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{		
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"BordeInf\"><input type=\"radio\" name=\"ChkMsg\" value=\"".$Fila["fecha"]."\"></td>\n";
		echo "<td align=\"center\" class=\"BordeInf\"><font class=\"main-menu\">".substr($Fila["fecha"],8,2)."/".substr($Fila["fecha"],5,2)."/".substr($Fila["fecha"],0,4)."</font></td>\n";
		echo "<td class=\"BordeInf\"><font class=\"main-menu\">".$Fila["mensaje"]."</font></td>\n";
		if (!is_null($Fila["link"]) && $Fila["link"]!="")
			echo "<td class=\"BordeInf\"><a href=\"".$Fila["link"]."\" target=\"_blank\"><font class=\"main-menu\">".$Fila["link"]."</font></a></td>\n";
		else
			echo "<td class=\"BordeInf\">&nbsp;</td>\n";
		echo "</tr>\n";
	}

?>  
  <tr bgcolor="#efefef">
    <td colspan="4" align="right" class="BordeInf">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
