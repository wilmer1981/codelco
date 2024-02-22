<?php
	$CodigoDeSistema = 8;
	$CodigoDePantalla = 2;

	if(isset($_REQUEST["DiaIni"])){
		$DiaIni=$_REQUEST["DiaIni"];
	}else{
		$DiaIni=date('d');
	}
	if(isset($_REQUEST["MesIni"])){
		$MesIni=$_REQUEST["MesIni"];
	}else{
		$MesIni=date('m');
	}
	if(isset($_REQUEST["AnoIni"])){
		$AnoIni=$_REQUEST["AnoIni"];
	}else{
		$AnoIni=date('Y');
	}

	if(isset($_REQUEST["DiaFin"])){
		$DiaFin=$_REQUEST["DiaFin"];
	}else{
		$DiaFin=date('d');
	}
	if(isset($_REQUEST["MesFin"])){
		$MesFin=$_REQUEST["MesFin"];
	}else{
		$MesFin=date('m');
	}
	if(isset($_REQUEST["AnoFin"])){
		$AnoFin=$_REQUEST["AnoFin"];
	}else{
		$AnoFin=date('Y');
	}
	if(isset($_REQUEST["Romana"])){
		$Romana=$_REQUEST["Romana"];
	}else{
		$Romana=date('Y');
	}

	/*
	echo gethostname(); //puede imprimir: sandie

	echo "<br>".$_SERVER['SERVER_NAME'];
	*/


?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<?php
//echo '<link href="../principal/estilos/css_sipa_web.css" rel="stylesheet" type="text/css">';
?>
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
			f.action="../principal/sistemas_usuario.php?CodSistema=24";
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
            <td width="228"><SELECT name="DiaIni" style="width:50px;">
                <?php
					for ($i = 1;$i <= 31; $i++)
					{
						if (isset($DiaIni))
						{
							if ($DiaIni == $i)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}/*
						else
						{
							if ($i == date("j"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}*/
					}
				?>
              </SELECT> <SELECT name="MesIni" style="width:90px;">
                <?php
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesIni))
					{
						if ($MesIni == $i)
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}/*
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}*/
				}
				?>
              </SELECT> <SELECT name="AnoIni" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoIni))
					{
						if ($AnoIni == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}/*
					else
					{
						if ($i == date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}*/
				}
				?>
              </SELECT></td>
            <td width="103">Fecha Termino:</td>
            <td width="235"><SELECT name="DiaFin" style="width:50px;">
                <?php
					for ($i = 1;$i <= 31; $i++)
					{
						if (isset($DiaFin))
						{
							if ($DiaFin == $i)
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}/*
						else
						{
							if ($i == date("j"))
								echo "<option SELECTed value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}*/
					}
				?>
              </SELECT>
			  <SELECT name="MesFin" style="width:90px;">
                <?php
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesFin))
					{
						if ($MesFin == $i)
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}/*
					else
					{
						if ($i == date("n"))
							echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}*/
				}
				?>
              </SELECT>
			  <SELECT name="AnoFin" style="width:60px;">
                <?php
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoFin))
					{
						if ($AnoFin == $i)
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}/*
					else
					{
						if ($i == date("Y"))
							echo "<option SELECTed value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}*/
				}
				?>
              </SELECT></td>
          </tr>
          <tr>
            <td>Romana:</td>
            <td><SELECT name="Romana" style="width:200px">
                <option value="1" SELECTed>Romana 01(215)</option>
                <option value="2">Romana 02(216)</option>
              </SELECT></td>
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
