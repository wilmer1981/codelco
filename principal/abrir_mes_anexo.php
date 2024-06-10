<?php
	include("../principal/conectar_principal.php");
	//Proc=A&BalanceMes=S&Sistema=S&Ano=2021&Mes=1
	//PWValida=N&Proc=".$Proc."&BalanceMes=S&Sistema=".$Sistema."&Ano=".$Ano."&Mes=".$Mes
	//Sistema=AGE&Ano=2021&Mes=11
	$CookieRut = $_COOKIE["CookieRut"];

	if(isset($_REQUEST["Proc"])){
		$Proc = $_REQUEST["Proc"];
	}else{
		$Proc = "";
	}
	if(isset($_REQUEST["BalanceMes"])){
		$BalanceMes = $_REQUEST["BalanceMes"];
	}else{
		$BalanceMes = "";
	}
	if(isset($_REQUEST["Sistema"])){
		$Sistema = $_REQUEST["Sistema"];
	}else{
		$Sistema = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	if(isset($_REQUEST["PWValida"])){
		$PWValida = $_REQUEST["PWValida"];
	}else{
		$PWValida = "";
	}

	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["ValoresSA"])){
		$ValoresSA = $_REQUEST["ValoresSA"];
	}else{
		$ValoresSA = "";
	}
	if(isset($_REQUEST["Tipo"])){
		$Tipo = $_REQUEST["Tipo"];
	}else{
		$Tipo = "";
	}



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
			eval('document.FrmDesbloquear.' + foco + '.focus()');
			return false;
		}
	}
}
document.onkeydown = keyDown; // work together to analyze keystrokes

function Desbloquear()
{
	var Frm=document.FrmDesbloquear;
	if (Frm.TxtPassword.value=='')
	{
		alert("Debe Ingresar Contraseña");
		Frm.TxtPassword.focus();
		return;
	}
	if (Frm.BalanceMes.value=="S")
	{
		Frm.action="cierre_mes01.php?Proc=" + Frm.Proc.value + "&Sistema=" + Frm.Sistema.value + "&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
		Frm.submit();
		return;
	}
	else
	{
		switch (Frm.Sistema.value.toUpperCase())
		{
			case "SEC":
				Frm.action="../sec_web/sec_anexo_sec01.php?Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
				Frm.submit();
				break;
			case "SEA":
				Frm.action="../sea_web/sea_con_anexo01.php?Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
				Frm.submit();
				break;
			case "RAM":
				Frm.action="../ram_web/ram_con_anexo01.php?Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
				Frm.submit();
				break;
			case "CIR":
				Frm.action="../ram_web/ram_con_anexo_cir01.php?Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
				Frm.submit();
				break;
			case "PMN":
				Frm.action="../pmn_web/pmn_con_balance_anexo01.php?Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
				Frm.submit();
				break;
			case "AGE":
				Frm.action="../age_web/age_anexo01.php?Proceso=AM&Ano="+Frm.Ano.value+"&Mes="+Frm.Mes.value;
				Frm.submit();
				break;
		}	
	}//FIN SI ES BALANCE MES
}
function Salir()
{
	window.close();
}
</script>
<title>Sistemas Informaticos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="document.FrmDesbloquear.TxtPassword.focus();">
<form name="FrmDesbloquear" method="post" action="">
<input type="hidden" name="Proc" value="<?php echo $Proc;?>">
<input type="hidden" name="BalanceMes" value="<?php echo $BalanceMes;?>">
<input type="hidden" name="Sistema" value="<?php echo $Sistema;?>">
<input type="hidden" name="Ano" value="<?php echo $Ano;?>">
<input type="hidden" name="Mes" value="<?php echo $Mes;?>">
  <table width="400" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="380" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Abrir Mes <?php $Sistema;?></div></td>
          </tr>
        </table>
<br>
        <table width="380" border="0" cellpadding="5" class="TablaInterior">
          <tr>
            <td>Usuario:
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
              <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Desbloquear();" onFocus="Desbloquear('<?php echo $Valores; ?>','<?php echo $ValoresSA; ?>','<?php echo $Tipo; ?>');"></td>
          </tr>
        </table> 
        <br>
        <table width="380" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:50" onClick="Salir();">
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
			echo "document.FrmDesbloquear.TxtPassword.focus();";
		}	
		echo "</script>"
	?>

</form>
</body>
</html>
