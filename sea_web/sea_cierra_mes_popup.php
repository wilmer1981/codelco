<?php
	include("../principal/conectar_principal.php");

	$CookieRut = $_COOKIE["CookieRut"];
	
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes =  date("m");
	}
	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano =  date("Y");
	}
	if(isset($_REQUEST["valor"])) {
		$valor = $_REQUEST["valor"];
	}else{
		$valor = "";
	}
	if(isset($_REQUEST["pw"])) {
		$pw = $_REQUEST["pw"];
	}else{
		$pw = "";
	}
	if(isset($_REQUEST["anexo"])) {
		$anexo = $_REQUEST["anexo"];
	}else{
		$anexo = "";
	}


?>
<html>
<head>
<script language="JavaScript">
function Confirmar(f)
{
	if (f.txtpassword.value=='')
	{
		alert("Debe Ingresar Contrase�a");
		f.txtpassword.focus();
		return;
	}

	f.action = "sea_cierra_mes_popup01.php";
	f.submit();
}
/******************/
function Salir()
{
	window.close();
}
</script>
<title>Sistema De Anodos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPopUp" method="post" action="">
  <table width="400" height="200" border="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td><div align="center"></div>
        <table width="380" border="0" cellpadding="5" class="ColorTabla01">
          <tr>
            <td><div align="center">Confirmar Cierre de Mes</div></td>
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

	
				//Campos Ocultos.
				echo '<input name="ano" type="hidden" value="'.$ano.'">';
				echo '<input name="mes" type="hidden" value="'.$mes.'">';
				echo '<input name="valor" type="hidden" value="'.$valor.'">';
			?>						
			</td>
          </tr>
        </table>
        <br>
        <table width="380" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="58" height="36">Password</td>&nbsp;
            <td width="322">&nbsp;<input name="txtpassword" type="password"  style="width:80"> 
			              <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="Confirmar(this.form)"></td>
          </tr>
        </table> 
        <br>
        <table width="380" height="27" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><div align="center">
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:50" onClick="Salir()">
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
		if ($pw == 'N')
		{
			echo "alert('La Password Ingresada Es Incorrecta');";
		}	
		
		if ($anexo == 'N')
		{
			echo "alert('No Se Ha Generado el ANEXO.SEA, Por lo Tanto el Mes Esta Abierto');";
		}
		echo "</script>"
		
	?>

</form>
</body>
</html>
<?php	include("../principal/cerrar_principal.php"); ?>