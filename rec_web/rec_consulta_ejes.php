<?php
	$CodigoDeSistema = 8;
	$CodigoDePantalla = 2;
	$AnoIni =  isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$MesIni =  isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$DiaIni =  isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$AnoFin =  isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$MesFin =  isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$DiaFin =  isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	
	$Romana =  isset($_REQUEST["Romana"])?$_REQUEST["Romana"]:"";
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "W":
			f.action = "rec_consulta_ejes_web.php";
			f.submit();
			break;
		case "E":
			f.action = "rec_consulta_ejes_excel.php";
			f.submit();
			break;
		case "R":
			f.action = "rec_consulta_ejes.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=8";
			f.submit(); 
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
<?php include("../principal/encabezado.php")?>
  <table width="771" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td width="757" height="316" valign="top"> 
        <table width="700" border="0" align="center" cellpadding="3" cellspacing="3" class="TablaInterior">
          <tr> 
            <td width="92">Fecha Inicio:</td>
            <td width="228"><select name="DiaIni" style="width:50px;">
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
              </select></td>
            <td width="103">Fecha Termino:</td>
            <td width="235"><select name="DiaFin" style="width:50px;">
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
              </select> <select name="MesFin" style="width:90px;">
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
              </select></td>
          </tr>
          <tr>
            <td>Romana:</td>
            <td><select name="Romana" style="width:200px">
                <option value="1" selected>Romana 01(215)</option>
                <option value="2">Romana 02(216)</option>
              </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="700" border="0" align="center" cellpadding="3" cellspacing="3" class="TablaInterior">
          <tr>
            <td align="center">
<input type="button" name="btnWeb" value="Consulta Web" onClick="Proceso('W');" style="width:90px">
              <input type="button" name="btnExcel" value="Consulta Excel" onClick="Proceso('E');" style="width:90px">
              <input type="button" name="btnsalir" value="Salir" onClick="Proceso('S');" style="width:90px">
            </td>
          </tr>
        </table> 
      </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
