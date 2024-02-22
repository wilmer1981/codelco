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
		case "S":
			f.action = "pmn_consulta_report.php";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
function Excel(FI,FT)
{
	var f = document.frmConsulta;
	f.action ="pmn_excel_embarque_plata.php?FechaIni="+FI + "&FechaFin="+FT;
	f.submit();	
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <table width="750" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="263" align="center" colspan="5"><strong>Consulta Embarque 
          PLata</strong>&nbsp; </td>
    </tr>
  </table>  <br>
  <table width="750" border="0">
    <tr>
      <td width="744" align="center"> 
        <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
        &nbsp; 
        <?php
		$FechaIni=$AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
		$FechaFin=$AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
		?>
		<input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>');">
        &nbsp; 
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"> 
      </td>
  </tr>
</table>
<br>
  <table width="730" border="1" cellpadding="0" cellspacing="0" class="TituloCabeceraAzul">
    <tr align="center" class="ColorTabla01"> 
      <td width="120"><strong>Fecha</strong></td>
      <td width="120"><strong>Cantidad</strong></td>
      <td width="120"><strong>Peso</strong></td>
      <td width="120"><strong>Valor Us$</strong></td>
      <td width="120"><strong>Acta</strong></td>
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
			echo "<td align='center' rowspan='".$TotalFilas."'>".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
		}
		echo "<td align='left'>".$Row[cantidad]."&nbsp;</td>\n";
		echo "<td align='left'>".$Row["peso"]."&nbsp;</td>\n";
		echo "<td align='left'>".number_format($Row["valor"],2,",","")."&nbsp;</td>\n";
		echo "<td align='left'>".$Row[num_acta]."&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt=$Row["fecha"];
		$TotalCantidad=$TotalCantidad+$Row[cantidad];
		$TotalPeso=$TotalPeso+$Row["peso"];
		$TotalValor=$TotalValor+$Row["valor"];
	}
	echo "<tr>";
		echo "<td align='right'><strong>Totales</strong></td>";									
		echo "<td align='left'><strong>";
		echo $TotalCantidad;
		echo "</strong></td>";
		echo "<td><strong>";
		echo $TotalPeso;
		echo "</strong></td>";
		echo "<td><strong>";
		echo number_format($TotalValor,2,",","");
		echo "</strong></td>";
		echo "<td>";
		echo "</td>";
	echo "</tr>";
?>
  </table>
</form>
</body>
</html>
