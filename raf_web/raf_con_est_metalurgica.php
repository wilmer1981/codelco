<?
	$CodigoDeSistema=12;
	$CodigoDePantalla=16
?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<script language="JavaScript">
function Proceso(opc)
{
var f = document.FrmPrincipal;

	switch(opc)
	{
		case "W": 
			f.action="raf_con_est_metalurgica_web.php";
			f.submit();
			break;

		case "E": 
			f.action="raf_con_est_metalurgica_excel.php";
			f.submit();
			break;
		case "S":
			f.action="../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=9";
			f.submit();
			break;
	}

}

</script>
</head>

<body>
<form name="FrmPrincipal" method="post" action="">
<? include("../principal/encabezado.php")?>
<table width="770" border="0" class="TablaPrincipal"> 
<tr> 
	<td height="313" align="center" valign="middle">
	  <table width="600" height="80" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td width="78" height="29" align="right">Mes-A&ntilde;o:</td>
            <td width="519"> 
              <select name="Mes" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
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
              </select> <select name="Ano" style="width:60px;">
                <?
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
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
              </select>
              </td>
          </tr>
          <tr align="center"> 
            <td colspan="2"><input type="button" name="BtnWeb" value="Consulta" style="width:70px" onClick="Proceso('W');">
              <input type="button" name="BtnExcel" value="Excel" style="width:70px" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
          </tr>
        </table>
	    <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p><br>
      </p>      </td>
</tr>
</table>
<? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
