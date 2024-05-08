<?
	$Consulta = "select * from intranet.usuarios where rut_funcionario='".$CookieRut."'";
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		$Tipo=$Fila["tipo"];
	}
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="js/style.css" rel=stylesheet>
</head>

<body>
<? if (isset($CookieRut))
{
?>
<table width="223" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal">	

  <tr>
    <td colspan="2" class="titulo_codelco_informa">Men&uacute; - Administrador del Sitio </td>
  </tr>
  <? 
	if ($Tipo==1)
	{
	?>
	  <tr>
		<td align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
		<td align="left" class="BordeInf"><a href="JavaScript:AbrirPopUp('adm_noticias.php')"><font class="main-menu">Administrar Noticias Destacadas</font></a></td>
	  </tr>
	  <?
	 }
	 else
	 {
	  ?>
	  	<tr>
			<td align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
			<td align="left" class="BordeInf"><a href="JavaScript:AbrirPopUp('adm_noticias.php')"><font class="main-menu">Administrar Noticias Destacadas</font></a></td>
	  	</tr>
		  <tr>
			<td align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
			<td width="192" align="left" class="BordeInf">
			  <a href="JavaScript:AbrirPopUp('adm_destacados.php')"><font class="main-menu">Administrar Cuadro de Informaciones </font></a></td>
		  </tr>
		
		  <tr>
			<td align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
			<td align="left" class="BordeInf"><font class="main-menu"><a href="JavaScript:AbrirPopUp('adm_carpetas.php')">Carpetas de Archivos de Usuarios</a></font></td>
		  </tr>
		  <tr>
			<td align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
			<td align="left"  class="BordeInf"><a href="JavaScript:AbrirPopUpLogin('login_adm.php?Tipo=SUBIR_USER_ADM')"><font class="main-menu">Programas Usuario</font></a></td>
		  </tr>
		  <tr>
			<td align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
			<td align="left"  class="BordeInf"><a href="JavaScript:AbrirPopUpLogin('login_adm.php?Tipo=SUBIR_INF_ADM')"><font class="main-menu">Programas Informatica</font></a></td>
		  </tr>
		  <tr align="center" bgcolor="#efefef">
			<td colspan="2" class="BordeInf"><a href="JavaScript:window.history.back();"><span>volver</span></a></td>
		  </tr>
<?	}
?>
		</table>

<?
}//FIN SI EXISTE COOKIE DE AUTORIZACION
else
{
?>
<table width="223" border="0" cellpadding="2" cellspacing="1" class="TablaPrincipal">
  <tr>
    <td colspan="2" class="titulo_codelco_informa">Men&uacute; - Administrador del Sitio </td>
  </tr>
  <tr>
    <td width="29" align="right" class="BordeInf"><img src="images/vineta2.gif" width="13" height="12" border="0"></td>
    <td width="181" align="left" class="BordeInf">
      <p><font class="main-menu">UD. NO ESTA AUTORIZADO </font></p></td>
  </tr>
  <tr align="center" bgcolor="#efefef">
    <td colspan="2" class="BordeInf"><a href="JavaScript:window.history.back();"><span>volver</span></a></td>
  </tr>
</table>
<?
}
?>
</body>
</html>
