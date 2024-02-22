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
		f.action = "pmn_con_balance_produccion_teluro.php?proceso=G";
		f.submit();
	}
}
/******************/
function Imprimir()
{
	window.print();
}
/*****************/
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
<strong>Informe: Embarque De Plata<br>
Periodo: <?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?>
</strong>
<br><br>

<?php
	//Consulta Si el Mes-Ao esta Bloqueado, si esta Bloqueado(1), entonces se rescatan los datos de una tabla ya creada.
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

<br>
  <table width="850" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr class="ColorTabla01"> 
      <td width="100" rowspan="2" align="center">Fecha</td>
      <td width="60" rowspan="2" align="center">Num. Acta</td>
      <td width="60" rowspan="2" align="center">Cantidad</td>
      <td width="150" rowspan="2" align="center">Elect.</td>
      <td width="100" rowspan="2" align="center">Peso </td>
       <td colspan="7" align="center"> 
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
    <td width="61" align="center">Ag (%)</td>
    <td width="66" align="center">Cu (ppm)</td>
    <td width="68" align="center">Bi (ppm)</td>
    <td width="62" align="center">Fe (ppm)</td>
    <td width="66" align="center">Pb (ppm)</td>
    <td width="65" align="center">Se (ppm)</td>
	<td width="65" align="center">Cd (ppm)</td>
    <?php
	}
	else
	{
?>
    <td width="61" align="center">Ag (Kg)</td>
    <td width="66" align="center">Cu (Kg)</td>
    <td width="68" align="center">Bi (Kg)</td>
    <td width="62" align="center">Fe (Kg)</td>
    <td width="66" align="center">Pb (Kg)</td>
    <td width="65" align="center">Se (Kg)</td>
	<td width="65" align="center">Cd (Kg)</td>
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
		
		$consulta.= " SELECT t1.fecha, '".$cmbmovimiento."' AS tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";	
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, t1.num_acta AS lote, '' AS tambor, '' AS id_muestra,";										
		$consulta.= " '' AS peso_humedo, '' AS humedad, t1.peso AS peso_seco, 'N' AS bloqueado,";
		$consulta.= " CASE WHEN t4.cod_leyes = '04' THEN 100 ELSE 1000000 END AS conversion,";								
		$consulta.= " '' AS num_cajon, '' AS horanada, '' AS num_barra, '' AS num_electrolisis, t1.cantidad AS num_anodos,";				
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t4.cod_leyes,";
		$consulta.= " CASE WHEN t4.cod_leyes = '04' THEN '99.99' ELSE (SUM(((t2.cantidad * 100 / t1.cantidad) * t1.peso / 100) * t5.valor / 1000000) * 1000000 / t1.peso) END AS valor,";
		$consulta.= " CASE WHEN t4.cod_leyes = '04' THEN '0.9999' * t1.peso ELSE ROUND(SUM(((t2.cantidad * 100 / t1.cantidad) * t1.peso / 100) * t5.valor / 1000000) + 0.0001,3) END AS fino";
		
		$consulta.= " FROM pmn_web.embarque_plata AS t1";
		$consulta.= " LEFT JOIN pmn_web.detalle_embarque_plata AS t2";
		$consulta.= " ON t1.num_acta = t2.num_acta AND YEAR(t1.fecha) = t2.ano AND MONTH(t1.fecha) = LPAD(t2.mes,2,'0')";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t3";
		$consulta.= " ON t2.num_electrolisis = t3.id_muestra AND t3.cod_producto = '".$cmbproducto."' AND t3.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t3.cod_periodo = '1' AND t3.agrupacion = '5'";
		$consulta.= " LEFT JOIN proyecto_modernizacion.leyes AS t4";
		$consulta.= " ON t4.cod_leyes IN ('02','04','27','31', '39', '40', '58')";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
		$consulta.= " ON t3.cod_producto = t5.cod_producto AND t3.cod_subproducto = t5.cod_subproducto";
		$consulta.= " AND t3.nro_solicitud = t5.nro_solicitud AND t3.id_muestra = t5.id_muestra";
		$consulta.= " AND t3.fecha_hora = t5.fecha_hora AND t3.rut_funcionario = t5.rut_funcionario AND t4.cod_leyes = t5.cod_leyes";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";				
		$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
		$consulta.= " GROUP BY t1.num_acta, t4.cod_leyes";			
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
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, t1.id AS lote, '' AS tambor, '' AS id_muestra,";
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

	$consulta = "SELECT t1.fecha, t1.lote AS num_acta, t1.num_anodos AS cantidad, t1.peso_seco, t1.cod_leyes, t1.valor, t1.conversion, t1.fino, CASE WHEN t1.cod_leyes = '04' THEN 1 ELSE 2 END AS orden";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";	
	$consulta.= " ORDER BY t1.fecha, t1.lote, orden, cod_leyes";	
	
	//---.
	$Finos = array('04'=>'','02'=>'', '27'=>'', '31'=>'', '39'=>'', '40'=>'', '58'=>''); //Cu-Bi-Fe-Pb-Se-Cd.
	$Unidad = array('04'=>100,'02'=>1000000, '27'=>1000000, '31'=>1000000, '39'=>1000000, '40'=>1000000, '58'=>1000000);
	$TotalCantidad = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$CantidadReg = 0; 
	//---.	
	
	$NumAnt = "";
	$Cont = 0;	
	$rs = mysqli_query($link, $consulta);	
	while ($row = mysqli_fetch_array($rs))
	{
		if ($NumAnt != $row[num_acta])
		{
			$NumAnt = $row[num_acta];		
	
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			echo '<td align="center">'.$row[num_acta].'</td>';
			echo '<td align="right">'.number_format($row[cantidad],0,",","").'</td>';						
			
			$consulta = "SELECT * FROM pmn_web.detalle_embarque_plata";
			$consulta.= " WHERE ano = YEAR('".$row["fecha"]."') AND mes = MONTH('".$row["fecha"]."') AND num_acta = '".$row[num_acta]."'";
			$rs1 = mysqli_query($link, $consulta);
			$VectorElect = array();
			while($row1 = mysqli_fetch_array($rs1))
			{
				$VectorElect[] = $row1[num_electrolisis];
			}
			echo '<td>'.implode('/', $VectorElect).'</td>';			
			echo '<td align="right">'.number_format($row[peso_seco],3,",","").'</td>';											

			//---.
			$TotalPesoSeco = $TotalPesoSeco + $row[peso_seco];			
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
			echo '<td>&nbsp;</td>';																	
		}
		else
		{
			if ($TipoCalculo == "L")
				echo '<td align="right">'.number_format($row["valor"],2,",","").'</td>';		
			else
				echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
			$Cont++;
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.				
		}

		if ($Cont == 7)
		{
			echo '</tr>';		
			$Cont = 0;
		}		
	}
	
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="4">TOTALES</td>';
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
			echo '<td align="right">0,000</td>';					
		}
		else
		{
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['27'] / $TotalPesoSeco * $Unidad['27']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['31'] / $TotalPesoSeco * $Unidad['31']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['39'] / $TotalPesoSeco * $Unidad['39']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['40'] / $TotalPesoSeco * $Unidad['40']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['58'] / $TotalPesoSeco * $Unidad['58']),3,",","").'</td>';		
		}
	}
	else
	{
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['27'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['31'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['39'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['40'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['58'],3,",","").'</td>';					
	}
	
	echo '</tr>';	
	//---.		
?>
  </table>
</form>
</html>
