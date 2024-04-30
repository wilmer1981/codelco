<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<br>
<strong>&nbsp;&nbsp;DETALLE DEL NODO: 
<?php 
	echo $Nodo;
	
	$consulta = "SELECT * FROM proyecto_modernizacion.nodos";
	$consulta.= " WHERE cod_nodo = '".$Nodo."' AND sistema = 'PMN'";
	$rs = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($rs))
		echo " - ".$row["descripcion"];
?>
</strong>
<br><br>

  <table width="720" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr  class="ColorTabla01">  
      <td width="44" rowspan="2" align="center">+/-</td>
      <td width="42" rowspan="2" align="center">FLUJO</td>
      <td width="271" rowspan="2" align="center">DESCRIPCION</td>
      <td width="80" rowspan="2" align="center">PESO</td>
      <td colspan="2" align="center">LEYES</td>
      <td colspan="2" align="center">FINOS</td>
    </tr>
    <tr  class="ColorTabla01" > 
      <td width="53" align="center">Ag</td>
      <td width="54" align="center">Au</td>
      <td width="65" align="center">Ag</td>
      <td width="61" align="center">Au</td>
    </tr>
    <?php
	//--------.
	//STOCK INICIAL.
	if ($Mes == 1)
	{
		$MesAnt = 12;
		$AnoAnt = $Ano - 1;						
	}
	else
	{
		$MesAnt = $Mes - 1;
		$AnoAnt = $Ano;
	}
		
	
	//INICIAL.
	$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
	$consulta.= " FROM pmn_web.existencia_nodo";
	$consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' AND nodo = '".$Nodo."'";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	$row = mysqli_fetch_array($rs);	

	echo '<tr class="Detalle02">';
	echo '<td align="center">&nbsp;</td>';
	echo '<td align="center">&nbsp;</td>';
	echo '<td align="left">EXISTENCIA INICIAL</td>';
	echo '<td align="right">'.number_format($row["peso"],3,",",".").'</td>';
	if ($row["peso"] == 0)
	{
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">&nbsp;</td>';	
	
	}
	else
	{
		echo '<td align="right">'.number_format(($row[fino_ag]/$row["peso"]*1000),2,",",".").'</td>';
		echo '<td align="right">'.number_format(($row[fino_au]/$row["peso"]*1000),2,",",".").'</td>';	
	}

	echo '<td align="right">'.number_format($row[fino_ag],3,",",".").'</td>';
	echo '<td align="right">'.number_format($row[fino_au],3,",",".").'</td>';
	echo '</tr>';			
	

	//-------.		
	//DETALLE DE LOS FLUJOS.
	$consulta = "SELECT t1.cod_flujo, t1.descripcion, t2.peso, t2.fino_ag, t2.fino_au,";
	$consulta.= " CASE WHEN t1.tipo = 'E' THEN '+' ELSE '-' END signo";	
	$consulta.= " FROM proyecto_modernizacion.flujos AS t1";
	$consulta.= " LEFT JOIN pmn_web.flujos_mes AS t2";
	$consulta.= " ON t1.cod_flujo = t2.flujo AND ano = '".$Ano."' AND mes = '".$Mes."'";
	$consulta.= " WHERE t1.nodo = '".$Nodo."' AND (t1.esflujo != 'N' OR ISNULL(t1.esflujo)) AND t1.sistema = 'PMN'";
	$consulta.= " ORDER BY t1.tipo, CEILING(cod_flujo)";
	//echo $consulta;
	
	$TotalPeso = 0;
	$TotalAg = 0;
	$TotalAu = 0;
	$SignoAux = '-';
	$rs1 = mysqli_query($link, $consulta);
	while ($row1 = mysqli_fetch_array($rs1))
	{	
		if ($row1["signo"] == $SignoAux)
		{
			$SignoAux = '';
			echo '<tr class="Detalle01">';
			echo '<td align="right" colspan="3">TOTAL</td>';
			echo '<td align="right">'.number_format($TotalPeso,3,",",".").'</td>';
			if ($TotalPeso == 0)
			{
				echo '<td align="right">&nbsp;</td>';
				echo '<td align="right">&nbsp;</td>';			
			}
			else
			{
				echo '<td align="right">'.number_format(($TotalAg/$TotalPeso*1000),2,",",".").'</td>';
				echo '<td align="right">'.number_format(($TotalAu/$TotalPeso*1000),2,",",".").'</td>';
			}
			echo '<td align="right">'.number_format($TotalAg,3,",",".").'</td>';
			echo '<td align="right">'.number_format($TotalAu,3,",",".").'</td>';									
			echo '</tr>';
			
			$TotalPeso = 0;
			$TotalAg = 0;
			$TotalAu = 0;			
		}	
	
		echo '<tr>';
		echo '<td align="center">'.$row1["signo"].'</td>';
		echo '<td align="center">'.$row1[cod_flujo].'</td>';
		echo '<td align="left">'.$row1["descripcion"].'</td>';
		echo '<td align="right">'.number_format($row1["peso"],3,",",".").'</td>';
		if ($row1["peso"] == 0)
		{
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';		
		}
		else
		{
			echo '<td align="right">'.number_format(($row1[fino_ag]/$row1["peso"]*1000),2,",",".").'</td>';
			echo '<td align="right">'.number_format($row1[fino_au]/$row1["peso"]*1000,2,",",".").'</td>';
		}
		echo '<td align="right">'.number_format($row1[fino_ag],3,",",".").'</td>';
		echo '<td align="right">'.number_format($row1[fino_au],3,",",".").'</td>';
		echo '</tr>';
		
		$TotalPeso = $TotalPeso + $row1["peso"];
		$TotalAg = $TotalAg + $row1[fino_ag];
		$TotalAu = $TotalAu + $row1[fino_au];
	}
	
	echo '<tr  class="Detalle01">';
	echo '<td align="right" colspan="3">TOTAL</td>';
	echo '<td align="right">'.number_format($TotalPeso,3,",",".").'</td>';
	if ($TotalPeso == 0)
	{
		echo '<td align="right">&nbsp;</td>';
		echo '<td align="right">&nbsp;</td>';
	}
	else
	{
		echo '<td align="right">'.number_format(($TotalAg/$TotalPeso*1000),2,",",".").'</td>';
		echo '<td align="right">'.number_format(($TotalAu/$TotalPeso*1000),2,",",".").'</td>';	
	}

	echo '<td align="right">'.number_format($TotalAg,3,",",".").'</td>';
	echo '<td align="right">'.number_format($TotalAu,3,",",".").'</td>';									
	echo '</tr>';	
	
	
	//--------.
	//STOCK FINAL.
	$consulta = "SELECT IFNULL(SUM(peso),0) AS peso, IFNULL(SUM(fino_cu),0) AS fino_cu, IFNULL(SUM(fino_ag),0) AS fino_ag, IFNULL(SUM(fino_au),0) AS fino_au";
	$consulta.= " FROM pmn_web.existencia_nodo";
	$consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND nodo = '".$Nodo."'";
	//echo $consulta."<br>";
	$rs2 = mysqli_query($link, $consulta);
	$row2 = mysqli_fetch_array($rs2);
	
	echo '<tr class="Detalle02">';
	echo '<td align="center">&nbsp;</td>';
	echo '<td align="center">&nbsp;</td>';
	echo '<td align="left">EXISTENCIA FINAL</td>';
	echo '<td align="right">'.number_format($row2["peso"],3,",",".").'</td>';
	if ($row2["peso"] == 0)
	{
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';	
	}
	else
	{
		echo '<td align="right">'.number_format(($row2[fino_ag]/$row2["peso"]*1000),2,",",".").'</td>';
		echo '<td align="right">'.number_format(($row2[fino_au]/$row2["peso"]*1000),2,",",".").'</td>';
	}
	echo '<td align="right">'.number_format($row2[fino_ag],3,",",".").'</td>';
	echo '<td align="right">'.number_format($row2[fino_au],3,",",".").'</td>';
	echo '</tr>';		
?>
  </table>
  <br><br>
<?php
	$TotalDifEntPeso = $row["peso"];
	$TotalDifEntAg = $row[fino_ag];
	$TotalDifEntAu = $row[fino_au];
	$TotalDifSalPeso = $row2["peso"];
	$TotalDifSalAg = $row2[fino_ag];
	$TotalDifSalAu = $row2[fino_au];	
	
	$consulta = "SELECT IFNULL(SUM(t2.peso),0) AS peso, IFNULL(SUM(t2.fino_ag),0) AS fino_ag, IFNULL(SUM(t2.fino_au),0) AS fino_au";
	$consulta.= " FROM proyecto_modernizacion.flujos AS t1";
	$consulta.= " LEFT JOIN pmn_web.flujos_mes AS t2";
	$consulta.= " ON t1.cod_flujo = t2.flujo AND ano = '".$Ano."' AND mes = '".$Mes."' AND t1.sistema = 'PMN'";
	$consulta.= " WHERE t1.nodo = '".$Nodo."' AND (t1.esflujo != 'N' OR ISNULL(t1.esflujo)) AND t1.tipo = 'E'";	
	//echo $consulta."<br>";
	$rs5 = mysqli_query($link, $consulta);
	$row5 = mysqli_fetch_array($rs5);
	
	$TotalDifEntPeso = $TotalDifEntPeso + $row5["peso"];
	$TotalDifEntAg = $TotalDifEntAg + $row5[fino_ag];
	$TotalDifEntAu = $TotalDifEntAu + $row5[fino_au];	
	
	$consulta = "SELECT IFNULL(SUM(t2.peso),0) AS peso, IFNULL(SUM(t2.fino_ag),0) AS fino_ag, IFNULL(SUM(t2.fino_au),0) AS fino_au";
	$consulta.= " FROM proyecto_modernizacion.flujos AS t1";
	$consulta.= " LEFT JOIN pmn_web.flujos_mes AS t2";
	$consulta.= " ON t1.cod_flujo = t2.flujo AND ano = '".$Ano."' AND mes = '".$Mes."' AND t1.sistema = 'PMN'";
	$consulta.= " WHERE t1.nodo = '".$Nodo."' AND (t1.esflujo != 'N' OR ISNULL(t1.esflujo)) AND t1.tipo = 'S'";	
	//echo $consulta."<br>";
	$rs5 = mysqli_query($link, $consulta);
	$row5 = mysqli_fetch_array($rs5);

	$TotalDifSalPeso = $TotalDifSalPeso + $row5["peso"];
	$TotalDifSalAg = $TotalDifSalAg + $row5[fino_ag];
	$TotalDifSalAu = $TotalDifSalAu  + $row5[fino_au];			
?>  
  
  <table width="720" border="1" align="center" cellpadding="3" cellspacing="0">
    <tr class="Detalle02"> 
      <td width="367">DIFERENCIA METALURGICA</td>
      <td width="78" align="right"><?php echo number_format(($TotalDifEntPeso - $TotalDifSalPeso),3,",",".")?></td>
      <td width="112">&nbsp;</td>
      <td width="64" align="right"><?php echo number_format((round($TotalDifEntAg,3) - round($TotalDifSalAg,3)),3,",",".")?></td>
      <td width="57" align="right"><?php echo number_format((round($TotalDifEntAu,3) - round($TotalDifSalAu,3)),3,",",".")?></td>
    </tr>
  </table><br><br>
</form>
</html>
