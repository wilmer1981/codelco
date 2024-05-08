<?
	if ($Tipo=="SUBIR_USER_ADM" || $Tipo=="SUBIR_INF_ADM")
	{
		setcookie("CookieSubir", $CookieRut);			
		echo "<script>window.open(\"subir_archivos_usuario.php?Tipo=".$Tipo."\",\"\",\"top=50,left=30,width=500,height=400,resizable=yes, scrollbars=yes\");window.close()</script>";
	}
?>
<html>
<head>
<title>Login</title>
<link href="js/style.css" rel=stylesheet>
<script language="JavaScript">
// FUNCION DE FOCO DE CAMPOS
foco = ""; // PRIMERO NOMBRAR LOS CAMPOS DEL FORMULARIO
netscape = "";
ver = navigator.appVersion; len = ver.length;
for(iln = 0; iln < len; iln++) if (ver.charAt(iln) == "(") break; 
	netscape = (ver.charAt(iln+1).toUpperCase() != "C");
	
	function keyDown(DnEvents) {
		// IE o netscape
		k = (netscape) ? DnEvents.which : window.event.keyCode;
		if (k == 13) { // preciona tecla enter
		if (foco == 'btnEntrar') {
			var f = document.frmPopUp;
			if (f.txtrut.value == "")
			{
				alert("Debe Ingresar Rut");
				f.txtrut.focus();
				return false;
			}
			if (f.txtpassword.value == "")
			{
				alert("Debe Ingresar Password");
				f.txtpassword.focus();
				return false;
			}
			f.action = "login_adm01.php";
			f.submit();
			return false;
			//return true; // envia cuando termina los campos
		} else {
			// si existen mas campos va para el proximo
			eval('document.frmPopUp.' + foco + '.focus()');
			return false;
		}
	}
}
document.onkeydown = keyDown; // work together to analyze keystrokes
function ValidaCampos()
{
	var f = document.frmPopUp;
	if (f.txtrut.value == "")
	{
		alert("Debe Ingresar Rut");
		f.txtrut.focus();
		return false;
	}
<? 
	if ($Tipo=="ADM_SIS")
	{
?>  
	
	if (f.txtpassword.value == "")
	{
		alert("Debe Ingresar Password");
		f.txtpassword.focus();
		return false;
	}
<?
	}
?>	
	return true;
}
function Entrar(opt)
{
	var f = document.frmPopUp;
	if (opt == "E")
	{
		if (ValidaCampos())
		{
			f.action = "login_adm01.php";
			f.submit();
		}
	}
	
}
</script><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(i);
}
-->
</style></head>

<body onLoad="document.frmPopUp.txtrut.focus()">
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="Tipo" value="<? echo $Tipo; ?>">
<table width="180" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaPrincipal">
  <tr bgcolor="#FFFFFF">
    <td colspan="2"><font class="titulo_codelco_informa">Cuentas de Usuario</font></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="57" class="BordeInf">Rutr:</td>
    <td width="112" class="BordeInf"><input name="txtrut" type="text" class="InputDer" id="txtrut" value="<? echo $txtrut; ?>" size="15" maxlength="10" onFocus="foco='txtpassword';"></td>
  </tr>
<? 
	if ($Tipo=="ADM_SIS")
	{
?>  
  <tr bgcolor="#FFFFFF">
    <td class="BordeInf">Password:</td>
    <td class="BordeInf"><input name="txtpassword" type="password" class="InputDer" id="txtpassword" size="15" maxlength="10" onFocus="foco='btnEntrar';"></td>
  </tr>
<?
	}
?>  
  <tr align="right" bgcolor="#efefef">
    <td colspan="2" class="BordeInf"><a href="JavaScript:Entrar('E')"><img src="images/img_entrar.gif"  width="30" height="20" border="0" ></a></td>
  </tr>
<?
	if (isset($mensaje))
	{  
		echo "<tr align=\"center\" bgcolor=\"#efefef\">\n";
		echo "<td colspan=\"2\" class=\"BordeInf\"><font class=\"titulo_codelco_informa\">".$mensaje."</font></td>\n";
		echo "</tr>\n";
	}
?>  
</table>
</form>
</body>
</html>
