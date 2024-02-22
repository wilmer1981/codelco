<?php
	include("../principal/conectar_principal.php");
?>
<html>
<head>
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
			var f = document.frmPrincipal;
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
			f.action = "index01.php";
			f.submit();
			return false;
			//return true; // envia cuando termina los campos
		} else {
			// si existen mas campos va para el proximo
			eval('document.FrmDesbloquearLeyes.' + foco + '.focus()');
			return false;
		}
	}
}
document.onkeydown = keyDown; // work together to analyze keystrokes

function Desbloquear(Valores,ValoresSA,Tipo)
{
	var Frm=document.FrmDesbloquearLeyes;
	if (Frm.TxtPassword.value=='')
	{
		alert("Debe Ingresar Contrase�a");
		Frm.TxtPassword.focus();
		return;
	}
	Frm.action="cal_desbloquear_leyes_frx01.php?Proceso=A&Valores="+Valores+"&ValoresSA="+ValoresSA+"&Tipo="+Tipo+"&PW="+Frm.TxtPassword.value;
	Frm.submit();
}
function Salir(ValoresSA,Tipo)
{
	var Frm=document.FrmDesbloquearLeyes;
	Frm.action="cal_desbloquear_leyes_frx01.php?Proceso=S&ValoresSA="+ValoresSA+"&Tipo="+Tipo;
	Frm.submit();
}
</script>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="document.FrmDesbloquearLeyes.TxtPassword.focus();">
<form name="FrmDesbloquearLeyes" method="post" action="">
  <table width="400" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="380" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Desbloquear Leyes</div></td>
          </tr>
        </table>
<br>
        <table width="380" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td>Quimico:
			<?php  
				$Consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
				}
			?>						
			</td>
          </tr>
        </table>
        <br>
        <table width="380" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="58" height="36">Password</td>&nbsp;
            <td width="322">&nbsp;<input name="TxtPassword" type="password" id="TxtPassword" style="width:80" onfocus="foco='BtnOk';">
              <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Desbloquear('<?php echo $Valores; ?>','<?php echo $ValoresSA; ?>','<?php echo $Tipo; ?>');" onFocus="Desbloquear('<?php echo $Valores; ?>','<?php echo $ValoresSA; ?>','<?php echo $Tipo; ?>');"></td>
          </tr>
        </table> 
        <br>
        <table width="380" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:50" onClick="Salir('<?php echo $ValoresSA; ?>','<?php echo $Tipo; ?>');">
              </div></td>
          </tr>
        </table> </td>
	</tr>
  </table>
  </td>
  </tr>
  </table>
 	<?php 
  		echo "<script languaje='JavaScript'>";
		if ($PWValida=='N')
		{
			echo "alert('Password Ingresada Invalida');";
			echo "document.FrmDesbloquearLeyes.TxtPassword.focus();";
		}	
		echo "</script>"
	?>

</form>
</body>
</html>
