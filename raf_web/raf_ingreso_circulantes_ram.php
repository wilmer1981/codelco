<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;

$fecha = $Ano.'-'.$Mes.'-'.$Dia;
if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.circulantes WHERE fecha='$fecha'";
	$Elimina.= " AND cod_producto = 50 AND cod_subproducto = 5";
	mysql_query($Elimina);

	$PrecipitadoCu = '';
	$Total = '';					

}


if($Proceso == "B")
{
	$Consulta = " SELECT * FROM raf_web.circulantes WHERE fecha = '$fecha'";
	$Consulta.= " AND cod_producto = 50 AND cod_subproducto = 5";
	$rs = mysqli_query($link, $Consulta);
	if($Fila = mysql_fetch_array($rs))
	{
		$PrecipitadoCu = $Fila["peso"];					
	}


	$Total = $PrecipitadoCu; 
}

?>
<html>
<head>
<title>Circulantes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Calcula()
{
	var f = document.FrmPopUp;

	f.Total.value = f.PrecipitadoCu.value * 1 + f.OtrosCirc.value * 1; 
}

function Proceso(opc)
{
	var f = document.FrmPopUp;
	
	switch (opc)
	{
		case "G":
			f.action = "raf_ingreso_circulantes_ram01.php?Proceso=G";
			f.submit();
			break							

		case "B":
			f.action = "raf_ingreso_circulantes_ram.php?Proceso=B";
			f.submit();
			break							

		case "E":
			f.action = "raf_ingreso_circulantes_ram.php?Proceso=E";
			f.submit();
			break							
	
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=10";										 	
			break							
	
	}

}

</script>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body>
<form name="FrmPopUp" method="post" action="">
  <? include("../principal/encabezado.php")?>
  <table width="770" height="140" border="0" class="TablaPrincipal">
    <tr> 
      <td align="center">
        <table width="482" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td width="87">Fecha Recep</td>
            <td width="392"><select name="Dia" style="width:50px;">
                <?
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
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
              </select> <select name="Mes" style="width:90px;">
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
              <input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');"></td>
          </tr>
        </table>
		<br>
        <table width="482" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="3" align="center">Circulantes Ram</td>
          </tr>
          <tr class="Detalle01"> 
            <td width="162" align="center">Descripci&oacute;n</td>
            <td width="180" align="center">Peso Kg</td>
            <td width="133">&nbsp;</td>
          </tr>
          <tr> 
            <td>Precipitado Cobre (Cu)</td>
            <td align="center"><input type="text" name="PrecipitadoCu" size="20 "value="<? echo $PrecipitadoCu?>" onBlur="Calcula();"></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>Otros Circulantes Ram</td>
            <td align="center"><input type="text" name="OtrosCirc" size="20" value="<? echo $OtrosCirc?>" onBlur="Calcula();"></td>
            <td>&nbsp;</td>
          </tr>
          <tr class="ColorTabla02"> 
            <td><strong>Total</strong></td>
            <td align="center"><input type="text" name="Total" size="20" value="<? echo $Total?>"></td>
            <td>&nbsp;</td>
          </tr>
        </table>				
        	<br>	
			<table width="482" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
				<tr>
				  <td align="center">
					<input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="Proceso('S');">
				  </td>	
				</tr>
		    </table>		
	  </td>	
   </tr>
</table>
 <? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
