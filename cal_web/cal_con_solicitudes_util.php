<?php
$CodigoDeSistema = 1;
$CodigoDePantalla = 71;

$CookieRut=$_COOKIE["CookieRut"];
include("../principal/conectar_principal.php");
$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];


if(isset($_REQUEST["DiaIni"])) {
	$DiaIni = $_REQUEST["DiaIni"];
}else{
	$DiaIni =  date("d");
}
if(isset($_REQUEST["MesIni"])) {
	$MesIni = $_REQUEST["MesIni"];
}else{
	$MesIni =  date("m");
}
if(isset($_REQUEST["AnoIni"])) {
	$AnoIni = $_REQUEST["AnoIni"];
}else{
	$AnoIni =  date("Y");
}


if(isset($_REQUEST["DiaFin"])) {
	$DiaFin = $_REQUEST["DiaFin"];
}else{
	$DiaFin =  date("d");
}
if(isset($_REQUEST["MesFin"])) {
	$MesFin = $_REQUEST["MesFin"];
}else{
	$MesFin =  date("m");
}
if(isset($_REQUEST["AnoFin"])) {
	$AnoFin = $_REQUEST["AnoFin"];
}else{
	$AnoFin =  date("Y");
}
if(isset($_REQUEST["CmbSolFinal"])) {
	$CmbSolFinal = $_REQUEST["CmbSolFinal"];
}else{
	$CmbSolFinal = "";
}




?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=44";
			f.submit(); 
			break;
		case "E":
			f.action = "cal_xls_solicitudes_utilitario.php";
			f.submit();
			break;
	}
}


</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="765" border="0">
    <tr> 
      <td width="695" align="center" valign="middle"><strong>Utilitario Para Consultar Solicitudes P/Rango Fechas</strong></td>
    </tr>
  </table>
  <br>
  <table width="760" border="0" class="TablaDetalle">
    <tr> 
      <td width="86" height="24">Fecha Inicio</td>
      <td width="214"><select name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select> </td>
      <td width="94">Fecha Termino</td>
      <td colspan="3"> <select name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select>
        <select name="MesFin" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoFin" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select>      </td>
    </tr>
    <tr align="center" valign="middle"> 
      <td height="24" align="left">Solicitudes</td>
      <td height="24" align="left">
	    <select name="CmbSolFinal">
	  <option value="T">Totales</option>
	  <option value="NF">No Finalizadas</option>
	  </select>
	  &nbsp;</td>
      <td height="24" colspan="3">&nbsp;</td>
      <td height="24">&nbsp;</td>
    </tr>
    <tr align="center" valign="middle">
      <td height="24">&nbsp;</td>
      <td height="24">&nbsp;</td>
      <td height="24" colspan="3"><div align="left">
          <input type="button" name="BtnExcel2" value="Excel" onClick="Proceso('E');" style="width:70px;">
          <input type="button" name="BtnSalir2" value="Salir" onClick="Proceso('S')" style="width:70px;">
        </div>&nbsp;</td>
      <td height="24">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
