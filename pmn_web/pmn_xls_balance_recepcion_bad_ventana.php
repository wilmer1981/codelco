<?php
	include("../principal/conectar_pmn_web.php");
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
	if ($proceso == "G")
	{			
		//Actualiza los campos Bloqueado y Hay_datos.
		$actualizar = "UPDATE pmn_web.resultado_productos SET bloqueado = 'S'";
		$actualizar.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' ";
		$actualizar.= " AND YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."'";
		mysqli_query($link, $actualizar);
		//echo $actualizar."<br>";
	}
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>

<body  leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
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
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="113" colspan="2">Informe</td>
    <td width="468" align="left" colspan="10">Ingreso Barro Anodico Descobrizado Por Refineria</td>
  </tr>
  <tr> 
    <td colspan="2">Periodo</td>
    <td align="left" colspan="10"><?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?></td>
  </tr>
</table>


<br>
<table width="700" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr class="ColorTabla01"> 
    <td width="73" rowspan="2" align="center">Fecha</td>
    <td width="79" rowspan="2" align="center">N&ordm; Lixiviacion</td>
    <td width="56" rowspan="2" align="center">N&ordm; Lix.</td>
    <td width="89" rowspan="2" align="center">Peso Humedo</td>
    <td width="48" rowspan="2" align="center">H<sub>2</sub>O</td>
    <td width="79" rowspan="2" align="center">Peso Seco</td>
    <td colspan="3" align="center">
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
	<td width="65" align="center">Cu (%)</td>
    <td width="66" align="center">Ag (K/T)</td>
    <td width="70" align="center">Au (K/T)</td>
<?php
	}
	else
	{
?>
	<td width="65" align="center">Cu (Kg.)</td>
    <td width="66" align="center">Ag (Kg.)</td>
    <td width="70" align="center">Au (Kg.)</td>
<?php
	}
?>	 
  </tr>
<?php
	/*
	OBS: EN EL CAMPO "LOTE", PARA ESTE FLUJO SE GUARDA UNA FECHA INDICANDO EL MES QUE SE CONSULTA, PARA PODER PESCAR EL DATO
		 EN EL ANEXO PMN, YA QUE FELIX CIERRA ESTE PRODUCTO POR LIXIVIACION, TOMANDO ALGUNAS QUE PASAN PARA EL PROXIMO MES.	
	*/
	
	$desde = '';
	$hasta = '';
	
	$consulta = "SELECT fecha, num_lixiviacion FROM pmn_web.corte_lixiviacion AS t1";
	$consulta.= " WHERE fecha = '".$FechaIni."' OR fecha = SUBDATE('".$FechaIni."', INTERVAL 1 MONTH)";
	$consulta.= " ORDER BY fecha";
	$rs1 = mysqli_query($link, $consulta);
	while ($row1 = mysqli_fetch_array($rs1))
	{
		if ($desde == '')
               {
			$fecha_ini = $row1["fecha"];
			$desde = $row1[num_lixiviacion];
			$desde2 = $row1[num_lixiviacion] + 1;
                }
		else
			$hasta = $row1[num_lixiviacion];

          }
		if ($desde < $hasta)
			$consulta2 = " and CEILING(t1.num_lixiviacion) > '".$desde."' AND CEILING(t1.num_lixiviacion) <= '".$hasta."'";
			else
			$consulta2 =" and (( CEILING(t1.num_lixiviacion) BETWEEN  '".$desde2."' and '1000') or (CEILING(t1.num_lixiviacion) BETWEEN  '1' and  '".$hasta."'))";
		
		
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
		
		$consulta.= " SELECT t1.fecha, '".$cmbmovimiento."' AS tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";
		$consulta.= " t9.flujo, t1.num_lixiviacion, t1.lixiviador, '".$FechaIni."' AS lote, '' AS tambor, '' AS id_muestra,";
		$consulta.= " t1.bad, t1.porc_agua, ROUND((t1.bad - (t1.bad * t1.porc_agua / 100)) + 0.0001,3) AS peso_seco,";
		$consulta.= " 'N' AS bloqueado, CASE WHEN t3.cod_leyes = '02' THEN 100 ELSE 1000 END AS unidad,";								
		$consulta.= " '' AS num_caja, '' AS hornada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t3.cod_leyes, t3.valor, ROUND((t3.valor * ROUND((t1.bad - (t1.bad * t1.porc_agua / 100)) + 0.0001,3) / CASE WHEN t3.cod_leyes = '02' THEN 100 ELSE 1000 END) + 0.0001,4) AS fino";
					
		$consulta.= " FROM pmn_web.lixiviacion_barro_anodico AS t1";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON t2.cod_producto = '".$cmbproducto."' AND t2.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.num_lixiviacion = t2.id_muestra  AND t2.cod_periodo = '1' AND t2.agrupacion = '4'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.id_muestra = t3.id_muestra";
		$consulta.= " AND t2.cod_producto = t3.cod_producto AND t2.cod_subproducto = t3.cod_subproducto";
		$consulta.= " AND t2.fecha_hora = t3.fecha_hora AND t2.rut_funcionario = t3.rut_funcionario";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";
		$consulta.= " WHERE (t3.cod_leyes IN ('02','04','05') OR ISNULL(t3.cod_leyes))";
		$consulta.= $consulta2;
		$consulta.= " and t1.fecha >='".$fecha_ini."'";
		$consulta.= " ORDER BY t1.fecha, t1.num_lixiviacion, t3.cod_leyes";
		mysqli_query($link, $consulta);
		
		//----.
		//Llena tabla resultado_productos.
		$consulta = "CREATE TABLE IF NOT EXISTS pmn_web.resultado_productos ";
		$consulta.= " (fecha date, tipo_mov char(3), cod_producto varchar(10), cod_subproducto varchar(10),";
		$consulta.= " correlativo int(10), flujo int(3), num_lixiviacion varchar(20), lixiviador varchar(20),";
		$consulta.= " lote varchar(20), tambor varchar(20), id_muestra varchar(20),";
		$consulta.= " peso_humedo double(10,4), humedad double(10,4), peso_seco double(10,4),";
		$consulta.= " bloquedo char(1), conversion int(10), num_caja varchar(20), hornada varchar(20),";
		$consulta.= " num_barra varchar(20), num_electrolisis varchar(20), num_anodos double(10,4),";
		$consulta.= " peso_total double(10,4), peso_muestra double(10,4), cod_leyes char(3), valor double(10,5), fino double(10,5))";
				
		//Se Incluye datos de la otra tabla (Productos Por Movimientos).
		$consulta.= " SELECT t1.fecha, t1.tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";
		$consulta.= " t9.flujo, t1.id AS num_lixiviacion, '' AS lixiviador, '".$FechaIni."' AS lote, '' AS tambor, '' AS id_muestra,";
		$consulta.= " '' AS peso_humedo, '' AS humedad, CASE WHEN t1.signo = '-' THEN (-1 * t1.peso_seco) ELSE t1.peso_seco END AS peso_seco,";		
		$consulta.= " 'N' AS bloqueado,";		
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN t1.unid_cu ELSE";
		$consulta.= " CASE WHEN t2.cod_leyes = '04' THEN t1.unid_ag ELSE";
		$consulta.= " CASE WHEN t2.cod_leyes = '05' THEN t1.unid_au END END END AS unidad,";
		$consulta.= " '' AS num_caja, '' AS hornada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";					
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t2.cod_leyes, ";				
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN CASE WHEN t1.signo_cu = '-' THEN -1 * (t1.fino_cu * unid_cu / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) ELSE (t1.fino_cu * unid_cu / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) END";
		$consulta.= " ELSE CASE WHEN t2.cod_leyes = '04' THEN CASE WHEN t1.signo_ag = '-' THEN -1 * (t1.fino_ag * unid_ag / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) ELSE (t1.fino_ag * unid_ag / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) END";
		$consulta.= " ELSE CASE WHEN t2.cod_leyes = '05' THEN CASE WHEN t1.signo_au = '-' THEN -1 * (t1.fino_au * unid_au / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) ELSE (t1.fino_au * unid_au / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) END";
		$consulta.= " END END END AS valor,";		
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN (CASE WHEN t1.signo_cu = '-' THEN -1 * t1.fino_cu ELSE t1.fino_cu END) ELSE CASE WHEN t2.cod_leyes = '04' THEN (CASE WHEN t1.signo_ag = '-' THEN -1 * t1.fino_ag ELSE t1.fino_ag END) ELSE CASE WHEN t2.cod_leyes = '05' THEN (CASE WHEN t1.signo_au = '-' THEN -1 * t1.fino_au ELSE t1.fino_au END) END END END AS fino";
						
		$consulta.= " FROM pmn_web.productos_por_movimientos AS t1";
		$consulta.= " LEFT JOIN proyecto_modernizacion.leyes AS t2";
		$consulta.= " ON t2.cod_leyes IN ('02', '04', '05')";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = t1.tipo_mov";				
		$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov In ('".$cmbmovimiento."')";	
		$consulta.= " ORDER BY t1.id,t2.cod_leyes";
		mysqli_query($link, $consulta);
	}


	$consulta = "SELECT fecha, num_lixiviacion, lixiviador, peso_humedo AS bad, humedad AS porc_agua, cod_leyes, valor, fino, peso_seco, flujo";
	$consulta.= " FROM pmn_web.resultado_productos";
	$consulta.= " WHERE lote = '".$FechaIni."'";
	$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov IN ('".$cmbmovimiento."')";	
	$consulta.= " ORDER BY fecha,num_lixiviacion, cod_leyes";
	
	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>1000, '05'=>1000);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$CantidadReg = 0; 
	//---.
		
	$NumAnt = "";
	$Cont = 0;
	$rs = mysqli_query($link, $consulta);  
  	while ($row = mysqli_fetch_array($rs))	
	{	
		if ($NumAnt != $row[num_lixiviacion])
		{
			$NumAnt = $row[num_lixiviacion];
			
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			if ($row[lixiviador] == '')				
				echo '<td align="left" colspan="2">'.$row[num_lixiviacion].'</td>';
			else
			{
				echo '<td align="center">'.$row[num_lixiviacion].'</td>';
				echo '<td align="center">'.$row[lixiviador].'</td>';
			}
				
			echo '<td align="right">'.number_format($row[bad],3,",","").'</td>';
			echo '<td align="right">'.number_format($row[porc_agua],2,",","").'</td>';
			echo '<td align="right">'.number_format($row[peso_seco],3,",","").'</td>';
			
			//---.
			$TotalPesoHumedo = $TotalPesoHumedo + $row[bad];
			$TotalHumedad = $TotalHumedad + $row[porc_agua];
			$TotalPesoSeco = $TotalPesoSeco + $row[peso_seco];
			$CantidadReg++;			
			//---.
		}
		
		if ($row["cod_leyes"] == "")
		{
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';								
		}
		else
		{
			if ($TipoCalculo == "L")			
				echo '<td align="right">'.number_format($row["valor"],3,",","").'</td>';
			else 
				echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
			$Cont++;
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.
		}
		
		if ($Cont == 3)
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
		echo '<td align="right">0,00</td>';
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
		}
		else
		{
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),3,",","").'</td>';					
		}
	}
	else
	{
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';	
	}
	
	echo '</tr>';	
	//---.
?>

</table>
</form>
</body>
</html>
