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
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaEmPlata=S&BloquearEmPlata=B&MostrarEmPlata=V&IdDiaEmPlata=" + StrDia + "&IdMesEmPlata=" + StrMes + "&IdAnoEmPlata=" + StrAno + "&IdFechaEmPlata=" + StrFecha+"&Tab9=true&TabEmba2=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_embarque_plata02.php";
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
  <table width="730" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="23">&nbsp;</td>
      <td width="120"><strong>Fecha</strong></td>
      <td width="120"><strong>Cantidad</strong></td>
      <td width="120"><strong>Peso</strong></td>
      <td width="120"><strong>Valor Us$</strong></td>
      <td width="60"><strong>Acta</strong></td>
      <td width="60"><strong>Detalle </strong></td>
    </tr>
    <?php  
	$Consulta="select * from pmn_web.embarque_plata  ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by correlativo,cantidad";
	$Respuesta=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		if ($FechaAnt!=$Row["fecha"])
		{
			$Consulta="select count(*) as total from pmn_web.embarque_plata  ";
			$Consulta.=" where fecha='".$Row["fecha"]."'	";
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			//echo $TotalFilas."<br>";
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E','$Ver');\">\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		}
		echo "<td align='center'>".number_format($Row[cantidad],0,",",".")."&nbsp;</td>\n";
		echo "<td align='center'>".number_format($Row["peso"],0,",",".")."&nbsp;</td>\n";
		echo "<td align='center'>".number_format($Row["valor"],0,",",".")."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[num_acta]."&nbsp;</td>\n";
		$Consulta = "select * from pmn_web.detalle_embarque_plata ";
		$Consulta.= " where ano = '".substr($Row["fecha"],0,4)."'";
		$Consulta.= " and mes = '".intval(substr($Row["fecha"],5,2))."'";
		$Consulta.= " and num_acta = '".$Row[num_acta]."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
			echo "<td align='center'>SI</td>\n";
		else
			echo "<td align='center'><font color='RED'>NO</font></td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
		$TotalCantidad=$TotalCantidad+$Row[cantidad];
		$TotalPeso=$TotalPeso+$Row["peso"];
		$TotalValor=$TotalValor+$Row["valor"];
	}
	echo "<tr>";
		echo "<td>";
		echo "</td>";
		echo "<td align='center'><strong>Totales</strong></td>";									
		echo "<td align='center'><strong>";
		echo number_format($TotalCantidad,0,",",".");
		echo "</strong></td>";
		echo "<td align='center'><strong>";
		echo number_format($TotalPeso,0,",",".");
		echo "</strong></td>";
		echo "<td align='center'><strong>";
		echo number_format($TotalValor,0,",",".");
		echo "</strong></td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
	echo "</tr>";
?>
  </table>
</form>
</body>
</html>
