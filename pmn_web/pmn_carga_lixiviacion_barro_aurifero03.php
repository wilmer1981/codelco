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
			var StrElect="";
			var StrTurno="";
			for (i=0;i<f.IdElectrolisis.length;i++)
			{
				if (f.IdElectrolisis[i].checked == true)
				{
					StrElect=f.IdElectrolisis[i].value;
					StrTurno=f.IdTurno[i].value;
					StrDia=f.IdDia[i].value;
					StrMes=f.IdMes[i].value;
					StrAno=f.IdAno[i].value;
				}
			}
			window.opener.document.frmPrincipalRpt.action="pmn_principal_reportes.php?MostrarLixiv1=C&DLixiv1="+StrDia + "&MLixiv1="+StrMes + "&ALixiv1="+StrAno +"&TLixiv1="+StrTurno+"&Tab10=true&TabLixiAu1=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_carga_lixiviacion_barro_aurifero03.php";
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
    <td width="69" class="titulo_azul">Fecha Incio</td>
    <td width="222"><select name="DiaIniCon" style="width:50px;">
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
    <td width="221"><select name="DiaFinCon" style="width:50px;">
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
  <table width="619" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="39">&nbsp;</td>
      <td width="125"><strong>Num. Electrolisis.</strong></td>
      <td width="89"><strong>Correlativo</strong></td>
      <td width="104"><strong>Fecha</strong></td>
      <td width="82"><strong>Turno</strong></td>
      <td width="77"><strong>Peso</strong></td>
      <td width="86"><strong>Humedad</strong></td>
    </tr>
    <?php  
	$Consulta =" select * from pmn_web.carga_lixiviacion_barro_aurifero "; 
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,num_electrolisis";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdElectrolisis'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	echo "<input type='hidden' name='IdTurno'>\n";
	echo "<input type='hidden' name='IdFecha'>\n";
	while ($Row = mysqli_fetch_array($Respuesta))
	{		
		echo "<tr>\n"; 
		echo "<td align='center'>\n";
		echo "<input type='radio' name='IdElectrolisis' value='".$Row[num_electrolisis]."' onClick=\"Proceso('E');\">\n";
		echo "</td>\n";
		echo "<td align='center'>".$Row[num_electrolisis]."&nbsp;</td>\n";	
		echo "<td align='center'>".$Row[correlativo]."&nbsp;</td>\n";		
		echo "<td align='center'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";		
		switch ($Row[turno])
		{
			case "1":
				echo "<td align='center'>A</td>\n";	
			break;
			case "2":
				echo "<td align='center'>B</td>\n";	
			break;
			case "3":
				echo "<td align='center'>C</td>\n";	
			break;	
		}
		/*echo "<input type='hidden' name='IdElectrolisis' value='".$Row[num_electrolisis]."'>\n";
		$IdElectrolsis=$Row[num_electrolisis];*/	
		echo "<td align='center'>".number_format($Row["peso"],2,",","")."&nbsp;</td>\n";
		echo "<td align='center'>".number_format($Row[humedad],2,",","")."&nbsp;</td>\n";			
		echo "<input type='hidden' name='IdTurno' value='".$Row[turno]."'>\n";
		$IdTurno=$Row[turno];
		echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],0,4);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		echo "</tr>\n";
	}
?>
  </table>
</form>
</body>
</html>
