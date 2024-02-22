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
<title>Recepcion Barro Anodico Des.Codelco</title>
<?php	
	//<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
?>
<script language="JavaScript">
function Abrir()
{	
	var f = frmListado;	
	if (confirm("Esta Seguro De Abrir El Mes, Para Ser Modificado"))
	{
		linea = "&FechaIni=" + f.FechaIni.value + "&FechaFin=" + f.FechaFin.value;
		linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
		linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value + "&TipoCalculo=" +f.TipoCalculo.value;
		window.open("ing_cierra_mes_popup.php?proceso=AL" + linea, "","top=200 left=200 menubar=no resizable=no width=403 height=205");		
	}
}
/******************/
function Guardar()
{ 
	var f = document.frmListado;
	
	if (confirm("Esta Seguro De Guardar Los Datos Para Cerrar"))	
	{	
		f.action = "pmn_con_balance_recepcion_bad_codelco.php?proceso=G";
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

	var linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value;
	
	document.location = "pmn_con_tipo_movimiento.php?" + linea;
}
</script>
</head>
<?php	
	//<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
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
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="113">Informe</td>
	<?php
		
		$consulta3 ="select * from proyecto_modernizacion.subproducto where cod_producto = '".$cmbproducto."' and cod_subproducto = '".$cmbsubproducto."'"; 
		$Resp2 = mysqli_query($link, $consulta3);
		if ($Row2 = mysqli_fetch_array($Resp2))
		{
			$desc = $Row2["descripcion"];
			
		}
	?>          
	
    <td width="468" align="left">Recepci�n Barro Anodico Externo <?php echo '- '.$desc ?></td>     
  </tr>
  <tr> 
    <td>Periodo</td>
    <td align="left"><?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?></td>
  </tr>
</table>
<br>
<table width="1300" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01"> 
    <td width="80" rowspan="2" align="center">Fecha</td>
    <td width="77" rowspan="2" align="center">Id. Muestra</td>
    <td width="75" rowspan="2" align="center">Lote N&ordm;</td>
    <td width="49" rowspan="2" align="center">Tambor</td>
	<td width="75" rowspan="2" align="center">Peso Bruto</td>
    <td width="81" rowspan="2" align="center">Peso Humedo</td>
	    
      <td width="75" rowspan="2" align="center">H2O</td>
      <td width="66" rowspan="2" align="center">Peso Seco</td>
	<td colspan="11" align="center">
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
    <td width="46" align="center">Cu<br>(%)</td>
    <td width="77" align="center">Ag<br>
        (g/T)</td>
    <td width="60" align="center">Au<br>
        (g/T)</td>
    <td width="45" align="center">As<br>(%)</td>
    <td width="43" align="center">Sb<br>(%)</td>
      <td width="48" align="center">S<br>
        (%)</td>
      <td width="47" align="center">Pt<br>
        (ppm)</td>
      <td width="46" align="center">Pd<br>
        (ppm)</td>
      <td width="42" align="center">Pb<br>
        (%)</td>
      <td width="42" align="center">Se<br>
        (%)</td>
      <td width="47" align="center">Te<br>
        (%)</td>
<?php
	}
	else
	{
?>
    <td width="46" align="center">Cu<br>(Kg)</td>
    <td width="77" align="center">Ag<br>(Kg)</td>
    <td width="60" align="center">Au<br>(Kg)</td>
    <td width="45" align="center">As<br>(Kg)</td>
    <td width="43" align="center">Sb<br>(Kg)</td>
    <td width="48" align="center">S<br>(Kg)</td>
    <td width="47" align="center">Pt<br>(Kg)</td>
    <td width="46" align="center">Pd<br>(Kg)</td>
    <td width="42" align="center">Pb<br>(Kg)</td>
    <td width="42" align="center">Se<br>(Kg)</td>
    <td width="47" align="center">Te<br>(Kg)</td>	
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
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, t1.id_producto AS lote, t1.referencia AS tambor, t2.id_muestra, (t1.peso_bruto - t1.peso_resta) AS peso_humedo,";
		$consulta.= " ROUND(t3.valor + 0.001,2) AS humedad, ROUND(((t1.peso_bruto - t1.peso_resta) - ((t1.peso_bruto - t1.peso_resta) * IFNULL(ROUND(t3.valor + 0.001,2),0) / 100)) + 0.0001,3) AS peso_seco, ";
		$consulta.= " 'N' AS bloqueado, CASE WHEN t5.cod_leyes IN ('04','05','37','38') THEN 1000000 ELSE 100 END AS conversion, ";
		$consulta.= " '' AS num_caja, '' AS hornada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t5.cod_leyes, t5.valor, ROUND((t5.valor * ROUND(((t1.peso_bruto - t1.peso_resta) - ((t1.peso_bruto - t1.peso_resta) * IFNULL(ROUND(t3.valor + 0.001,2),0) / 100)) + 0.0001,3) / CASE WHEN t5.cod_leyes IN ('04','05','37','38') THEN 1000000 ELSE 100 END),3) AS fino ";				

		$consulta.= " FROM pmn_web.productos_externos AS t0 inner join pmn_web.detalle_productos_externos AS t1";
		$consulta.= " on t0.cod_producto=t1.cod_producto and t0.cod_subproducto=t1.cod_subproducto ";
		$consulta.= " and t0.id_producto=t1.id_producto ";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON  t1.cod_producto = t2.cod_producto";
		$consulta.= " AND t1.cod_subproducto = t2.cod_subproducto";
		$consulta.= " AND t2.id_muestra=t0.lote_ventana";
		$consulta.= " AND t2.cod_periodo = '1' AND t2.agrupacion = '1' and year(t2.fecha_muestra)='".$ano1."' ";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.id_muestra = t3.id_muestra";
		$consulta.= " AND t2.recargo = t3.recargo AND t2.fecha_hora = t3.fecha_hora";
		$consulta.= " AND t2.rut_funcionario = t3.rut_funcionario";
		$consulta.= " AND t2.cod_producto = t3.cod_producto"; 
		$consulta.= " AND t2.cod_subproducto = t3.cod_subproducto";	
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t4";
		$consulta.= " ON t0.lote_ventana = t4.id_muestra AND t1.cod_producto = t4.cod_producto";
		$consulta.= " AND t1.cod_subproducto = t4.cod_subproducto AND t4.recargo = '0'";
		$consulta.= " AND t4.cod_periodo = '1' AND t4.agrupacion = '1' and year(t4.fecha_muestra)='".$ano1."' ";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
		$consulta.= " ON t4.nro_solicitud = t5.nro_solicitud AND t4.id_muestra = t5.id_muestra";
		$consulta.= " AND t4.recargo = t5.recargo AND t4.fecha_hora = t5.fecha_hora";
		$consulta.= " AND t4.rut_funcionario = t5.rut_funcionario AND t4.cod_producto = t5.cod_producto";
		$consulta.= " AND t4.cod_subproducto = t5.cod_subproducto";	
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";		
		$consulta.= " WHERE t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " AND (t2.recargo != 0 OR ISNULL(t2.recargo)) AND (t3.cod_leyes = '01' OR ISNULL(t3.cod_leyes))";
		$consulta.= " ORDER BY t1.fecha, t1.id_producto, CEILING(t1.referencia), t5.cod_leyes";
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
		$consulta.= " peso_total double(10,4), peso_muestra double(10,4), cod_leyes char(3), valor double(10,5), )";
				
		//Se Incluye datos de la otra tabla (Productos Por Movimientos).
		$consulta.= " SELECT t1.fecha, t1.tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, '' AS lote, t1.id AS tambor, '' AS id_muestra,";
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

	$consulta = "SELECT T1.fecha, t1.lote AS id_producto, t1.tambor AS referencia, t1.id_muestra, t1.peso_humedo, t1.humedad, t1.peso_seco, t1.conversion AS unidad, t1.cod_leyes, t1.valor AS ley, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";
	$consulta.= " GROUP BY t1.fecha, t1.lote, CEILING(t1.tambor), t1.cod_leyes";
	$consulta.= " order BY t1.fecha, t1.lote, CEILING(t1.tambor), t1.cod_leyes";
	//echo $consulta."<br>";
	
	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0, '08'=>0, '09'=>0, '26'=>0, '37'=>0, '38'=>0, '39'=>0, '40'=>0, '44'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>1000000, '05'=>1000000, '08'=>100, '09'=>100, '26'=>100, '37'=>1000000, '38'=>1000000, '39'=>100, '40'=>100, '44'=>100);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$TotalPesoBruto = 0;
	$CantidadReg = 0; 
	//---.	
	
	$rs = mysqli_query($link, $consulta);	
	$ReferenciaAnt = "";
	$Cont = 0;
	while ($row = mysqli_fetch_array($rs))
	{		
		if ($ReferenciaAnt != $row[referencia])
		{
			
			$consulta1 = "select * from pmn_web.detalle_productos_externos";
			$consulta1.=" where cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta1.=" and fecha = '".$row["fecha"]."' and id_producto = '".$row[id_producto]."' and referencia = '".$row[referencia]."'";
			$rrw = mysqli_query($link, $consulta1);
			if ($row9 = mysqli_fetch_array($rrw))
				$pesob = $row9[peso_bruto];
			else
				$pesob = 0;	

			
			$ReferenciaAnt = $row[referencia];
		
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			if ($row[id_producto] == '')
			{
				echo '<td align="left" colspan="3">'.$row[referencia].'</td>';		
				
			}
			else
			{
				echo '<td align="center">'.$row["id_muestra"].'</td>';
				echo '<td align="center">'.$row[id_producto].'</td>';
				echo '<td align="center">'.$row[referencia].'</td>';				
			}
				
			echo '<td align="right">'.number_format($pesob,3,",","").'</td>';
			echo '<td align="right">'.number_format($row[peso_humedo],3,",","").'</td>';
			echo '<td align="right">'.number_format($row[humedad],2,",","").'</td>';			
			echo '<td align="right">'.number_format($row[peso_seco],3,",","").'</td>';				
			
			//---.
			$TotalPesoHumedo = $TotalPesoHumedo + $row[peso_humedo];
			$TotalHumedad = $TotalHumedad + $row[humedad];
			$TotalPesoBruto = $TotalPesoBruto + $pesob;
			$TotalPesoSeco = $TotalPesoSeco + $row[peso_seco];
			$CantidadReg++;			
			//---.				
		}
		
		if ($row["cod_leyes"] == "")
		{
			echo '<td>&nbsp;</td>';																					
		}
		else
		{
			if ($TipoCalculo == "L")
			{
				if (($row["cod_leyes"] == '04') or ($row["cod_leyes"] == '05') or ($row["cod_leyes"] == '37') or ($row["cod_leyes"] == '38'))
					echo '<td align="right">'.number_format($row["ley"],0,",","").'</td>';		
				else
					echo '<td align="right">'.number_format($row["ley"],3,",","").'</td>';		
			}
			else
				echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
			$Cont++;
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.						
		}
		
		if ($Cont == 11)
		{
			echo '</tr>';		
			$Cont = 0;
		}				
	}
	
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="4">TOTALES</td>';
	echo '<td align="right">'.number_format(($TotalPesoBruto),3,",","").'</td>';
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
			echo '<td align="right">0,000</td>';
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
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),3,",","").'</td>';					
			echo '<td align="right">'.number_format(($Finos['08'] / $TotalPesoSeco * $Unidad['08']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['09'] / $TotalPesoSeco * $Unidad['09']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['26'] / $TotalPesoSeco * $Unidad['26']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['37'] / $TotalPesoSeco * $Unidad['37']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['38'] / $TotalPesoSeco * $Unidad['38']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['39'] / $TotalPesoSeco * $Unidad['39']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['40'] / $TotalPesoSeco * $Unidad['40']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['44'] / $TotalPesoSeco * $Unidad['44']),3,",","").'</td>';		
		}
	}
	else	
	{
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['08'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['09'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['26'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['37'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['38'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['39'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['40'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['44'],3,",","").'</td>';							
	}
	
	echo '</tr>';	
	//---.		
?>
</table>
</form>
</html>
