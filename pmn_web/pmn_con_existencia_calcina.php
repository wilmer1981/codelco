<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frm1;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frm1;
	f.action="pmn_xls_existencia_calcina.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php
 	$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
	$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
?>
<table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      
    <td width="477" align="center" valign="middle"><strong class="titulo_azul">EXISTENCIA DE 
        CALCINA</strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>
  <br>
  <table width="800" border="1" cellspacing="0" cellpadding="0" class="TituloCabeceraAzul">
    <tr class="ColorTabla01">
      <td align="center">FECHA</td>
      <td align="center">TURNO</td>
      <td align="center">STOCK<br>
        INICIAL</td>
      <td align="center">HORNADA N&ordm;<br>
        PLASEL</td>
      <td align="center">PRODUCCION<br>
        KG</td>
      <td align="center">HORNADA N&ordm;<br>
        H TROF</td>
      <td align="center">CONSUMO<br>
        KG</td>
      <td align="center">AJUSTE<br>
        KG</td>
      <td align="center">STOCK <br>
        FINAL</td>
    </tr>
<?php
	$vector = array(); //0:fecha, 1:cod_turno, 2:nom_turno, 3:filas.
	
	//Planta Selenio.
	$consulta = "SELECT fecha,turno,nombre_subclase, COUNT(*) AS filas,";
	$consulta.= " CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";
	$consulta.= " FROM pmn_web.deselenizacion AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND cod_clase ='1'";			
	$consulta.= " WHERE fecha between '".$FechaIni."' and '".$FechaFin."'";
	$consulta.= " GROUP BY fecha,turno";
	$consulta.= " HAVING sum(prod_calcina) > 0";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$vector[$row[clave]][0] = $row["fecha"];
		$vector[$row[clave]][1] = $row[turno];
		$vector[$row[clave]][2] = $row["nombre_subclase"];
		$vector[$row[clave]][3]	= $row[filas];
	}	


	//Horno Trof.
	$consulta = "SELECT fecha,turno,nombre_subclase, COUNT(*) AS filas,";
	$consulta.= " CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave ";	
	$consulta.= " FROM pmn_web.carga_horno_trof AS t1";	
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";	
	$consulta.= " ON t1.turno = t2.cod_subclase AND cod_clase ='1'";			
	$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";
	$consulta.= " GROUP BY fecha,turno";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		if ($vector[$row[clave]][3] < $row[filas])	
		{
			$vector[$row[clave]][0] = $row["fecha"];
			$vector[$row[clave]][1] = $row[turno];
			$vector[$row[clave]][2] = $row["nombre_subclase"];
			$vector[$row[clave]][3]	= $row[filas];
		}
	}	

	//Ajuste.
	$consulta = "SELECT fecha, cod_turno, nombre_subclase, '1' AS filas, CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";
	$consulta.= " FROM pmn_web.ajuste_stock AS t1";	
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.cod_turno = t2.cod_subclase AND cod_clase = '1'";
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " AND t1.cod_producto = '36' AND t1.cod_subproducto = '1'";
	$consulta.= " GROUP BY fecha,cod_turno";
	$consulta.= " ORDER BY t1.fecha,valor_subclase1";		
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
		if ($vector[$row[clave]][3] < $row[filas])
		{
			$vector[$row[clave]][0] = $row["fecha"];
			$vector[$row[clave]][1] = $row[cod_turno];
			$vector[$row[clave]][2] = $row["nombre_subclase"];
			$vector[$row[clave]][3]	= $row[filas];
		}
	}	

	ksort($vector);		

	$Cont_Selenio = 0;
	reset($vector);
	while (list($c, $v) = each($vector))
	{	
		$sw = true;
		for ($i=1; $i <= $v[3]; $i++)
		{
			echo '<tr>';
			
			if ($sw == true)				
			{
				//Stock Inicial.
				$StockInicial = 0;
				$StockFinal = 0;
				
				//Consulta para rescatar la fecha minima de la tabla.
				$consulta ="select min(fecha) as fecha from pmn_web.deselenizacion";
				$rs5 = mysqli_query($link, $consulta);
				$row5 = mysqli_fetch_array($rs5);
				$FechaMin = $row5["fecha"];
				
				$consulta ="select subdate('".$v[0]."',interval 1 day) as fecha";
				$rs6 = mysqli_query($link, $consulta);
				$row6 = mysqli_fetch_array($rs6);
				$FechaMax = $row6["fecha"];
				
				//Produccion.
				$consulta = "SELECT IFNULL(SUM(prod_calcina),0) AS calcina FROM pmn_web.deselenizacion";
				$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
				//echo $consulta."<br>";
				$rs7 = mysqli_query($link, $consulta);
				$row7 = mysqli_fetch_array($rs7);				
				$StockInicial = $row7[calcina];
				
				//Carga.
				$consulta = "SELECT IFNULL(SUM(cantidad),0) AS cantidad FROM pmn_web.carga_horno_trof";
				$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
				$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";
				//echo $consulta."<br>";
				$rs8 = mysqli_query($link, $consulta);
				$row8 = mysqli_fetch_array($rs8);
				$StockInicial = $StockInicial - $row8[cantidad];
				
				//Ajuste.
				$consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM pmn_web.ajuste_stock";
				$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
				$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";
				//echo $consulta."<br>";
				$rs9 = mysqli_query($link, $consulta);
				$row9 = mysqli_fetch_array($rs9);
				$StockInicial = $StockInicial - $row9["peso"];				
				
				switch ($v[1])
				{
					//Turno A.
					case '1':
						$consulta = "SELECT IFNULL(SUM(prod_calcina),0) AS calcina FROM pmn_web.deselenizacion";
						$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '3'";
						//echo $consulta."<br>";
						$rs10 = mysqli_query($link, $consulta);
						$row10 = mysqli_fetch_array($rs10);					
						$StockInicial = $StockInicial + $row10[calcina];
				
						$consulta = "SELECT IFNULL(SUM(cantidad),0) AS cantidad FROM pmn_web.carga_horno_trof";
						$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '3'";
						$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";						
						//echo $consulta."<br>";
						$rs11 = mysqli_query($link, $consulta);
						$row11 = mysqli_fetch_array($rs11);
						$StockInicial = $StockInicial - $row11[cantidad];
						
						$consulta = "SELECT IFNULL(SUM(CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END),0) AS valor";
						$consulta.= " FROM pmn_web.ajuste_stock";
						$consulta.= " WHERE fecha = '".$v[0]."' AND cod_turno = '3'";
						$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";
						//echo $consulta."<br>";
						$rs12 = mysqli_query($link, $consulta);
						$row12 = mysqli_fetch_array($rs12);
						$StockInicial = $StockInicial + $row12["valor"];
						break;
					case '2':
						$consulta = "SELECT IFNULL(SUM(prod_calcina),0) AS calcina FROM pmn_web.deselenizacion";
						$consulta.= " WHERE fecha = '".$v[0]."' AND turno IN ('1','3')";
						//echo $consulta."<br>";
						$rs10 = mysqli_query($link, $consulta);
						$row10 = mysqli_fetch_array($rs10);					
						$StockInicial = $StockInicial + $row10[calcina];
				
						$consulta = "SELECT IFNULL(SUM(cantidad),0) AS cantidad FROM pmn_web.carga_horno_trof";
						$consulta.= " WHERE fecha = '".$v[0]."' AND turno IN ('1','3')";
						$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";
						//echo $consulta."<br>";
						$rs11 = mysqli_query($link, $consulta);
						$row11 = mysqli_fetch_array($rs11);
						$StockInicial = $StockInicial - $row11[cantidad];
						
						$consulta = "SELECT IFNULL(SUM(CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END),0) AS valor";
						$consulta.= " FROM pmn_web.ajuste_stock";
						$consulta.= " WHERE fecha = '".$v[0]."' AND cod_turno IN ('1','3')";
						$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1'";
						//echo $consulta."<br>";
						$rs12 = mysqli_query($link, $consulta);
						$row12 = mysqli_fetch_array($rs12);
						$StockInicial = $StockInicial + $row12["valor"];					
						break;
					case '3':
						break;
				}

				
				echo '<td rowspan="'.$v[3].'"  height="20" align="center">'.substr($v[0],8,2).'-'.substr($v[0],5,2).'-'.substr($v[0],0,4).'</td>';
				echo '<td rowspan="'.$v[3].'" align="center">'.$v[2].'</td>';
				echo '<td rowspan="'.$v[3].'" align="right">'.number_format($StockInicial,2,",","").'</td>';
				$StockFinal = $StockInicial;
				
				//Planta Selenio.				
				$consulta = "SELECT num_horno, num_funda, hornada_total, hornada_parcial, prod_calcina";
				$consulta.= " FROM pmn_web.deselenizacion";			
				$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '".$v[1]."'";
				//echo $consulta."<br>";
				$rs1 = mysqli_query($link, $consulta);
				$Cont_Selenio = mysql_num_rows($rs1);
			}

			if ($Cont_Selenio > 0)
			{
				mysql_field_seek($rs1,$Cont_Selenio);
				if(!($row1 = mysql_fetch_object($rs1)))
					continue;				

				echo '<td align="center">'.$row1->num_horno.'-'.$row1->num_funda.'-'.$row1->hornada_total.'-'.$row1->hornada_parcial.'</td>';
				echo '<td align="right">'.number_format($row1->prod_calcina,4,",","").'</td>';				
				$Cont_Selenio--;
			}
			else
			{
				echo '<td align="center">&nbsp;</td>';
				echo '<td align="right">0,0000</td>';
			}
			
			if ($sw == true)
			{
				$sw = false;
				
				//P. Selenio.
				$consulta = "SELECT IFNULL(SUM(prod_calcina),0) AS calcina";
				$consulta.= " FROM pmn_web.deselenizacion";			
				$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '".$v[1]."'";
				//echo $consulta."<br>";
				$rs4 = mysqli_query($link, $consulta);
				$row4 = mysqli_fetch_array($rs4);
				$StockFinal = $StockFinal + $row4[calcina];
							
				//Horno Trof.
				$consulta = "SELECT hornada, cantidad";
				$consulta.= " FROM pmn_web.carga_horno_trof";				
				$consulta.= " WHERE fecha = '".$v[0]."'";
				$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1' AND turno = '".$v[1]."'";
				//echo $consulta."<br>";
				$rs2 = mysqli_query($link, $consulta);
				if ($row2 = mysqli_fetch_array($rs2))
				{
					echo '<td rowspan="'.$v[3].'" align="center">'.$row2["hornada"].'</td>';
					echo '<td rowspan="'.$v[3].'" align="right">'.number_format($row2[cantidad],4,",","").'</td>';				
					$StockFinal = $StockFinal - $row2[cantidad];
				}
				else
				{
					echo '<td rowspan="'.$v[3].'" align="center">&nbsp;</td>';
					echo '<td rowspan="'.$v[3].'" align="right">0,0000</td>';				
				}
				
				//Ajuste.
				$consulta = "SELECT tipo, IFNULL(SUM(CASE WHEN tipo='+' THEN peso ELSE (-1 * peso) END),0) AS valor";
				$consulta.= " FROM pmn_web.ajuste_stock";	
				$consulta.= " WHERE fecha = '".$v[0]."'";
				$consulta.= " AND cod_producto = '36' AND cod_subproducto = '1' AND cod_turno = '".$v[1]."'";
				$consulta.= " GROUP BY fecha";
				//echo $consulta."<br>";
				$rs3 = mysqli_query($link, $consulta);
				if ($row3 = mysqli_fetch_array($rs3))
				{
					echo '<td rowspan="'.$v[3].'" align="right">'.$row3[tipo].number_format($row3["valor"],4,",","").'</td>';
					$StockFinal = $StockFinal + $row3["valor"];
				}
				else
					echo '<td rowspan="'.$v[3].'" align="right">0,0000</td>';
					
				//Stock Final.
				echo '<td rowspan="'.$v[3].'" align="right">'.number_format($StockFinal,2,",","").'</td>';
			}
				
			echo '</tr>';		
		}
	}
?>
  </table>
</form>
</body>
</html>