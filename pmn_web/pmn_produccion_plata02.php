<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "E":
			var StrDia="";
			var StrMes="";
			var StrAno="";
			var StrFecha="";
			for (i=1;i<f.IdFecha.length;i++)
			{
				if (f.IdFecha[i].checked == true)
				{
					StrFecha=f.IdFecha[i].value;
				}
			}
			StrDia=(StrFecha.substr(8,2));
			StrMes=(StrFecha.substr(5,2));
			StrAno=(StrFecha.substr(0,4));
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaPPlata=S&IdDiaPPlata=" + StrDia + "&IdMesPPlata=" + StrMes + "&IdAnoPPlata=" + StrAno+"&T=5&Tab11=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_produccion_plata02.php";
			f.submit();
			break;
	}
	
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="619" border="0" class="TablaDetalle">
    <tr>
    <td width="74" class="titulo_azul">Fecha Incio</td>
    <td width="208"><select name="DiaIniCon" style="width:50px;">
	<?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaIniCon))
		{
			if ($i == $DiaIniCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $DiaActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
      </select>
      <select name="MesIniCon" style="width:90px;">
	  <?php
	 for ($i=1;$i<=12;$i++)
	{
		if (isset($MesIniCon))
		{
			if ($i == $MesIniCon)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
		else
		{
			if ($i == $MesActual)
				echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
			else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
		}
	}
	  ?>
      </select>
      <select name="AnoIniCon" style="width:60px;">
	  <?php
	 for ($i=2002;$i<=date("Y");$i++)
	{
		if (isset($AnoIniCon))
		{
			if ($i == $AnoIniCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $AnoActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
      </select></td>
    <td width="86" class="titulo_azul">Fecha Termino</td>
    <td width="211"><select name="DiaFinCon" style="width:50px;">
	<?php
	for ($i=1;$i<=31;$i++)
	{
		if (isset($DiaFinCon))
		{
			if ($i == $DiaFinCon)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i == $DiaActual)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else	echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
	?>
      </select>
      <select name="MesFinCon" style="width:90px;">
	  <?php
	  	for ($i=1;$i<=12;$i++)
		{
			if (isset($MesFinCon))
			{
				if ($i == $MesFinCon)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
			else
			{
				if ($i == $MesActual)
					echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
				else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
			}
		}
		?>
      </select>
      <select name="AnoFinCon" style="width:60px;">
	  <?php
	  	for ($i=2002;$i<=date("Y");$i++)
		{
			if (isset($AnoFinCon))
			{
				if ($i == $AnoFinCon)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == $AnoActual)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
      </select></td>
  </tr>
</table>
<br>
  <table width="620" border="0">
    <tr>
    <td align="center">
<input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
      &nbsp; 
      <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
    </td>
  </tr>
</table>
<br>
  <table width="620" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="35" rowspan="2">&nbsp;</td>
      <td width="113" rowspan="2" align="center"><strong>Fecha</strong></td>
      <td width="147" rowspan="2" align="center"><strong>Num. Elect.</strong></td>
      <td width="130" rowspan="2" align="center"><strong>Num.Caja</strong></td>
      <td width="130" rowspan="2" align="center"><strong>Peso</strong></td>
      <td width="130" rowspan="2" align="center"><strong>Sobrante Rep</strong></td>
      <td colspan="2" align="center">N&ordm; de Caja</td>
    </tr>
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="130" align="center">Desde</td>
      <td width="130" align="center">Hasta</td>
    </tr>
    <?php  
	$Consulta = "select * from pmn_web.produccion_plata ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,num_electrolisis,num_caja";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		if ($FechaAnt!=$Row["fecha"])
		{
			$Consulta="select count(*) as total from pmn_web.produccion_plata ";
			$Consulta.=" where fecha='".$Row["fecha"]."'	";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio'  name='IdFecha' value='".$Row["fecha"]."' class='SinBorde' onClick=\"Proceso('E');\">\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		}
		echo "<td align='center'>".$Row[num_electrolisis]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[num_caja]."&nbsp;</td>\n";
		echo "<td align='center'>".number_format($Row["peso"],2)."&nbsp;</td>\n";
		echo "<td align='center'>".number_format($Row[sobrante],2)."&nbsp;</td>\n";
		echo '<td align="center">'.$Row[desde].'</td>';
      	echo '<td align="center">'.$Row[hasta].'</td>';
		//echo "<td align='center'>".$Row[granalla_reproceso]."&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
	}
?>
  </table>
</form>
</body>
</html>
