<?php
	ob_end_clean();
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
	
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<?php	
	//<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
?>
<script language="JavaScript">
function Guardar()
{
	var f = document.frmListado;
	
	if (confirm("Esta Seguro De Guardar Los Datos Para Cerrar"))	
	{	
		f.action = "pmn_con_balance_produccion_escoria.php?proceso=G";
		f.submit();
	}
}
/******************/
function Imprimir()
{
	window.print();
}
/**********/
function Salir()
{
	var f = document.frmListado;

	var linea = "recargapag1=S&recargapag2=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value;
	
	document.location = "pmn_con_tipo_movimiento.php?" + linea;
}
</script>
</head>
<?php	
	//<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
?>
<form name="frmListado" action="" method="post">
<?php
	//Campos Ocultos.
	echo '<input name="cmbmovimiento" type="hidden" value="'.$cmbmovimiento.'">';
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	echo '<input name="FechaIni" type="hidden" value="'.$FechaIni.'">';
	echo '<input name="FechaFin" type="hidden" value="'.$FechaFin.'">';
	echo '<input name="ano1" type="hidden" value="'.$ano1.'">';						
	echo '<input name="mes1" type="hidden" value="'.$mes1.'">';
	echo '<input name="TipoCalculo" type="hidden" value="'.$TipoCalculo.'">';								
?>
<br>
<strong>
Informe: Produccion Escoria De Fusion<br>
Periodo: <?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?>
</strong>
<br><br>

<?php
	//Consulta Si el Mes-A�o esta Bloqueado, si esta Bloqueado(1), entonces se rescatan los datos de una tabla ya creada.
	$consulta = "SELECT CASE WHEN COUNT(*) != 0 THEN 'N' ELSE 'S' END AS activar FROM pmn_web.resultado_productos";
	$consulta.= " WHERE YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."' AND bloqueado = 'S'";
	$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov = '".$cmbmovimiento."'";	
	$rs5 = mysqli_query($link, $consulta);
	$row5 = mysqli_fetch_array($rs5);
	$Activar = $row5[activar];
		
	if ($Activar == "S")
	{
		echo '<input name="btnguardar" type="button" id="btnguardar" value="Guardar" style="width:70" onClick="Guardar()">';
		
		$eliminar = "DELETE FROM pmn_web.resultado_productos";
		$eliminar.= " WHERE YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."'";
		$eliminar.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov = '".$cmbmovimiento."'";			
		mysqli_query($link, $eliminar);
	}
?>			


<table width="1000" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01"> 
    <td width="80" rowspan="2" align="center">Fecha</td>
      <td width="86" rowspan="2" align="center">Num. Cajon</td>
      <td width="107" rowspan="2" align="center">Lote</td>
    <td width="105" rowspan="2" align="center">Peso Humedo</td>
    <td width="78" rowspan="2" align="center">H2O (%)</td>
    <td width="98" rowspan="2" align="center">Peso Seco</td>
    <td colspan="6" align="center">
	<?php
	if ($TipoCalculo == "L")	
		echo "Leyes";
	else
		echo "Finos";
	?>
	</td>
  </tr>
  <tr class="ColorTabla01">  
<?php
	if ($TipoCalculo == "L")
	{
?>     
    <td width="68" align="center">Cu (%)</td>
    <td width="72" align="center">Ag (K/T)</td>
    <td width="74" align="center">Au (K/T)</td>
    <td width="71" align="center">As (%)</td>
    <td width="69" align="center">Sb (%)</td>
    <td width="66" align="center">Pb (%)</td>
<?php
	}
	else
	{
?>
    <td width="68" align="center">Cu (Kg)</td>
    <td width="72" align="center">Ag (Kg)</td>
    <td width="74" align="center">Au (Kg)</td>
    <td width="71" align="center">As (Kg)</td>
    <td width="69" align="center">Sb (Kg)</td>
    <td width="66" align="center">Pb (Kg)</td>
<?php
	}
?>		
  </tr>
  <?php
	if ($Activar == "S")
	{   
		//Llena tabla resultado_productos.
		$consulta = "CREATE TABLE IF NOT EXISTS pmn_web.resultado_productos ";
		$consulta.= " (fecha date, tipo_mov char(3), cod_producto varchar(10), cod_subproducto varchar(10),";
		$consulta.= " correlativo int(10), flujo int(3), num_lixiviacion varchar(20), lixiviador varchar(20),";
		$consulta.= " lote varchar(20), tambor varchar(20), id_muestra varchar(20),";
		$consulta.= " peso_humedo double(10,4), humedad double(10,4), peso_seco double(10,4),";
		$consulta.= " bloquedo char(1), conversion int(10), num_caja varchar(20), hornada varchar(20),";
		$consulta.= " num_barra varchar(20), num_electrolisis varchar(20), num_anodos double(10,4),";
		$consulta.= " peso_total double(10,4), peso_muestra double(10,4), cod_leyes char(3), valor double(10,5), fino double(10,5))";

		$consulta.= " SELECT t1.fecha_produccion AS fecha, '".$cmbmovimiento."' AS tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";	
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, t1.id_analisis AS lote, '' AS tambor, '' AS id_muestra,";				
		$consulta.= " t1.peso AS peso_humedo, IFNULL(t5.valor,0) AS humedad, (t1.peso - (t1.peso * IFNULL(t5.valor,0) / 100)) AS peso_seco, 'N' AS bloqueado,";												
		$consulta.= " CASE WHEN t3.cod_leyes IN ('04','05') THEN 1000 ELSE 100 END AS conversion,";
		$consulta.= " t1.numero AS num_cajon, '' AS horanada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";				
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t3.cod_leyes, t3.valor, (t3.valor * (t1.peso - (t1.peso * IFNULL(t5.valor,0) / 100)) / CASE WHEN t3.cod_leyes IN ('04','05') THEN 1000 ELSE 100 END) AS fino";				
			
		$consulta.= " FROM pmn_web.produccion_subproductos AS t1";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON t1.id_analisis = t2.id_muestra";	
		$consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
		$consulta.= " AND t2.cod_periodo = '1' AND t2.recargo = '0'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.cod_producto = t3.cod_producto AND t2.cod_subproducto = t3.cod_subproducto";
		$consulta.= " AND t2.nro_solicitud = t3.nro_solicitud AND t2.id_muestra = t3.id_muestra";
		$consulta.= " AND t2.fecha_hora = t3.fecha_hora AND t2.rut_funcionario = t3.rut_funcionario";
		$consulta.= " AND t2.recargo = t3.recargo";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t4";
		$consulta.= " ON t1.id_analisis = t4.id_muestra AND t1.cod_producto = t4.cod_producto";
		$consulta.= " AND t1.cod_subproducto = t4.cod_subproducto";
		$consulta.= " AND t4.cod_periodo = '1' AND t4.recargo = '1'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
		$consulta.= " ON t4.cod_producto = t5.cod_producto AND t4.cod_subproducto = t5.cod_subproducto";
		$consulta.= " AND t4.nro_solicitud = t5.nro_solicitud AND t4.id_muestra = t5.id_muestra";
		$consulta.= " AND t4.fecha_hora = t5.fecha_hora AND t4.rut_funcionario = t5.rut_funcionario";
		$consulta.= " AND t4.recargo = t5.recargo AND t5.cod_leyes = '01'";	
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";									
		$consulta.= " WHERE t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.fecha_produccion BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " AND (t3.cod_leyes IN ('02', '04', '05', '08', '09', '39') OR ISNULL(t3.cod_leyes))";	
		$consulta.= " ORDER BY t1.fecha_produccion, t1.id_analisis, t1.numero, t3.cod_leyes";	
						
		mysqli_query($link, $consulta); //Se executa para llenar las tablas.		
	}

	$consulta = "SELECT t1.fecha AS fecha_produccion,t1.num_cajon AS numero,t1.lote AS id_analisis, t1.cod_leyes, t1.valor, t1.peso_seco, t1.peso_humedo, t1.humedad, t1.conversion AS unidad, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";										
	$consulta.= " ORDER BY t1.fecha, t1.lote, t1.num_cajon, t1.cod_leyes";
	 
	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0, '08'=>0, '09'=>0, '39'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>1000, '05'=>1000, '08'=>100, '09'=>100, '39'=>100);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$CantidadReg = 0; 
	//---.		
			
	$NumAnt = 0;
	$Cont = 0;			
	$rs = mysqli_query($link, $consulta);	
	while($row = mysqli_fetch_array($rs))
	{
		if ($NumAnt != $row["numero"])
		{
			$NumAnt = $row["numero"];
				
			echo '<tr>';
			echo '<td>'.$row[fecha_produccion].'</td>';
			echo '<td align="center">'.$row["numero"].'</td>';
			echo '<td align="center">'.$row[id_analisis].'</td>';
			echo '<td align="right">'.number_format($row[peso_humedo],2,"","").'</td>';
			echo '<td align="right">'.number_format($row[humedad],2,",","").'</td>';		
			echo '<td align="right">'.number_format($row[peso_seco],2,",","").'</td>';
			
			//---.
			$TotalPesoHumedo = $TotalPesoHumedo + $row[peso_humedo];
			$TotalHumedad = $TotalHumedad + $row[humedad];
			$TotalPesoSeco = $TotalPesoSeco + $row[peso_seco];
			$CantidadReg++;			
			//---.			
		}
		
		if ($row["cod_leyes"] == "")
		{
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';			
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';					
		}
		else
		{
			if ($TipoCalculo == "L")
				echo '<td align="right">'.number_format($row["valor"],2,",","").'</td>';		
			else
				echo '<td align="right">'.number_format($row[fino],4,",","").'</td>';
			$Cont++;
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.					
		}

		if ($Cont == 6)
		{
			echo '</tr>';		
			$Cont = 0;
		}		
	}
	
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="3">TOTALES</td>';
	echo '<td align="right">'.number_format($TotalPesoHumedo,3,",","").'</td>';
	if ($CantidadReg == 0)
		echo '<td align="right">0,000</td>';
	else
		echo '<td align="right">'.number_format(($TotalHumedad/$CantidadReg),3,",","").'</td>';
	echo '<td align="right">'.number_format($TotalPesoSeco,3,",","").'</td>';
	
	if ($TipoCalculo == "L")
	{
		if ($TotalPesoSeco == 0)
		{
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';					
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';		
		}
		else
		{
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),3,",","").'</td>';					
			echo '<td align="right">'.number_format(($Finos['08'] / $TotalPesoSeco * $Unidad['08']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['09'] / $TotalPesoSeco * $Unidad['09']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['39'] / $TotalPesoSeco * $Unidad['39']),3,",","").'</td>';				
		}
	}
	else
	{	
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';	
		echo '<td align="right">'.number_format($Finos['08'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['09'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['39'],3,",","").'</td>';			
	}
	
	echo '</tr>';	
	//---.	
?>
</table>
</form>
</html>
