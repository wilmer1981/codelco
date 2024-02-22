<?php	ob_end_clean();
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
<title>Documento sin t&iacute;tulo</title>
<?php
	//<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
?>

</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      
      <td width="477" align="center" valign="middle" colspan="20"><strong>LIXIVIACION BARRO 
        AURIFERO </strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>

<br>
  <table width="1200" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="72" rowspan="3" align="center">Num. Electrolisis</td>
      <td width="61" rowspan="3" align="center">Correlativo</td>
      <td width="73" rowspan="3" align="center">FECHA CARGA</td>
      <td colspan="9" align="center">CARGA REACTOR</td>
      <td colspan="8" align="center">DESCARGA REACTOR</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="65" rowspan="2" align="center">PESO BauC kg h</td>
      <td width="57" rowspan="2" align="center">Humedad</td>
      <td colspan="7" align="center">LEYES (%)</td>
      <td width="74" rowspan="2" align="center">PESO BauL kg s</td>
      <td colspan="7" align="center">LEYES (%)</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="43" align="center">Cu</td>
      <td width="41" align="center">Ag</td>
      <td width="47" align="center">Au</td>
      <td width="42" align="center">Pt</td>
      <td width="47" align="center">Pd</td>
      <td width="45" align="center">Se</td>
      <td width="51" align="center">Te</td>
      <td width="48" align="center">Cu</td>
      <td width="47" align="center">Ag</td>
      <td width="50" align="center">Au</td>
      <td width="45" align="center">Pt</td>
      <td width="47" align="center">Pd</td>
      <td width="43" align="center">Se</td>
      <td width="39" align="center">Te</td>
    </tr>
    <?php	
	$consulta = "SELECT * FROM pmn_web.carga_lixiviacion_barro_aurifero";
	$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " ORDER BY correlativo";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
		echo '<tr>';
		echo '<td align="center">'.$row[num_electrolisis].'</td>';
		echo '<td align="center">'.$row[correlativo].'</td>';
		echo '<td align="center">'.substr($row["fecha"],8,2).'-'.substr($row["fecha"],5,2).'-'.substr($row["fecha"],0,4).'</td>';
		echo '<td align="center">'.number_format($row["peso"],2,",","").'</td>';
		
		//---.
		//SE PONDERA LA HUMEDAD, SEGUN LAS 2 N DE ELECTROLISIS.
		$humedad = 0;
		$vector = explode('-',$row[num_electrolisis]);		
		while (list($c,$v) = each($vector))
		{
			$consulta = "SELECT IFNULL((peso_aurifero * humedad),0) AS valor";
			$consulta.= " FROM pmn_web.descarga_electrolisis_plata";
			$consulta.= " WHERE num_electrolisis = '".$v."'";
			//echo $consulta."<br>";
			$rs4 = mysqli_query($link, $consulta);
			$row4 = mysqli_fetch_array($rs4);
			$humedad = $humedad + $row4["valor"];
		}
		echo '<td align="center">'.number_format(($humedad / $row["peso"]),2,",","").'</td>';
		//---.
		
		//LEYES.
		$leyes_carga = array('02'=>'', '04'=>'', '05'=>'', '37'=>'', '38'=>'', '40'=>'', '44'=>''); //Cu-Ag-Au-Pt-Pd-Se-Te.	

		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra";
		$consulta.= " WHERE  t1.cod_producto = '26' AND t1.cod_subproducto = '1'";
		$consulta.= " AND t1.id_muestra = '".$row[num_electrolisis]."' AND t1.cod_periodo = '1' AND t1.agrupacion = '5'";		
		$consulta.= " AND t2.cod_leyes IN ('02', '04', '05', '37', '38', '40', '44')";
		//echo $consulta."<br>";
		
		$rs1 = mysqli_query($link, $consulta);
		while ($row1 = mysqli_fetch_array($rs1)) 
		{
			$leyes_carga[$row1["cod_leyes"]] = $row1["valor"];
		}
		
		reset($leyes_carga);
		while (list($c,$v) = each($leyes_carga))
		{	
			if ($v == 'ND')
				echo '<td align="center">'.$v.'</td>';
			else
				echo '<td align="center">'.number_format($v,3,",","").'</td>';			
		}
				
			
		$consulta = "SELECT * FROM pmn_web.descarga_lixiviacion_barro_aurifero";
		$consulta.= " WHERE num_electrolisis = '".$row[num_electrolisis]."'";
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);
		echo '<td align="center">'.number_format($row2[peso_seco],3,",","").'</td>';

		
		//LEYES.
		$leyes_descarga = array('02'=>'', '04'=>'', '05'=>'', '37'=>'', '38'=>'', '40'=>'', '44'=>''); //Cu-Ag-Au-Pt-Pd-Se-Te.		
	
		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra";
		$consulta.= " WHERE  t1.cod_producto = '26' AND t1.cod_subproducto = '2'";
		$consulta.= " AND t1.id_muestra = '".$row[num_electrolisis]."' AND t1.cod_periodo = '1' AND t1.agrupacion = '5'";		
		$consulta.= " AND t2.cod_leyes IN ('02', '04', '05', '37', '38', '40', '44')";
		//echo $consulta."<br>";
		
		$rs3 = mysqli_query($link, $consulta);
		while ($row3 = mysqli_fetch_array($rs3)) 
		{
			$leyes_descarga[$row3["cod_leyes"]] = $row3["valor"];
		}				
		
		reset($leyes_descarga);
		while (list($c,$v) = each($leyes_descarga))
		{	
			if ($v == 'ND')
				echo '<td align="center">'.$v.'</td>';
			else
				echo '<td align="center">'.number_format($v,3,",","").'</td>';			
		}		

		echo '</tr>';
	}
?>
  </table>
</form>
</body>
</html>
