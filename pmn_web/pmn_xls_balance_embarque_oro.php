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
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Guardar()
{
	var f = document.frmListado;
	
	if (confirm("Esta Seguro De Guardar Los Datos Para Cerrar"))	
	{	
		f.action = "pmn_con_balance_beneficio_bad_codelco.php?proceso=G";
		f.submit();
	}
}
/******************/
function Imprimir()
{
	window.print();
}
/****************/
function Salir()
{
	var f = document.frmListado;

	var linea = "recargapag1=S&recargapag2=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value;
	
	document.location = "pmn_con_tipo_movimiento.php?" + linea;
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
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
<strong>Informe: Embarque De Oro<br>
Periodo: <?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?>
</strong>
<br><br>

<?php
	//Consulta Si el Mes-A�o esta Bloqueado, si esta Bloqueado(1), entonces se rescatan los datos de una tabla ya creada.
	$consulta = "SELECT CASE WHEN COUNT(*) != 0 THEN 'N' ELSE 'S' END AS activar FROM pmn_web.resultado_productos";
	$consulta.= " WHERE YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."' AND bloqueado = 'S'";
	$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov = '".$cmbmovimiento."'";	
	//echo $consulta."<br>";
	$rs5 = mysqli_query($link, $consulta);
	$row5 = mysqli_fetch_array($rs5);
	$Activar = $row5[activar];
		
	if ($Activar == "S")
	{
		echo '<input name="btnguardar" type="button" id="btnguardar" value="Guardar" style="width:70" onClick="Guardar()">';
		
		$eliminar = "DELETE FROM pmn_web.resultado_productos";
		$eliminar.= " WHERE YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."'";
		$eliminar.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov = '".$cmbmovimiento."'";			
		//echo $eliminar."<br>";
		mysqli_query($link, $eliminar);
	}
?>
<table width="800" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr class="ColorTabla01"> 
    <td width="77" rowspan="2" align="center">Fecha</td>
      <td width="84" rowspan="2" align="center">Num. Barra</td>
      <td width="90" rowspan="2" align="center">Num. Electrolisis</td>
    <td width="92" rowspan="2" align="center">Peso</td>
    <td colspan="5" align="center">
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
    <td width="77" align="center">Au (%)</td>
    <td width="74" align="center">Cu (ppm)</td>
    <td width="80" align="center">Ag (ppm)</td>
    <td width="72" align="center">Fe (ppm)</td>
    <td width="80" align="center">Pd (ppm)</td>
<?php
	}
	else
	{
?>
    <td width="77" align="center">Au (Kg)</td>
    <td width="74" align="center">Cu (Kg)</td>
    <td width="80" align="center">Ag (Kg)</td>
    <td width="72" align="center">Fe (Kg)</td>
    <td width="80" align="center">Pd (Kg)</td>
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
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, '' AS lote, '' AS tambor, '' AS id_muestra,";										
		$consulta.= " '' AS peso_humedo, '' AS humedad, t1.peso_neto_barra AS peso_seco, 'N' AS bloqueado, CASE WHEN t8.cod_leyes = '05' THEN 100 ELSE 1000000 END AS conversion,";								
		$consulta.= " '' AS num_cajon, '' AS horanada, t1.num_barra AS num_barra, CASE WHEN (t2.num_electrolisis = '') OR ISNULL(t2.num_electrolisis) THEN 'ND' ELSE t2.num_electrolisis END AS num_electrolisis, '' AS num_anodos,";				
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t8.cod_leyes, CASE WHEN t8.cod_leyes = '05' THEN '99.99' ELSE t4.valor END AS valor";
		$consulta.= ", (CASE WHEN t8.cod_leyes = '05' THEN '99.99' ELSE t4.valor END * t1.peso_neto_barra / CASE WHEN t8.cod_leyes = '05' THEN 100 ELSE 1000000 END) AS fino";
			
		$consulta.= " FROM pmn_web.embarque_oro AS t1";
		$consulta.= " LEFT JOIN pmn_web.carga_fusion_oro AS t2";
		$consulta.= " ON t1.num_barra = t2.num_barra";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t3";
		$consulta.= " ON t3.cod_producto = '".$cmbproducto."' AND t3.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t2.num_electrolisis = t3.id_muestra AND t3.cod_periodo = '1' AND t3.agrupacion = '5' AND t3.estado_actual = '6'";
		$consulta.= " LEFT JOIN proyecto_modernizacion.leyes AS t8";
		$consulta.= " ON t8.cod_leyes IN ('02', '04', '31', '38', '05')";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t4";
		$consulta.= " ON t3.cod_producto = t4.cod_producto AND t3.cod_subproducto = t4.cod_subproducto";
		$consulta.= " AND t3.nro_solicitud = t4.nro_solicitud AND t3.id_muestra = t4.id_muestra";
		$consulta.= " AND t3.fecha_hora = t4.fecha_hora AND t3.rut_funcionario = t4.rut_funcionario";	
		$consulta.= " AND t8.cod_leyes = t4.cod_leyes"; 		
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";																					
		$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " GROUP BY t1.fecha, t1.num_barra, t8.cod_leyes";
		$consulta.= " ORDER BY t1.fecha, t1.num_barra, t8.cod_leyes";
		//echo $consulta."<br><br>";
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
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, '' AS lote, '' AS tambor, '' AS id_muestra,";
		$consulta.= " '' AS peso_humedo, '' AS humedad, CASE WHEN t1.signo = '-' THEN (-1 * t1.peso_seco) ELSE t1.peso_seco END AS peso_seco,";		
		$consulta.= " 'N' AS bloqueado,";		
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN t1.unid_cu ELSE";
		$consulta.= " CASE WHEN t2.cod_leyes = '04' THEN t1.unid_ag ELSE";
		$consulta.= " CASE WHEN t2.cod_leyes = '05' THEN t1.unid_au END END END AS unidad,";
		$consulta.= " '' AS num_caja, '' AS hornada, t1.id AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";					
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
		//echo $consulta."<br><br><br>";		
		mysqli_query($link, $consulta);									
	}	
	
	$consulta = "SELECT t1.fecha, t1.num_electrolisis, t1.num_barra, peso_seco AS peso, t1.cod_leyes, t1.valor, conversion AS unidad,";
	$consulta.= " CASE WHEN t1.cod_leyes = '05' THEN 1 ELSE 2 END AS orden, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";														
	$consulta.= " ORDER BY t1.fecha, t1.num_barra, orden, t1.cod_leyes";
	//echo $consulta."<br>";	
	
	//---.
	$Finos = array('05'=>0, '02'=>0, '04'=>0, '31'=>0, '38'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('05'=>100, '02'=>1000000, '38'=>1000000, '31'=>1000000, '04'=>1000000);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$CantidadReg = 0; 
	//---.	
	echo $consulta."<br>";
	$NumBarraAnt = "";
	$Cont = 0;
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		if ($NumBarraAnt != $row[num_barra])
		{	
			$NumBarraAnt = $row[num_barra];
			
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			if ($row[num_electrolisis] == '')
				echo '<td align="left" colspan="2">'.$row[num_barra].'</td>';			
			else
			{
				echo '<td align="center">'.$row[num_barra].'</td>';
				echo '<td align="center">'.$row[num_electrolisis].'</td>';
			}
			echo '<td align="right">'.number_format($row["peso"],4,",","").'</td>';			
			
			//---.
			$TotalPesoSeco = $TotalPesoSeco + $row["peso"];			
			//---.			
		}
		
		if ($row["cod_leyes"] == "")
		{			
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
		
		if ($Cont == 5)
		{
			echo '</tr>';		
			$Cont = 0;
		}		
	}
	
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="3">TOTALES</td>';
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
		}
		else
		{
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['38']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['31'] / $TotalPesoSeco * $Unidad['31']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['38'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';							
		}
	}
	else
	{
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['31'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['38'],3,",","").'</td>';			
	}
	
	echo '</tr>';	
	//---.		
?> 
</table>
</form>
</body>
</html>
