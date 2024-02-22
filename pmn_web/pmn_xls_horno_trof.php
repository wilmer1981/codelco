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
	f.action="pmn_xls_electrolisis_plata.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      
	  <td width="477" align="center" valign="middle" colspan="10"><strong>HORNO TROF</strong></td>
	</tr>
  </table>
   <table width="691" border="1" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="427" align="center" valign="middle" colspan="2">Fecha Inicio:</td>
      <td width="427" align="center" valign="middle" colspan="3"><?php echo $FechaIni;?></td>
      <td width="427" align="center" valign="middle" colspan="2">Fecha Termino:</td>
      <td width="427" align="center" valign="middle" colspan="3"><?php echo $FechaFin;?></td>
    </tr>
  </table>  	
<br>
<table width="1000" border="1" cellpadding="3" cellspacing="0" class="TituloCabeceraAzul">
  <tr class="ColorTabla01">
    <td width="55" rowspan="2" align="center">HORNADA</td>
    <td width="200" rowspan="2" align="center">FECHA</td>
    <td width="51" rowspan="2" align="center">CONSUMO GAS</td>
    <td width="51" rowspan="2" align="center">CALCINA</td>
    <td width="51" rowspan="2" align="center">RESTOS</td>
    <td colspan="3" align="center">METAL DORE</td>
    <td width="51" rowspan="2" align="center">PLATA</td>
    <td width="51" rowspan="2" align="center">OTROS PROD.PMN</td>
    <td colspan="2" align="center">PRODUCCION</td>
    <td colspan="3" align="center">ANALISIS OP.</td>
    <td colspan="8" align="center">ANALISIS FINAL</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="51" align="center">FLORIDA</td>
    <td width="50" align="center">CAN-CAN</td>
    <td width="50" align="center">ORO COMPRA</td>
    <td width="47" align="center">ANODOS</td>
    <td width="49" align="center">PESO</td>
    <td width="31" align="center">Cu</td>
    <td width="29" align="center">Se</td>
    <td width="33" align="center">Te</td>
    <td width="30" align="center">Cu</td>
    <td width="33" align="center">Ag</td>
    <td width="29" align="center">Au</td>
    <td width="32" align="center">Pt</td>
    <td width="37" align="center">Pd</td>
    <td width="32" align="center">Se</td>
    <td width="40" align="center">Te</td>
    <td width="40" align="center">Bi</td>
  </tr>
  <?php
	$consultaP= " SELECT DISTINCT hornada, fecha";
	$consultaP.= " FROM pmn_web.carga_horno_trof";
	$consultaP.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consultaP.= " group by hornada ORDER BY fecha";
	//echo $consulta."<br>";
	$rsP = mysqli_query($link, $consultaP);
	while ($rowP = mysqli_fetch_array($rsP))
	{
		$consultacOUNT= " SELECT DISTINCT hornada, fecha";
		$consultacOUNT.= " FROM pmn_web.carga_horno_trof";
		$consultacOUNT.= " WHERE hornada='".$rowP[hornada]."' AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consultacOUNT.= " ORDER BY fecha";
		$rscOUNT = mysqli_query($link, $consultacOUNT);$rOWS=0;
		while ($rowcOUNT = mysqli_fetch_array($rscOUNT))
				$rOWS=$rOWS+1;
		echo '<tr>';
		echo '<td rowspan="'.$rOWS.'">'.$rowP[hornada].'&nbsp;</td>';
		$consulta= " SELECT DISTINCT hornada, fecha";
		$consulta.= " FROM pmn_web.carga_horno_trof";
		$consulta.= " WHERE hornada='".$rowP[hornada]."' AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " ORDER BY fecha";
		$rs = mysqli_query($link, $consulta);$Vuelas=1;
		while ($row = mysqli_fetch_array($rs))
		{
			echo '<td>'.substr($row["fecha"],8,2).'-'.substr($row["fecha"],5,2).'-'.substr($row["fecha"],0,4).'</td>';
			
			//CONSUMO GAS.
			$consulta = "SELECT (gas_natural_fin - gas_natural_ini) AS consumo";
			$consulta.= " FROM pmn_web.produccion_horno_trof";
			$consulta.= " WHERE hornada = '".$row[hornada]."'";		
			$rs8 = mysqli_query($link, $consulta);
			$row8 = mysqli_fetch_array($rs8);
			echo '<td align="right">'.number_format($row8[consumo],2,",","").'</td>';		
			
			//CALCINA.
			$consulta = "SELECT IFNULL(SUM(cantidad),0) AS calcina FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE fecha = '".$row["fecha"]."' AND cod_producto = '36' AND cod_subproducto = '1'";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			
			echo '<td align="right">'.number_format($row1[calcina],2,",","").'</td>';
			
			//RESTOS
			$consulta = "SELECT IFNULL(SUM(cantidad),0) AS restos FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE fecha = '".$row["fecha"]."' AND cod_producto = '19'";
			$rs4 = mysqli_query($link, $consulta);
			$row4 = mysqli_fetch_array($rs4);
			
			echo '<td align="right">'.number_format($row4[restos],3,",","").'</td>';	
			
			//METAL DORE FLORIDA.
			$consulta = "SELECT IFNULL(SUM(cantidad),0) AS metal_florida FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE fecha = '".$row["fecha"]."' AND cod_producto = '44' AND cod_subproducto = '3'";		
			$rs5 = mysqli_query($link, $consulta);
			$row5 = mysqli_fetch_array($rs5);
	
			echo '<td align="right">'.number_format($row5[metal_florida],3,",","").'</td>';
			
			//METAL DORE CAN-CAN.
			$consulta = "SELECT IFNULL(SUM(cantidad),0) AS metal_cancan FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE fecha = '".$row["fecha"]."' AND cod_producto = '44' AND cod_subproducto = '2'";		
			$rs6 = mysqli_query($link, $consulta);
			$row6 = mysqli_fetch_array($rs6);
					
			echo '<td align="right">'.number_format($row6[metal_cancan],3,",","").'</td>';
			
			//ORO COMPRA.
			$consulta = "SELECT IFNULL(SUM(cantidad),0) AS oro_compra FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE fecha = '".$row["fecha"]."' AND cod_producto = '34' AND cod_subproducto = '3'";		
			$rs6 = mysqli_query($link, $consulta);
			$row6 = mysqli_fetch_array($rs6);		
			echo '<td align="right">'.number_format($row6[oro_compra],3,",","").'</td>';		
			//peso plata
			$consulta = "SELECT ifnull(sum(cantidad),0) as plata FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE  fecha = '".$row["fecha"]."' and cod_producto = '30'";
			$consulta.= " and cod_subproducto in('1','2')";
			$rsp = mysqli_query($link, $consulta);
			$rspp=mysqli_fetch_array($rsp);
			echo '<td align="right">'.number_format($rspp[plata],3,",","").'</td>';
			//peso otros pmn
			$consulta = "SELECT ifnull(sum(cantidad),0) as pmn FROM pmn_web.carga_horno_trof";
			$consulta.= " WHERE  fecha = '".$row["fecha"]."' and cod_producto = '39'";
			$consulta.= " and cod_subproducto in('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','22')";
			$rsp1 = mysqli_query($link, $consulta);
			$rspp1=mysqli_fetch_array($rsp1);
			echo '<td align="right">'.number_format($rspp1[pmn],3,",","").'</td>';
			//PRODUCCION.
			$consulta = "SELECT IFNULL(SUM(num_anodos),0) AS anodos, IFNULL(SUM(peso),0) AS peso";
			$consulta.= " FROM pmn_web.produccion_horno_trof";
			$consulta.= " WHERE hornada = '".$row[hornada]."'";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			if($Vuelas==1)
			{
				echo '<td align="right" rowspan="'.$rOWS.'">'.$row2[anodos].'</td>';
				echo '<td align="right" rowspan="'.$rOWS.'">'.number_format($row2["peso"],3,",","").'</td>';		
			}
			
			//ANALISIS OP.
			$leyes_op = array('02'=>'', '40'=>'', '44'=>'');
			$consulta = "SELECT * FROM pmn_web.leyes_prod_horno_trof";
			$consulta.= " WHERE hornada = '".$row[hornada]."'";
			$consulta.= "ORDER BY cod_leyes";
			$rs3 = mysqli_query($link, $consulta);
			while ($row3 = mysqli_fetch_array($rs3))
			{
				$leyes_op[$row3["cod_leyes"]] = $row3[muestra01];
			}
			
			if($Vuelas==1)
			{
				reset($leyes_op);
				while (list($c,$v) = each($leyes_op))
				{
					echo '<td align="right" rowspan="'.$rOWS.'">'.number_format($v,2,",","").'</td>';		
				}
			}			
			//ANALISIS FINAL.
			$leyes_an = array('02'=>'', '04'=>'', '05'=>'','37'=>'', '38'=>'', '40'=>'', '44'=>'', '27'=>''); //Cu-Ag-Au-Pt-Pd-Se-Te.
			$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
			$consulta.= " FROM cal_web.solicitud_analisis AS t1";
			$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
			$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
			$consulta.= " AND t1.id_muestra = t2.id_muestra";
			$consulta.= " WHERE  t1.cod_producto = '44' AND t1.cod_subproducto = '1'";
			$consulta.= " AND t1.id_muestra = '".$row[hornada]."' AND t1.cod_periodo = '1'";
			//echo $consulta."<br>";
			$rs7 = mysqli_query($link, $consulta);
			while ($row7 = mysqli_fetch_array($rs7))
			{
				$leyes_an[$row7["cod_leyes"]] = $row7["valor"];
			}
			
			if($Vuelas==1)
			{
				reset($leyes_an)		;
				while (list($c,$v) = each($leyes_an))
				{	
					if ($v == 'ND')
						echo '<td align="right" rowspan="'.$rOWS.'">'.$v.'</td>';
					else
						echo '<td align="right" rowspan="'.$rOWS.'">'.number_format($v,2,",","").'</td>';		
				}
			}			
			echo '</tr>';
			$Vuelas++;
		}
	}
?>
</table>
</form>
</body>
</html>