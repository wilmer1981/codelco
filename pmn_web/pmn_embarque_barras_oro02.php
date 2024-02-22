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
			for (i=1;i<f.IdFecha.length;i++)
			{
				if (f.IdFecha[i].checked == true)
				{
					/*StrDia=f.IdDia[i].value;
					StrMes=f.IdMes[i].value;
					StrAno=f.IdAno[i].value;*/
					StrFecha=f.IdFecha[i].value;
				}
			}
			StrDia=(StrFecha.substr(8,2));
			StrMes=(StrFecha.substr(5,2));
			StrAno=(StrFecha.substr(0,4));
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaBarraOro=S&BloquearBarraOro=B&MostrarBarraOro=V&IdDiaBarraOro=" + StrDia + "&IdMesBarraOro=" + StrMes + "&IdAnoBarraOro=" + StrAno + "&IdFechaBarraOro=" + StrFecha+"&Tab9=true&TabEmba1=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_embarque_barras_oro02.php";
			f.submit();
			break;
	}
	
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="748" border="0" class="TablaDetalle">
    <tr>
    <td width="76" class="titulo_azul">Fecha Incio</td>
    <td width="215"><select name="DiaIniCon" style="width:50px;">
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
    <td width="89" class="titulo_azul">Fecha Termino</td>
    <td width="350"><select name="DiaFinCon" style="width:50px;">
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
  <table width="750" border="0">
    <tr>
    <td width="744" align="center">
<input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');">
      &nbsp; 
      <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
    </td>
  </tr>
</table>
<br>
  <table width="750" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="23">&nbsp;</td>
      <td width="120"><strong>Fecha</strong></td>
      <td width="120"><strong>N&deg;Barra</strong></td>
      <td width="120"><strong>Peso NetoBarra</strong></td>
      <td width="120"><strong>Peso Neto Caja</strong></td>
      <td width="120"><strong>Peso Bruto Caja</strong></td>
      <td width="120"><strong>Valor Dec</strong></td>
      <td width="120"><strong>N&deg; Sello</strong></td>
    </tr>
    <?php  
	$Consulta = "select * from pmn_web.embarque_oro ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,num_sello";
	$Respuesta=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	$SelloAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		
		//echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E','$Ver');\">\n";
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		
		if ($FechaAnt != $Row["fecha"])
		{
			$Consulta = "select count(*) as total from pmn_web.embarque_oro  ";
			$Consulta.= " where fecha = '".$Row["fecha"]."' ";
			$Consulta.= " order by fecha,num_sello";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' class='SinBorde' onClick=\"Proceso('E','$Ver');\">\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		
		}
		echo "<td align='center'>".$Row[num_barra]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[peso_neto_barra]."&nbsp;</td>\n";
		if ($SelloAnt != $Row[num_sello])	
		{
			$Consulta = "select count(*) as total from pmn_web.embarque_oro  ";
			$Consulta.= " where fecha = '".$Row["fecha"]."' and num_sello='".$Row[num_sello]."' ";
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			$Row2 = mysqli_fetch_array($Resp2);	
			$TotalFilas2 = $Row2["total"];
			echo "<td align='center' rowspan='".$TotalFilas2."'>".$Row[peso_neto_caja]."&nbsp;</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas2."'>".$Row[peso_bruto_caja]."&nbsp;</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas2."'>".$Row[valor_declarado]."&nbsp;</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas2."'>".$Row[num_sello]."&nbsp;</td>\n";
		}		
		echo "</tr>\n";
		$FechaAnt = $Row["fecha"];
		$SelloAnt = $Row[num_sello];
	}
?>
  </table>
</form>
</body>
</html>
