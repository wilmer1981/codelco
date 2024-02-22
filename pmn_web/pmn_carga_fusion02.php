<?php
include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,V)
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
					StrDia=f.IdDia[i].value;
					StrMes=f.IdMes[i].value;
					StrAno=f.IdAno[i].value;
					StrFecha=f.IdFecha[i].value;
				}
			}
			StrDia=(StrFecha.substr(8,2));
			StrMes=(StrFecha.substr(5,2));
			StrAno=(StrFecha.substr(0,4));
			window.opener.document.frmPrincipalRpt.action = "pmn_principal_reportes.php?ConsultaFusion=S&IdDiaFusion=" + StrDia + "&IdMesFusion=" + StrMes + "&IdAnoFusion=" + StrAno + "&IdFechaFusion=" + StrFecha + "&VerFusion="+V+"&Tab5=true";
			window.opener.document.frmPrincipalRpt.submit();
			window.close();
			break;
		case "S":
			window.close();
			break;
		case "C":
			f.action = "pmn_carga_fusion02.php?Ver="+V;
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
    <td width="71" class="titulo_azul">Fecha Incio</td>
    <td width="220"><select name="DiaIniCon" style="width:50px;">
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
<input type="button" name="BtnConsultar" value="Consultar" style="width:70px" onClick="Proceso('C','<?php echo $Ver;   ?>');">
      &nbsp; 
      <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
    </td>
  </tr>
</table>
<br>
  <table width="700" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="TituloCabeceraAzul"> 
      <td width="35">&nbsp;</td>
      <td width="116"><strong>Fecha</strong></td>
      <td width="140"><strong>Producto</strong></td>
      <td width="130"><strong>SubProducto.</strong></td>
      <td width="60"><strong>Peso</strong></td>
      <td width="159"><strong>Observacion</strong></td>
    </tr>
    <?php  
	$Consulta= "select t1.fecha,t1.peso,t2.descripcion as DesProducto,t3.descripcion as DesSubProducto, ";
	$Consulta= $Consulta." t3.cod_subproducto,t2.cod_producto,t1.peso,t1.observacion  ";
	$Consulta= $Consulta." from pmn_web.fusion t1 ";
	$Consulta= $Consulta." left join proyecto_modernizacion.productos t2 on ";
	$Consulta= $Consulta." t1.producto = t2.cod_producto "; 
	$Consulta= $Consulta." left join proyecto_modernizacion.subproducto t3 on ";
	$Consulta= $Consulta." t1.subproducto = t3.cod_subproducto and t2.cod_producto=t3.cod_producto ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by t1.fecha,t1.producto,t1.subproducto";
	$Respuesta = mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n"; 
		if ($FechaAnt!=$Row["fecha"])
		{
			$Consulta="select count(*) as total from pmn_web.fusion ";
			$Consulta.=" where fecha='".$Row["fecha"]."'	";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			echo "<td align='center' rowspan='".$TotalFilas."'>\n";
			echo "<input type='radio' name='IdFecha' value='".$Row["fecha"]."' onClick=\"Proceso('E','$Ver');\">\n";
			echo "</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
			echo "<input type='hidden' name='IdDia' value='".substr($Row["fecha"],8,2)."'>\n";
		$IdDia=substr($Row["fecha"],8,2);
		echo "<input type='hidden' name='IdMes' value='".substr($Row["fecha"],5,2)."'>\n";
		$IdMes=substr($Row["fecha"],5,2);
		echo "<input type='hidden' name='IdAno' value='".substr($Row["fecha"],0,4)."'>\n";
		$IdAno=substr($Row["fecha"],0,4);
		}	
		echo "<td align='left'>".$Row[DesProducto]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row[DesSubProducto]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["peso"]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["observacion"]."&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
	}
?>
  </table>
</form>
</body>
</html>
