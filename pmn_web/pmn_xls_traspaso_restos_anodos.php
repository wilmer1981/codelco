<?php ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);
header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link>
</head>
<body>
<form action="" method="post" name="frmPrincipal">
  <table width="711" border="0" cellspacing="0" cellpadding="3">
	<tr> 
      <td width="406" align="center" valign="middle" colspan="11"><strong>TRASPASO RESTOS DE 
        ANODOS</strong></td>
      <td width="84" align="center" valign="middle"><input name="BtnExcel" type="submit" style="width:70px" id="BtnExcel" value="Excel" onClick="Proceso('E','<?php echo $FechaIni; ?>','<?php echo $FechaFin  ?>','<?php echo $Turno; ?>');"></td>
      <td width="82" align="center" valign="middle"><input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir"></td>
      <td width="115" align="center" valign="middle"> <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="882" border="1" cellspacing="0" cellpadding="3" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="35">FECHA</td>
      <td width="39">TURNO</td>
      <td width="76">STOCK INICIAL</td>
      <td width="74">N&deg; ELECT.</td>
      <td width="58">M</td>
      <td width="71">CANTIDAD OREJAS</td>
      <td width="63">PESO RESTOS</td>
      <td width="75">HORNADA</td>
      <td width="75">BENEFICIO <br>
        R. M.DORE</td>
      <td width="73">STOCK FINAL</td>
      <td width="75">JEFE DE <br>
        TURNO</td>
      <td width="70">OP E AG</td>
    </tr>
    <?php 
	$vector = array(); //0:fecha, 1:cod_turno, 2:nom_turno.	
	
	$consulta = "SELECT t1.fecha,t1.turno,t2.nombre_subclase,";
	$consulta.= " CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";	
	$consulta.= " FROM pmn_web.descarga_electrolisis_plata AS t1";	
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND t2.cod_clase = '1'";	
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " GROUP BY t1.fecha,t1.turno";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$vector[$row[clave]][0] = $row["fecha"];
		$vector[$row[clave]][1] = $row[turno];
		$vector[$row[clave]][2] = $row["nombre_subclase"];
	}
	
	$consulta = "SELECT t1.fecha,t1.turno,t2.nombre_subclase,";
	$consulta.= " CONCAT(fecha,'-',CASE WHEN t2.nombre_subclase = 'C' THEN 'D' ELSE CASE WHEN t2.nombre_subclase = 'A' THEN 'E' ELSE 'F' END END) AS clave";	
	$consulta.= " FROM pmn_web.carga_horno_trof AS t1";
	$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.turno = t2.cod_subclase AND t2.cod_clase = '1'";	
	$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " AND t1.cod_producto = '19' AND t1.cod_subproducto = '17'";
	$consulta.= " GROUP BY t1.fecha,t1.turno";	
	//echo $consulta."<br>";	
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		$vector[$row[clave]][0] = $row["fecha"];
		$vector[$row[clave]][1] = $row[turno];
		$vector[$row[clave]][2] = $row["nombre_subclase"];
	}	
	
	
	ksort($vector);		

	$FechaAnt = "";
	$Cont=0;
	reset($vector);
	while (list($c, $v) = each($vector))
	{
		echo "<tr>";
		echo "<td align='left'>".substr($v[0],8,2)."/".substr($v[0],5,2)."/".substr($v[0],0,4)."</td>\n";
		echo "<td align='center'>".$v[2]."</td>";
		
		$StockInicial = 0;
		$StockFinal = 0;
		
		//Consulta para rescatar la fecha minima de la tabla.
		$consulta = "SELECT MIN(fecha) AS fecha FROM pmn_web.descarga_electrolisis_plata";
		$rs3 = mysqli_query($link, $consulta);
		$row3 = mysqli_fetch_array($rs3);
		$FechaMin = $row3["fecha"];
		
		$consulta ="SELECT SUBDATE('".$v[0]."', INTERVAL 1 DAY) AS fecha";
		$rs4 = mysqli_query($link, $consulta);
		$row4 = mysqli_fetch_array($rs4);
		$FechaMax = $row4["fecha"];
				
		//Produccion.
		$consulta = "SELECT IFNULL(SUM(peso_resto),0) AS peso FROM pmn_web.descarga_electrolisis_plata";
		$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
		//echo $consulta."<br>";		
		$rs5 = mysqli_query($link, $consulta);
		$row5 = mysqli_fetch_array($rs5);
		$StockInicial = $row5["peso"];
		
		//Carga.
		$consulta = "SELECT IFNULL(SUM(cantidad),0) AS peso FROM pmn_web.carga_horno_trof";
		$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";		
		$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
		//echo $consulta."<br>";
		$rs6 = mysqli_query($link, $consulta);
		$row6 = mysqli_fetch_array($rs6);
		$StockInicial = $StockInicial - $row6["peso"];
		
		//Ajuste.
		$consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM pmn_web.ajuste_stock";
		$consulta.= " WHERE fecha BETWEEN '".$FechaMin."' AND '".$FechaMax."'";
		$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";		
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$StockInicial = $StockInicial - $row["peso"];		
		
		switch ($v[1])
		{
			//Turno A.
			case '1':
					//Produccion.
					$consulta = "SELECT IFNULL(SUM(peso_resto),0) AS peso FROM pmn_web.descarga_electrolisis_plata";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '3'";
					$rs7 = mysqli_query($link, $consulta);
					$row7 = mysqli_fetch_array($rs7);
					$StockInicial = $StockInicial + $row7["peso"];
					
					$consulta = "SELECT IFNULL(SUM(cantidad),0) AS peso FROM pmn_web.carga_horno_trof";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '3'";		
					$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
					$rs8 = mysqli_query($link, $consulta);
					$row8 = mysqli_fetch_array($rs8);
					$StockInicial = $StockInicial - $row8["peso"];
										
					break;
			//Turno B.					
			case '2':			
					//Produccion.
					$consulta = "SELECT IFNULL(SUM(peso_resto),0) AS peso FROM pmn_web.descarga_electrolisis_plata";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno IN ('1','3')";
					$rs7 = mysqli_query($link, $consulta);
					$row7 = mysqli_fetch_array($rs7);
					$StockInicial = $StockInicial + $row7["peso"];
					
					$consulta = "SELECT IFNULL(SUM(cantidad),0) AS peso FROM pmn_web.carga_horno_trof";
					$consulta.= " WHERE fecha = '".$v[0]."' AND turno IN ('1','3')";		
					$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
					$rs8 = mysqli_query($link, $consulta);
					$row8 = mysqli_fetch_array($rs8);
					$StockInicial = $StockInicial - $row8["peso"];			
					break;
			//Turno C.					
			case '3':
					break;
		}
		
		//StockInicial.
		echo "<td align='right'>".number_format($StockInicial,2,",","")."</td>";			
		$StockFinal = $StockInicial;
			
		$consulta = "SELECT * FROM pmn_web.descarga_electrolisis_plata";
		$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '".$v[1]."'";
		//echo $consulta."<br>";
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
		{
			echo "<td align='center'>".$row1[num_electrolisis]."</td>";
			echo "<td align='center'>".$row1["grupo"]."</td>";
			echo "<td align='center'>".$row1[cant_orejas]."</td>";		
			echo "<td align='right'>".number_format($row1[peso_resto],2,",","")."</td>";			
			
			$StockFinal = $StockFinal + $row1[peso_resto];			
		}
		else
		{	
			echo "<td></td>";			
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";									
		}		
		
		//Resto Metal Dore.
		$consulta = "SELECT hornada, IFNULL(SUM(cantidad),0) AS cant FROM pmn_web.carga_horno_trof";
		$consulta.= " WHERE fecha = '".$v[0]."' AND turno = '".$v[1]."'";
		$consulta.= " AND cod_producto = '19' AND cod_subproducto = '17'";
		$consulta.= " GROUP BY hornada";
		//echo $consulta."<br>";
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);
		$StockFinal = $StockFinal - $row2["cant"];
		echo "<td align='center'>".$row2[hornada]."</td>";		
		echo "<td align='right'>".number_format($row2["cant"],4,",","")."</td>";
				
		//StockFinal.
		echo "<td align='right'>".number_format($StockFinal,2,",","")."</td>";
				
		//Operador.
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '".$row1[jefe_turno]."'";		
		$rs9 = mysqli_query($link, $consulta);
		if ($row9 = mysqli_fetch_array($rs9))
			echo "<td>".strtoupper(substr($row9["nombres"],0,1)).". ".ucwords(strtolower($row9["apellido_paterno"]))."</td>";						
		else
			echo "<td>&nbsp;</td>";		
		
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '".$row1[operador]."'";		
		$rs10 = mysqli_query($link, $consulta);
		if ($row10 = mysqli_fetch_array($rs10))
			echo "<td>".strtoupper(substr($row10["nombres"],0,1)).". ".ucwords(strtolower($row10["apellido_paterno"]))."</td>";
		else
			echo "<td></td>";		
						
		echo "</tr>";
	}	
?>
  </table>
</form>
</body>
</html>