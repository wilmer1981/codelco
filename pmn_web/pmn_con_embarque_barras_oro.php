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
		case "C":
			f.action = "pmn_embarque_barras_oro02.php";
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
	f.action ="pmn_excel_embarque_barras_oro.php?FechaIni="+FI + "&FechaFin="+FT;
	f.submit();	
}
</script>
</head>

<body class="TituloCabeceraOz">
<form name="frmConsulta" action="" method="post">
  <br>
  <table width="750" border="0">
    <tr> 
      <td width="263" align="center"> <div align="left" class="titulo_azul"><strong>Consulta Embarque 
          Oro</strong>&nbsp; </div></td>
      <td width="477" align="center"><div align="left">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
        <?php
		$FechaIni=$AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
		$FechaFin=$AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
		?>
		  <input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>');">
        </div></td>
    </tr>
  </table>
<br>
  <table width="978" border="1" cellpadding="0" cellspacing="0" class="TituloCabeceraAzul">
    <tr align="center" class="ColorTabla01"> 
      <td width="120"><strong>Fecha</strong></td>
      <td width="88"><strong>Acta</strong></td>
      <?php //<td width="152"><strong>Suma Por Embarque</strong></td> ?>
	  <td width="152"><strong>N&deg;Barra</strong></td>
      <td width="120"><strong>Peso NetoBarra</strong></td>
      <td width="120"><strong>Peso Neto Caja</strong></td>
      <td width="120"><strong>Peso Bruto Caja</strong></td>
      <td width="120"><strong>Valor Dec</strong></td>
      <td width="120"><strong>Num Sello</strong></td>
    </tr>
    <?php  
	$Consulta = "select * from pmn_web.embarque_oro ";
	$Consulta.= " where fecha between '".$AnoIniCon."-".$MesIniCon."-".$DiaIniCon."' and '".$AnoFinCon."-".$MesFinCon."-".$DiaFinCon."' ";
	$Consulta.= " order by fecha,num_acta,num_sello,num_barra";
	//echo $Consulta."<br>";
	$Respuesta=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='IdFecha'>\n";
	echo "<input type='hidden' name='IdDia'>\n";
	echo "<input type='hidden' name='IdMes'>\n";
	echo "<input type='hidden' name='IdAno'>\n";
	$FechaAnt="";
	$SelloAnt="";
	$SumaNetoBarra=0;
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
			//echo $Consulta."<br>";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Resp);
			$TotalFilas=$Fila["total"];
			echo "<td align='center' rowspan='".$TotalFilas."' >".substr($Row["fecha"],8,2)."-".substr($Row["fecha"],5,2)."-".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
			echo "<td align='center' rowspan='".$TotalFilas."'>".$Row[num_acta]."&nbsp;</td>\n";

			$Cantidad = $TotalFilas;
			$SubSumaNetoBarra=0;
			$SubSumaNetoCaja=0;
			$SubSumaBruto=0;
			$SubSumaValor=0;			
		}
		else
			$Cantidad--;

		echo "<td align='center'>".$Row[num_barra]."&nbsp;</td>\n";
		echo "<td align='center'>".number_format($Row[peso_neto_barra],4,",","")."&nbsp;</td>\n";
		
		if ($SelloAnt != $Row[num_sello])	
		{
			$Consulta = "select count(*) as total from pmn_web.embarque_oro  ";
			$Consulta.= " where fecha = '".$Row["fecha"]."' and num_sello='".$Row[num_sello]."' ";
			//echo $Consulta."<br>";
			$Resp2 = mysqli_query($link, $Consulta);
			$Row2 = mysqli_fetch_array($Resp2);	
			$TotalFilas2 = $Row2["total"];
			echo "<td align='center' rowspan='$TotalFilas2'>".number_format($Row[peso_neto_caja],4,",","")."&nbsp;</td>\n";
			echo "<td align='center' rowspan='$TotalFilas2'>".number_format($Row[peso_bruto_caja],4,",","")."&nbsp;</td>\n";
			echo "<td align='center' rowspan='$TotalFilas2'>".$Row[valor_declarado]."&nbsp;</td>\n";
			echo "<td align='center' rowspan='$TotalFilas2'>".$Row[num_sello]."&nbsp;</td>\n";

			$SubSumaNetoCaja=$SubSumaNetoCaja+$Row[peso_neto_caja];
			$SubSumaBruto=$SubSumaBruto+$Row[peso_bruto_caja];
			$SubSumaValor=$SubSumaValor+$Row[valor_declarado];			
		}
		
		echo "</tr>\n";
		$SubSumaNetoBarra=$SubSumaNetoBarra+$Row[peso_neto_barra];

		if ($Cantidad == 1)
		{
			echo "<tr>\n";
			echo "<td>";
			echo "</td>";
			echo "<td>";
			echo "</td>";
			echo "<td align='center'>";
			echo "<strong>Total</strong>";
			echo "</td>";
			echo "<td align='center'><strong>";
			echo number_format($SubSumaNetoBarra,4,",","");
			echo "</strong></td>";
			echo "<td align='center'><strong>";
			echo number_format($SubSumaNetoCaja,4,",","");
			echo "</strong></td>";
			echo "<td align='center'><strong>";
			echo number_format($SubSumaBruto,4,",","");
			echo "</strong></td>";
			echo "<td align='center'><strong>";
			echo $SubSumaValor;
			echo "</strong></td>";
			echo "</tr>\n";			
		}
		
		
		$FechaAnt = $Row["fecha"];
		$SelloAnt = $Row[num_sello];
		$ActaAnt = $Row[num_acta];		
	}
?>
  </table>
</form>
</body>
</html>
