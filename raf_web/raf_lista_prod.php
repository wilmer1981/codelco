<?
	$CodigoDeSistema = 12;
	$CodigoDePantalla = 12;
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

			if(f.cmbproduccion.value == -1)
			{
				alert("Debe Seleccionar Tipo Produccion");
				f.cmbproduccion.focus();	 
				return
		    }

			if(f.cmbproduccion.value == 1)
			{
				f.action="raf_con_produccion01.php";
				f.submit();
			}						

			if(f.cmbproduccion.value == 2)
			{
				f.action="raf_con_produccion02.php";
				f.submit();
			}						

			if(f.cmbproduccion.value == 3)
			{
				f.action="raf_con_produccion03.php";
				f.submit();
			}						
			break;

		case "E": 

			if(f.cmbproduccion.value == -1)
			{
				alert("Debe Seleccionar Tipo Produccion");
				f.cmbproduccion.focus();	 
				return
		    }

			if(f.cmbproduccion.value == 1)
			{
				f.action="raf_con_produccion01_xls.php";
				f.submit();
			}						

			if(f.cmbproduccion.value == 2)
			{
				f.action="raf_con_produccion02_xls.php";
				f.submit();
			}						

			if(f.cmbproduccion.value == 3)
			{
				f.action="raf_con_produccion03_xls.php";
				f.submit();
			}						
			break;

		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=9";										 	
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
	<td height="313" align="center">
	  <table width="600" border="1" cellspacing="0" cellpadding="3" class="TablaDetalle">
          <tr> 
            <td width="76">Fecha:</td>
            <td width="505"> 
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
              </select></td>
          </tr>
          <tr> 
            <td>Producci&oacute;n:</td>
            <td><select name="cmbproduccion">
              <?
				echo"<option value='-1' selected>SELECCIONAR</option>";
				if($cmbbeneficio == "1")
					echo"<option value='1' selected>REFINO 01</option>";
				else
					echo"<option value='1'>REFINO 01</option>";
				if($cmbbeneficio == "2")
					echo"<option value='2' selected>REFINO 02</option>";
				else
					echo"<option value='2'>REFINO 02</option>";				
				
			?>
            </select></td>
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
