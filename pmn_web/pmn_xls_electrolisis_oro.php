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
      
    <td width="477" align="center" valign="middle" colspan="10"><strong>ELECTROLISIS DE ORO</strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>

<br>
  <table width="913" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="76" rowspan="2" align="center">FECHA</td>
      <td width="43" rowspan="2" align="center">N&ordm; ELECT.</td>
      <td width="80" rowspan="2" align="center">CORRELATIVO</td>
      <td colspan="2" align="center" class="ColorTabla01">ANODOS</td>
      <td width="45" rowspan="2" align="center">RESTO</td>
      <td width="59" rowspan="2" align="center">CATODOS SECO</td>
      <td width="74" rowspan="2" align="center">CLORURO AURICO</td>
      <td colspan="4" align="center">ANALISIS QUIMICO</td>
      <td width="107" rowspan="2" align="center">OPERADOR</td>
      <td width="127" rowspan="2" align="center">EVPF</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="33" align="center">CANT.</td>
      <td width="41" align="center">PESO</td>
      <td width="32" align="center">Cu ppm</td>
      <td width="31" align="center">Ag ppm</td>
      <td width="24" align="center">Fe ppm</td>
      <td width="26" align="center">Pd ppm</td>
    </tr>
  
<?php
  	$consulta = "SELECT fecha,num_electrolisis,correlativo,SUM(cant_anodos) AS cant_anodos, SUM(peso_anodos) AS peso_anodos,";
	$consulta.= " SUM(cloruro_aurico) AS cloruro_aurico, SUM(catodos_seco) AS catodos_seco, SUM(peso_resto) AS peso_resto,operador,jefe_turno";
	$consulta.= " FROM pmn_web.carga_electrolisis_oro";
	$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " GROUP BY fecha, num_electrolisis";
	$consulta.= " ORDER BY num_electrolisis";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{	
		echo '<tr>';
		echo '<td>'.substr($row["fecha"],8,2).'-'.substr($row["fecha"],5,2).'-'.substr($row["fecha"],0,4).'</td>';
		echo '<td>'.$row[num_electrolisis].'</td>';
		echo '<td>'.$row[correlativo].'</td>';
		echo '<td>'.$row[cant_anodos].'</td>';
		echo '<td  align="right">'.number_format($row[peso_anodos],4,",","").'</td>';
		echo '<td  align="right">'.number_format($row[peso_resto],4,",","").'</td>';
		echo '<td  align="right">'.number_format($row[catodos_seco],4,",","").'</td>';
		echo '<td  align="right">'.number_format($row[cloruro_aurico],4,",","").'</td>';
		
		//LEYES.
		$leyes = array('02'=>'', '04'=>'', '31'=>'', '38'=>''); //Cu-Ag-Fe-Pd.
		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra";
		$consulta.= " WHERE  t1.cod_producto = '34' AND t1.cod_subproducto = '2'";
		$consulta.= " AND t1.id_muestra = '".$row[num_electrolisis]."' AND t1.cod_periodo = '1' AND t1.agrupacion = '5'";		
		$consulta.= " AND t2.cod_leyes IN ('02', '04', '31', '38')";
		$rs3 = mysqli_query($link, $consulta);
		while ($row3 = mysqli_fetch_array($rs3))
		{
			$leyes[$row3["cod_leyes"]] = $row3["valor"];
		}
		
		reset($leyes);
		while (list($c,$v) = each($leyes))
		{
			echo '<td align="right">'.number_format($v,2,",","").'</td>';		
		}				
		
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios";
		$consulta.= " WHERE rut = '".$row[operador]."'";
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);		
		echo '<td>'.strtoupper(substr($row1["nombres"],0,1)).". ".ucwords(strtolower($row1["apellido_paterno"])).'</td>';
		
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios";
		$consulta.= " WHERE rut = '".$row[jefe_turno]."'";				
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);
				
		echo '<td>'.strtoupper(substr($row2["nombres"],0,1)).". ".ucwords(strtolower($row2["apellido_paterno"])).'</td>';
		echo '</tr>';
	}
?>
</table>
</form>
</body>
</html>