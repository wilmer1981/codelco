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
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
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
		f.action = "pmn_con_balance_recepcion_metal_dore_ventana.php?proceso=G";
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
    <td width="468" align="left">Recepcion Metal Dore Propio</td>
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
	else
	{
		echo '<input name="btnabrir" type="button" value="Abrir Mes" style="width:70" onClick="Abrir()">';
	}	
?>	
	  <input name="btnimprimir" type="button" id="btnimprimir" value="Imprimr" style="width:70" onClick="Imprimir()"> 
      <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"> 
    </td>
  </tr>
</table>


<br>
<table width="800" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr class="ColorTabla01"> 
    <td width="82" rowspan="2" align="center">Fecha</td>
    <td width="89" rowspan="2" align="center">Hornada</td>
    <td width="83" rowspan="2" align="center">N&ordm; Anodos</td>
    <td width="97" rowspan="2" align="center">Peso</td>
    <td colspan="8" align="center">
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
    <td width="58" align="center">Cu<br>
      (%) </td>
    <td width="59" align="center">Ag<br>
      (%) <br>
    </td>
    <td width="63" align="center">Au<br>
      (%) </td>
    <td width="62" align="center">Bi<br>
      (ppm)</td>
    <td width="62" align="center">Pt<br>
      (ppm)</td>
    <td width="62" align="center">Pd<br>
      (ppm) </td>
    <td width="58" align="center">Se<br>
      (ppm)</td>
    <td width="63" align="center">Te<br>
      (ppm) </td>
<?php
	}
	else
	{
?>
    <td width="58" align="center">Cu<br>(Kg)</td>
    <td width="59" align="center">Ag<br>(Kg)</td>
	<td width="63" align="center">Au<br>(Kg)</td>
    <td width="62" align="center">Bi<br>(ppm)</td>
    <td width="62" align="center">Pt<br>(Kg)</td>
    <td width="62" align="center">Pd<br>(Kg)</td>
    <td width="58" align="center">Se<br>(Kg)</td>
    <td width="63" align="center">Te<br>(Kg)</td>
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
		$consulta.= " '' AS peso_humedo, '' AS humedad, t1.peso AS peso_seco, 'N' AS bloqueado,";
		$consulta.= " CASE WHEN t3.cod_leyes IN ('02','04','05') THEN 100 ELSE 1000000 END conversion,";
		$consulta.= " '' AS num_caja, t1.hornada, '' AS num_barra, '' AS num_electrolisis, t1.num_anodos,";
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t3.cod_leyes, t3.valor, (t3.valor * t1.peso / CASE WHEN t3.cod_leyes IN ('02','04','05') THEN 100 ELSE 1000000 END) AS fino";
			
		$consulta.= " FROM pmn_web.produccion_horno_trof AS t1";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON t2.cod_producto = '".$cmbproducto."' AND t2.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.hornada = t2.id_muestra";
		$consulta.= " AND t2.cod_periodo = '1' AND t2.agrupacion = '3'";
		$consulta.= " LEFT join cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.id_muestra = t3.id_muestra";
		$consulta.= " AND t2.cod_producto = t3.cod_producto AND t2.cod_subproducto = t3.cod_subproducto";
		$consulta.= " AND t2.rut_funcionario = t3.rut_funcionario AND t2.fecha_hora = t3.fecha_hora";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";						
		$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " ORDER BY t1.fecha, t1.hornada, t3.cod_leyes";				
		//echo $consulta."<br><br>";
			
		mysqli_query($link, $consulta); //Se executa para llenar las tablas.
		
		
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
		$consulta.= " '' AS num_caja, t1.id AS hornada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";					
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

	$consulta = "SELECT t1.fecha, t1.hornada, t1.num_anodos, t1.peso_seco AS peso, t1.cod_leyes, t1.valor, conversion AS unidad, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";				
	$consulta.= " ORDER BY t1.fecha, t1.hornada, t1.cod_leyes";
	//echo $consulta."<br>";						

	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0, '27'=>0, '37'=>0, '38'=>0, '40'=>0, '44'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>100, '05'=>100, '27'=>1000000, '37'=>1000000, '38'=>1000000, '40'=>1000000, '44'=>1000000);
	$TotalAnodos = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$CantidadReg = 0; 
	//---.
	
	$HornadaAnt = "";
	$Cont = 0;
	//echo $consulta;
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{		
		if ($HornadaAnt != $row["hornada"])
		{
			$HornadaAnt = $row["hornada"];			
			
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			if ($row[num_anodos] == 0)
			{
				echo '<td align="left" colspan="2">'.$row["hornada"].'</td>';
			}
			else
			{
				echo '<td align="center">'.$row["hornada"].'</td>';
				echo '<td align="right">'.number_format($row[num_anodos],0,",","").'</td>';			
			}
			echo '<td align="right">'.number_format($row["peso"],2,",","").'</td>';
			
			//---.
			$TotalAnodos = $TotalAnodos + $row[num_anodos];
			$TotalPesoSeco = $TotalPesoSeco + $row["peso"];			
			//---.			
		}
		
		if ($row["cod_leyes"] == "")
		{
			//echo '<td>&nbsp;</td>';
			//echo '<td>&nbsp;</td>';
			//echo '<td>&nbsp;</td>';
			//echo '<td>&nbsp;</td>';
			//echo '<td>&nbsp;</td>';
			//echo '<td>&nbsp;</td>';
			//echo '<td>&nbsp;</td>';									
		}
		else
		{
			if ($TipoCalculo == "L")
			{
				if (($row["cod_leyes"] == '02') or ($row["cod_leyes"] == '04') or ($row["cod_leyes"] == '05'))
					echo '<td align="right">'.number_format($row["valor"],2,",","").'</td>';
				else
					echo '<td align="right">'.number_format($row["valor"],0,",","").'</td>';
			}
			else
				echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
				
			$Cont++;
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.					
		}
		if ($Cont == 7)	
		{
			//echo '</tr>';
			$Cont = 0;
		}		
	}
	
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="2">TOTALES</td>';
	echo '<td align="right">'.number_format($TotalAnodos,3,",","").'</td>';	
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
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),3,",","").'</td>';					
			echo '<td align="right">'.number_format(($Finos['37'] / $TotalPesoSeco * $Unidad['37']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['38'] / $TotalPesoSeco * $Unidad['38']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['40'] / $TotalPesoSeco * $Unidad['40']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['44'] / $TotalPesoSeco * $Unidad['44']),3,",","").'</td>';				
		}
	}
	else
	{
	
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['37'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['38'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['40'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['44'],3,",","").'</td>';				
	}
	
	echo '</tr>';		
?> 
</table>
</body>
</html>
