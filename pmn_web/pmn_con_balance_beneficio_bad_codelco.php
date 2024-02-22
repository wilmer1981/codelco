<?php
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
<title>Sistema de Plamen</title>
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

	var linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
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
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="113">Informe</td>
    <td width="468" align="left">Beneficio Barro Anodico Externo - Codelco</td>
  </tr>
  <tr> 
    <td>Periodo</td>
    <td align="left"><?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?></td>
  </tr>
  <tr align="center"> 
    <td colspan="2"> 
<?php
	//Consulta Si el Mes-Ao esta Bloqueado, si esta Bloqueado(1), entonces se rescatan los datos de una tabla ya creada.
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
	  <input name="btnimprimir" type="button" id="btnimprimir" value="Imprimr" style="width:70" onClick="Imprimir()"> 
      <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"> 
    </td>
  </tr>
</table>


<br>
  <table width="950" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr class="ColorTabla01"> 
      <td width="72" rowspan="2" align="center">N&ordm; Lote</td>
      <td width="61" rowspan="2" align="center">N&ordm; tambor</td>
      <td width="78" rowspan="2" align="center">Hornada</td>
      <td width="75" rowspan="2" align="center">Fecha</td>
      <td width="75" rowspan="2" align="center">Id. Muestra</td>
      <td width="69" rowspan="2" align="center">Peso Humedo</td>
      <td width="50" rowspan="2" align="center">H<sub>2</sub>O(%)</td>
      <td width="77" rowspan="2" align="center">Peso Seco</td>
      <td width="70" rowspan="2" align="center">Total</td>
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
      <td width="77" align="center">Cu (%)</td>
      <td width="77" align="center">Ag (g/T)</td>
      <td width="70" align="center">Au (g/T)</td>
      <?php
	}
	else
	{
?>
    <td width="66" align="center">Cu (Kg)</td>
    <td width="74" align="center">Ag (Kg)</td>
    <td width="85" align="center">Au (Kg)</td>
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
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, t1.id_producto AS lote, t1.referencia AS tambor, trim(t2.id_muestra) as id_muestra,";							
		$consulta.= " t1.bad AS peso_humedo, t3.valor AS humedad, (t1.bad - (t1.bad * IFNULL(t3.valor,0) / 100)) AS peso_seco, 'N' AS bloqueado,";				
		$consulta.= " CASE WHEN t5.cod_leyes = '02' THEN 100 ELSE 1000000 END AS conversion,";				
		$consulta.= " '' AS num_caja, CONCAT(num_horno,'-',num_funda,'-',hornada_total,'-',hornada_parcial) AS horanada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t5.cod_leyes, t5.valor, (t5.valor * (t1.bad - (t1.bad * IFNULL(t3.valor,0) / 100)) / CASE WHEN t5.cod_leyes = '02' THEN 100 ELSE 1000000 END) AS fino";								
			
		$consulta.= " FROM pmn_web.detalle_deselenizacion AS t1";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON trim(t1.id_producto) = trim(t2.observacion)";
		$consulta.= " AND t1.cod_producto = t2.cod_producto";
		$consulta.= " AND t1.cod_subproducto = t2.cod_subproducto";
		$consulta.= " AND ((t2.recargo = '1' AND t1.referencia in ('1','2')) or";
		$consulta.= " (t2.recargo = '2' AND t1.referencia in ('3','4')) or";
		$consulta.= " (t2.recargo = '3' AND t1.referencia in ('5','6')) or";
		$consulta.= " (t2.recargo = '4' AND t1.referencia in ('7','8')) or";
		$consulta.= " (t2.recargo = '5' AND t1.referencia in ('9','10')))";
		$consulta.= " AND t2.cod_periodo = '1' AND t2.agrupacion = '1'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND trim(t2.id_muestra) = trim(t3.id_muestra)";
		$consulta.= " AND t2.recargo = t3.recargo AND t2.fecha_hora = t3.fecha_hora";
		$consulta.= " AND t2.rut_funcionario = t3.rut_funcionario";
		$consulta.= " AND t2.cod_producto = t3.cod_producto"; 
		$consulta.= " AND t2.cod_subproducto = t3.cod_subproducto";	
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t4";
		$consulta.= " ON (trim(t1.id_producto)*1) = (trim(t4.observacion)*1) AND t1.cod_producto = t4.cod_producto";
		$consulta.= " AND t1.cod_subproducto = t4.cod_subproducto AND t4.recargo = '0'";
		$consulta.= " AND t4.cod_periodo = '1' AND t4.agrupacion = '1'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
		$consulta.= " ON t4.nro_solicitud = t5.nro_solicitud AND trim(t4.id_muestra) = trim(t5.id_muestra)";
		$consulta.= " AND t4.recargo = t5.recargo AND t4.fecha_hora = t5.fecha_hora";
		$consulta.= " AND t4.rut_funcionario = t5.rut_funcionario AND t4.cod_producto = t5.cod_producto";
		$consulta.= " AND t4.cod_subproducto = t5.cod_subproducto";		
		$consulta.= " AND t5.cod_leyes IN ('02','04','05')";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";										
		$consulta.= " WHERE t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " AND (t2.recargo != 0 OR ISNULL(t2.recargo)) AND (t3.cod_leyes = '01' OR ISNULL(t3.cod_leyes))";
		$consulta.= " ORDER BY t1.fecha, trim(t1.id_producto), CEILING(t1.referencia), t5.cod_leyes";		
		//echo $consulta."<br><br>";				
			
		mysqli_query($link, $consulta); //Se executa para llenar las tablas.			
	}
	
	$consulta = "SELECT t1.fecha, t1.lote AS id_producto, hornada, t1.tambor AS referencia, t1.peso_humedo, trim(t1.id_muestra) as id_muestra, t1.humedad, t1.peso_seco, t1.cod_leyes, t1.valor AS ley, t1.conversion AS unidad, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";							
	$consulta.= " and t1.peso_humedo<>'0'";
	$consulta.= " ORDER BY t1.lote, lpad(t1.tambor,4,'0'), t1.cod_leyes";
	//echo "eeeee".$consulta."<br>";

	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>1000000, '05'=>1000000);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$TotalTotal = 0;
	$CantidadReg = 0; 
	//---.
	$ReferenciaAnt = "";
	$IdProductoAnt = "";
	$Cont = 0;	
  	$rs = mysqli_query($link, $consulta);
	//$TotalTambores = 0;
	while($row = mysqli_fetch_array($rs))
	{
		if ($IdProductoAnt != $row[id_producto])
		{
			$ReferenciaAnt = "";
			$IdProductoAnt = $row[id_producto];
			$consulta = "SELECT IFNULL(COUNT(DISTINCT t1.tambor),0) AS filas";
			$consulta.= " FROM pmn_web.resultado_productos AS t1";
			$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
			$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";							
			$consulta.= " AND t1.lote = '".$row[id_producto]."'";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$TotalFilas = $row1[filas];
			$TotalTambores = 0;
			$consulta = "SELECT SUM(peso_seco) AS total";
			$consulta.= " FROM pmn_web.resultado_productos AS t1";
			$consulta.= " WHERE t1.fecha BETWEEN '".$ano1."-".$mes1."-01' AND '".$ano1."-".$mes1."-31' AND t1.cod_producto = '".$cmbproducto."'";
			$consulta.= " AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."' and t1.lote = '".$row[id_producto]."'";
			$consulta.= " AND (cod_leyes = '02' or ISNULL(cod_leyes))";
			//echo $consulta."<br>";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$Total = $row2["total"];
			$sw = true;			
			echo '<tr>';
			echo '<td rowspan="'.$TotalFilas.'" align="center">'.$TotalFilas.' - '.$row[id_producto].'</td>';	
		}
		
		
		if ($ReferenciaAnt != $row[referencia])
		{
		//echo "aqui......".$ReferenciaAnt."-".$row[referencia];
			$ReferenciaAnt = $row[referencia];
			echo '<td align="center">'.$row[referencia].'</td>';
			$TotalTambores++;
			//echo "total".$TotalTambores;
			echo '<td align="center">'.$row["hornada"].'</td>';
			echo '<td align="center">'.$row["fecha"].'</td>';			
			echo '<td align="center">'.$row["id_muestra"].'</td>';		
			echo '<td align="right">'.number_format($row[peso_humedo],3,",","").'</td>';
			echo '<td align="right">'.number_format($row[humedad],2,",","").'</td>';
			echo '<td align="right">'.number_format($row[peso_seco],3,",","").'</td>';
			
			//---.
			$TotalPesoHumedo = $TotalPesoHumedo + $row[peso_humedo];
			$TotalHumedad = $TotalHumedad + $row[humedad];
			$TotalPesoSeco = $TotalPesoSeco + $row[peso_seco];
			$TotalTotal =  $TotalTotal + $row[peso_seco];
			$CantidadReg++;			
			//---.					
		}
		if ($sw == true)
		{					
			echo '<td rowspan="'.$TotalFilas.'" align="right">'.number_format($Total,3,",","").'</td>';
			$sw = false;			
		}		
		if ($row["cod_leyes"] == "")
		{
			echo '<td>&nbsp;</td>';		
			echo '<td>&nbsp;</td>';		
			echo '<td>&nbsp;</td>';
			$Cont = 3;																									
		}
		else
		{
			if ($ley_anterior != $row["cod_leyes"])
			{
				
				$ley_anterior = $row["cod_leyes"];
				if ($TipoCalculo == "L")
				{
					if ($row["cod_leyes"] == '02')
						echo '<td align="right">'.number_format($row["ley"],2,",","").'</td>';		
					else
						echo '<td align="right">'.number_format($row["ley"],0,",","").'</td>';		
				}
				else
					echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
				$Cont++;
				$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
								
				}
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
	echo '<td align="left" colspan="1">TOTALES</td>';
	echo '<td align="center" colspan="1">'.number_format($TotalTambores,0,',','.').'</td>';
	echo '<td align="left" colspan="3">&nbsp;</td>';
	echo '<td align="right">'.number_format($TotalPesoHumedo,3,",","").'</td>';
	if ($CantidadReg == 0)
		echo '<td align="right">0,00</td>';
	else
	echo '<td align="right">'.number_format(($TotalHumedad/$CantidadReg),2,",","").'</td>';
	echo '<td align="right">'.number_format($TotalPesoSeco,3,",","").'</td>';
	echo '<td align="right">'.number_format($TotalTotal,3,",","").'</td>';
	//echo '<td>&nbsp;</td>';
	
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
