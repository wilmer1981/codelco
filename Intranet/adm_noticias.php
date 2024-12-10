<?php 
	include("conectar.php"); 
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	if ($Proceso=="M")
	{
		$Consulta = "select * from intranet.menus where pos_menu='0' and cod_menu='".$Codigo."' ";
		$Resp = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{	
			$CodMenu=$Fila["cod_menu"];
			$TxtOrden=$Fila["orden"];
			$TxtTitulo=$Fila["descripcion"];
			$TxtLink=$Fila["link"];
			$TxtTexto=$Fila["texto"];
			$Archivo=$Fila["foto"];
		}
	}
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
			//window.opener.document.frmPrincipal.action="index.php";
			//window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "G":
			if (f.TxtOrden.value=="")
			{
				alert("Debe Ingresar el Numero de Orden");
				f.TxtOrden.focus();
				return;
			}
			if (f.TxtTitulo.value=="")
			{
				alert("Debe Ingresar un Titulo o Referencia");
				f.TxtTitulo.focus();
				return;
			}
			f.action="adm_noticias01.php?Proceso=G";
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
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			f.action="adm_noticias01.php?Proceso=E&Valor="+Valor;
			f.submit();
			break;
		case "M":
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
				alert("Debe Seleccionar un Elemento para Modificar");
				return;
			}
			f.action="adm_noticias.php?Proceso=M&Codigo="+Valor;
			f.submit();
			break;
		case "CAN":
			window.location="adm_noticias.php?";
			break;
	}
}
</script>
</head>

<body>
<form name="frmPopUp" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Tipo" value="<?php echo $Tipo; ?>">
<input type="hidden" name="CodMenu" value="<?php echo $CodMenu; ?>">
<table width="500" border="0" align="center" cellpadding="2" cellspacing="1" class="TablaPrincipal">
  <tr>
    <td colspan="4" class="titulo_codelco_informa">Noticias Destacadas</td>
  </tr>
  <tr align="center">
    <td colspan="4" class="BordeInf">
    <p><a href="JavaScript:AbrirPopUp('adm_destacados.php')"></a><span class="titulo_codelco_informa"><?php if ($Mensaje!=""){ echo $Mensaje;}?></span></p></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Orden:</td>
    <td colspan="2" class="BordeInf"><input name="TxtOrden" type="text" id="TxtOrden" value="<?php echo $TxtOrden; ?>" size="12" maxlength="2"></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Titulo Noticia &oacute; Referencia  :</td>
    <td colspan="2" class="BordeInf"><textarea name="TxtTitulo" cols="70" rows="2" wrap="VIRTUAL" class="InputIzq" id="textarea"><?php echo $TxtTitulo; ?></textarea>
</td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Fotograf&iacute;a:</td>
    <td colspan="2" class="BordeInf"><input name="Archivo" type="file" id="Archivo" size="50"></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Link a Documento u otra Pagina:</td>
    <td colspan="2" class="BordeInf"><input name="TxtLink" type="text" class="InputIzq" size="50" maxlength="255" value="<?php echo $TxtLink; ?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="BordeInf">Texto:</td>
    <td colspan="2" class="BordeInf">Pege aqu&iacute; el texto que aparecer&aacute; como noticia<br>      <textarea name="TxtTexto" cols="70" rows="4" wrap="VIRTUAL" class="InputIzq" id="TxtTexto"><?php echo nl2br($Fila["texto"]); ?></textarea></td>
    </tr>
  <tr align="center">
    <td colspan="4" class="BordeInf"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:70px " onClick="Proceso('M')">
      <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">       
      <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:70px " onClick="Proceso('CAN')">
      <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
<br>
<table width="550" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaPrincipal">
  <tr align="center">
    <td width="1" class="BordeInf">&nbsp;</td>
    <td width="39" class="BordeInf"><font class="titulo_codelco_informa">Orden</font></td>
    <td width="207" class="BordeInf"><font class="titulo_codelco_informa">Titulo / Referencia</font></td>
    <td width="134"  class="BordeInf"><font class="titulo_codelco_informa">Link</font></td>
    <td width="91"  class="BordeInf"><font class="titulo_codelco_informa">Foto</font></td>
  </tr>
<?php 
	$Consulta = "select * from intranet.menus where pos_menu='0' and cod_menu<>'0' order by lpad(orden,3,'0')";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{		
		echo "<tr>\n";
		echo "<td align=\"center\" class=\"BordeInf\"><input type=\"radio\" name=\"ChkMsg\" value=\"".$Fila["cod_menu"]."\"></td>\n";
		echo "<td align=\"center\" class=\"BordeInf\"><font class=\"main-menu\">".$Fila["orden"]."</font></td>\n";
		echo "<td class=\"BordeInf\"><font class=\"main-menu\">".$Fila["descripcion"]."</font></td>\n";
		if (!is_null($Fila["link"]) && $Fila["link"]!="")
			echo "<td class=\"BordeInf\"><a href=\"".$Fila["link"]."\" target=\"_blank\"><font class=\"main-menu\">".$Fila["link"]."</font></a></td>\n";
		else
			echo "<td class=\"BordeInf\">&nbsp;</td>\n";
		if (!is_null($Fila["foto"]) && $Fila["foto"]!="")
			echo "<td class=\"BordeInf\">".$Fila["foto"]."</td>\n";
		else
			echo "<td class=\"BordeInf\">&nbsp;</td>\n";
		echo "</tr>\n";
	}

?>  
  <tr bgcolor="#efefef">
    <td colspan="6" align="right" class="BordeInf">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
