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
			var StLote="";
			for (i=0;i<f.IdLote.length;i++)
			{
				if (f.IdLote[i].checked == true)
				{
					StrDia=f.IdDia[i].value;
					StrMes=f.IdMes[i].value;
					StrAno=f.IdAno[i].value;
					StrLote=f.IdLote[i].value;
				}
			}
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaMeDor=S&IdDiaMeDor=" + StrDia + "&IdMesMeDor=" + StrMes + "&IdAnoMeDor=" + StrAno + "&IdLoteMeDor=" + StrLote +"&Tab1=true&TabM=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_ing_metal_dore02.php";
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
      <td width="74" class="titulo_azul">Fecha </td>
      <td width="208"> 
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
      <td width="86"><input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C');"></td>  <td width="211"><input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
  </tr>
</table>
  <br>
  <table width="620" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="35">&nbsp;</td>
      <td width="149"><strong>Num.Lote</strong></td>
      <td width="163"><strong>Num. Barras</strong></td>
      <td width="262"><strong>Peso Barra</strong></td>
    </tr>
    <?php  
	$Consulta =" select * from pmn_web.ingreso_metal_dore "; 
	$Consulta.= " where fecha = '".$AnoIniCon."-".$MesIniCon."-01' ";
	$Consulta.= " order by num_barra";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdLote'> \n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$LoteAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		if ($LoteAnt!=$Row[num_lote])
		{
			$Consulta="select count(*) as total from pmn_web.ingreso_metal_dore"; 
			$Consulta.=" where fecha ='".$Row["fecha"]."' and num_lote='".$Row[num_lote]."' ";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio' name='IdLote' value='".$Row[num_lote]."' onClick=\"Proceso('E');\">\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_lote]."&nbsp;</td>\n";
			echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
			$IdDia=substr($Row["fecha"],8,2);
			echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
			$IdMes=substr($Row["fecha"],5,2);
			echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
			$IdAno=substr($Row["fecha"],0,4);
		}
		
		echo "<td align='center'>".$Row[num_barra]."&nbsp;</td>\n";
		echo "<td align='center'>".$Row[peso_barra]."&nbsp;</td>\n";
		echo "</tr>\n";
		$LoteAnt=$Row[num_lote];
	}
?>
  </table>
</form>
</body>
</html>
